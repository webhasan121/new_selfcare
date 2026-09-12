<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    foreach (['role.view', 'role.create', 'role.update', 'role.delete'] as $name) {
        Permission::create(['name' => $name, 'guard_name' => 'web']);
    }
});

test('authorized user can perform role crud operations', function () {
    $managerRole = Role::create(['name' => 'role_manager', 'guard_name' => 'web']);
    $managerRole->givePermissionTo(Permission::all());
    $manager = User::factory()->create()->assignRole($managerRole);

    $this->actingAs($manager)->get(route('roles.index'))->assertOk()->assertSee('Roles');
    $this->get(route('roles.create'))->assertOk();
    $viewPermission = Permission::findByName('role.view');
    $updatePermission = Permission::findByName('role.update');
    $this->post(route('roles.store'), [
        'name' => 'Support Manager',
        'permissions' => [(string) $viewPermission->id],
    ])->assertRedirect(route('roles.index'));

    $role = Role::findByName('support_manager');
    expect($role->hasPermissionTo($viewPermission))->toBeTrue();

    $this->put(route('roles.update', $role), [
        'name' => 'Support Lead',
        'permissions' => [(string) $updatePermission->id],
    ])->assertRedirect(route('roles.index'));
    expect($role->fresh()->name)->toBe('support_lead')
        ->and($role->fresh()->hasPermissionTo($viewPermission))->toBeFalse()
        ->and($role->fresh()->hasPermissionTo($updatePermission))->toBeTrue();

    $this->delete(route('roles.destroy', $role))->assertRedirect(route('roles.index'));
    expect(Role::whereKey($role->id)->exists())->toBeFalse();
});

test('role forms show permission checkboxes and reject permissions from another guard', function () {
    $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $admin = User::factory()->create()->assignRole($adminRole);
    $apiPermission = Permission::create(['name' => 'api.secret', 'guard_name' => 'api']);

    $this->actingAs($admin)->get(route('roles.create'))
        ->assertOk()
        ->assertSee('Select all')
        ->assertSee('role.view');

    $this->post(route('roles.store'), [
        'name' => 'invalid_role',
        'permissions' => [$apiPermission->id],
    ])->assertSessionHasErrors('permissions.0');

    expect(Role::where('name', 'invalid_role')->exists())->toBeFalse();
});

test('role policy denies users without role permissions', function () {
    $user = User::factory()->create();
    $role = Role::create(['name' => 'support_staff', 'guard_name' => 'web']);

    $this->actingAs($user)->get(route('roles.index'))->assertForbidden();
    $this->post(route('roles.store'), ['name' => 'forbidden'])->assertForbidden();
    $this->put(route('roles.update', $role), ['name' => 'forbidden'])->assertForbidden();
    $this->delete(route('roles.destroy', $role))->assertForbidden();
});

test('admin role cannot be renamed or deleted and assigned roles cannot be deleted', function () {
    $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $admin = User::factory()->create()->assignRole($adminRole);
    $assignedRole = Role::create(['name' => 'customer', 'guard_name' => 'web']);
    User::factory()->create()->assignRole($assignedRole);

    $this->actingAs($admin)->put(route('roles.update', $adminRole), ['name' => 'owner'])->assertSessionHasErrors('name');
    $this->delete(route('roles.destroy', $adminRole))->assertSessionHasErrors('role');
    $this->delete(route('roles.destroy', $assignedRole))->assertSessionHasErrors('role');

    expect($adminRole->fresh()->name)->toBe('admin')
        ->and($assignedRole->fresh())->not->toBeNull();
});
