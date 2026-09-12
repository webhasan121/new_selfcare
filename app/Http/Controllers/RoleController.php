<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Role::class);

        $roles = Role::query()
            ->where('guard_name', 'web')
            ->withCount(['permissions', 'users'])
            ->orderByRaw("case when name = 'admin' then 0 else 1 end")
            ->orderBy('name')
            ->paginate(15);

        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        Gate::authorize('create', Role::class);

        return view('roles.create', ['permissions' => $this->groupedPermissions()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Role::class);

        $validated = $this->validatedPayload($request);
        $permissions = $this->permissionsFromIds($validated['permissions'] ?? []);

        DB::transaction(function () use ($validated, $permissions): void {
            $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);
            $role->syncPermissions($permissions);
        });
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role): View
    {
        $this->ensureWebRole($role);
        Gate::authorize('update', $role);

        $role->load('permissions:id');

        return view('roles.edit', [
            'role' => $role,
            'permissions' => $this->groupedPermissions(),
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $this->ensureWebRole($role);
        Gate::authorize('update', $role);

        if ($role->name === 'admin') {
            throw ValidationException::withMessages(['name' => 'The admin role cannot be renamed.']);
        }

        $validated = $this->validatedPayload($request, $role);
        $permissions = $this->permissionsFromIds($validated['permissions'] ?? []);

        DB::transaction(function () use ($role, $validated, $permissions): void {
            $role->update(['name' => $validated['name']]);
            $role->syncPermissions($permissions);
        });
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $this->ensureWebRole($role);
        Gate::authorize('delete', $role);

        if ($role->name === 'admin') {
            throw ValidationException::withMessages(['role' => 'The admin role cannot be deleted.']);
        }

        if ($role->users()->exists()) {
            throw ValidationException::withMessages(['role' => 'Remove this role from its users before deleting it.']);
        }

        $role->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    /**
     * @return array{name: string, permissions?: array<int, int>}
     */
    private function validatedPayload(Request $request, ?Role $role = null): array
    {
        $request->merge(['name' => Str::of((string) $request->input('name'))->trim()->lower()->replace(' ', '_')->toString()]);

        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-z0-9._-]+$/',
                Rule::unique('roles', 'name')->where('guard_name', 'web')->ignore($role?->id),
            ],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => [
                'integer',
                Rule::exists('permissions', 'id')->where('guard_name', 'web'),
            ],
        ]);
    }

    private function groupedPermissions(): Collection
    {
        return Permission::query()
            ->where('guard_name', 'web')
            ->orderBy('name')
            ->get()
            ->groupBy(fn (Permission $permission): string => Str::before($permission->name, '.'));
    }

    /**
     * Resolve checkbox values to models so numeric strings are never treated as permission names.
     *
     * @param  array<int, int|string>  $ids
     */
    private function permissionsFromIds(array $ids): Collection
    {
        return Permission::query()
            ->where('guard_name', 'web')
            ->whereKey($ids)
            ->get();
    }

    private function ensureWebRole(Role $role): void
    {
        abort_unless($role->guard_name === 'web', 404);
    }
}
