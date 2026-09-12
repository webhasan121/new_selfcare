<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', User::class);

        $search = trim((string) $request->query('search'));
        $users = User::query()
            ->with('roles:id,name')
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('contact', 'like', "%{$search}%");
            }))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    public function edit(Request $request, User $user): View
    {
        Gate::authorize('update', $user);
        $this->protectAdminFromNonAdmin($request->user(), $user);

        return view('users.edit', [
            'managedUser' => $user->load('roles:id'),
            'roles' => $this->assignableRoles($request->user()),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);
        $actor = $request->user();
        $this->protectAdminFromNonAdmin($actor, $user);

        $validated = $request->validate([
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['integer', Rule::exists('roles', 'id')->where('guard_name', 'web')],
        ]);

        $roleIds = collect($validated['roles'] ?? [])->map(fn ($id): int => (int) $id)->unique();
        $roles = Role::query()->where('guard_name', 'web')->whereKey($roleIds)->get();
        $adminRole = Role::query()->where('guard_name', 'web')->where('name', 'admin')->first();

        if (! $actor->hasRole('admin') && $adminRole && $roleIds->contains($adminRole->id)) {
            abort(403);
        }

        if ($user->hasRole('admin') && (! $adminRole || ! $roleIds->contains($adminRole->id))) {
            if ($actor->is($user)) {
                throw ValidationException::withMessages(['roles' => 'You cannot remove your own admin role.']);
            }

            if (User::role('admin')->count() <= 1) {
                throw ValidationException::withMessages(['roles' => 'The last admin role cannot be removed.']);
            }
        }

        DB::transaction(fn () => $user->syncRoles($roles));
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('users.index')->with('success', 'User roles updated successfully.');
    }

    private function assignableRoles(User $actor)
    {
        return Role::query()
            ->where('guard_name', 'web')
            ->when(! $actor->hasRole('admin'), fn ($query) => $query->where('name', '!=', 'admin'))
            ->withCount('permissions')
            ->orderByRaw("case when name = 'admin' then 0 else 1 end")
            ->orderBy('name')
            ->get();
    }

    private function protectAdminFromNonAdmin(User $actor, User $target): void
    {
        abort_if(! $actor->hasRole('admin') && $target->hasRole('admin'), 403);
    }
}
