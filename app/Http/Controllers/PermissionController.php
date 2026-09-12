<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Permission::class);

        $search = trim((string) $request->query('search'));
        $permissions = Permission::query()
            ->where('guard_name', 'web')
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->withCount(['roles', 'users'])
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('permissions.index', compact('permissions', 'search'));
    }

    public function create(): View
    {
        Gate::authorize('create', Permission::class);

        return view('permissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Permission::class);

        Permission::create(['name' => $this->validatedName($request), 'guard_name' => 'web']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission): View
    {
        $this->ensureWebPermission($permission);
        Gate::authorize('update', $permission);

        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $this->ensureWebPermission($permission);
        Gate::authorize('update', $permission);

        $permission->update(['name' => $this->validatedName($request, $permission)]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $this->ensureWebPermission($permission);
        Gate::authorize('delete', $permission);

        if ($permission->roles()->exists() || $permission->users()->exists()) {
            throw ValidationException::withMessages([
                'permission' => 'Remove this permission from all roles and users before deleting it.',
            ]);
        }

        $permission->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }

    private function validatedName(Request $request, ?Permission $permission = null): string
    {
        $request->merge(['name' => Str::of((string) $request->input('name'))->trim()->lower()->replace(' ', '-')->toString()]);

        return $request->validate([
            'name' => [
                'required', 'string', 'max:125',
                'regex:/^[a-z0-9_-]+\.[a-z0-9_-]+$/',
                Rule::unique('permissions', 'name')->where('guard_name', 'web')->ignore($permission?->id),
            ],
        ], ['name.regex' => 'Use the feature.action format, for example support.view.'])['name'];
    }

    private function ensureWebPermission(Permission $permission): void
    {
        abort_unless($permission->guard_name === 'web', 404);
    }
}
