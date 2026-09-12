<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    foreach (['permission.view', 'permission.create', 'permission.update', 'permission.delete'] as $name) {
        Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
    }
});

test('authorized user can perform permission crud operations', function () {
    $managerRole = Role::create(['name' => 'permission_manager', 'guard_name' => 'web']);
    $managerRole->givePermissionTo(Permission::all());
    $manager = User::factory()->create()->assignRole($managerRole);

    $this->actingAs($manager)->get(route('permissions.index'))->assertOk()->assertSee('Permissions');
    $this->get(route('permissions.create'))->assertOk();
    $this->post(route('permissions.store'), ['name' => 'Reports Export'])
        ->assertSessionHasErrors('name');
    $this->post(route('permissions.store'), ['name' => 'reports.export'])
        ->assertRedirect(route('permissions.index'));

    $permission = Permission::findByName('reports.export');
    $this->put(route('permissions.update', $permission), ['name' => 'reports.download'])
        ->assertRedirect(route('permissions.index'));
    expect($permission->fresh()->name)->toBe('reports.download');

    $this->delete(route('permissions.destroy', $permission))->assertRedirect(route('permissions.index'));
    expect(Permission::whereKey($permission->id)->exists())->toBeFalse();
});

test('permission policy denies unauthorized users', function () {
    $user = User::factory()->create();
    $permission = Permission::create(['name' => 'reports.view', 'guard_name' => 'web']);

    $this->actingAs($user)->get(route('permissions.index'))->assertForbidden();
    $this->get(route('permissions.create'))->assertForbidden();
    $this->post(route('permissions.store'), ['name' => 'reports.create'])->assertForbidden();
    $this->put(route('permissions.update', $permission), ['name' => 'reports.update'])->assertForbidden();
    $this->delete(route('permissions.destroy', $permission))->assertForbidden();
});

test('assigned permission cannot be deleted', function () {
    $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $admin = User::factory()->create()->assignRole($adminRole);
    $assigned = Permission::create(['name' => 'reports.view', 'guard_name' => 'web']);
    $adminRole->givePermissionTo($assigned);

    $this->actingAs($admin)->delete(route('permissions.destroy', $assigned))
        ->assertSessionHasErrors('permission');

    expect($assigned->fresh())->not->toBeNull();
});
