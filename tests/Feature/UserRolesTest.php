<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Permission::create(['name' => 'user.view', 'guard_name' => 'web']);
    Permission::create(['name' => 'user.update', 'guard_name' => 'web']);
});

test('authorized user can view users and assign non-admin roles', function () {
    $managerRole = Role::create(['name' => 'user_manager', 'guard_name' => 'web']);
    $managerRole->givePermissionTo(['user.view', 'user.update']);
    $supportRole = Role::create(['name' => 'support_staff', 'guard_name' => 'web']);
    $manager = User::factory()->create()->assignRole($managerRole);
    $target = User::factory()->create();

    $this->actingAs($manager)->get(route('users.index'))
        ->assertOk()
        ->assertSee($target->email)
        ->assertSee(route('users.index'));

    $this->get(route('users.edit', $target))->assertOk()->assertSee('support staff');
    $this->put(route('users.update', $target), ['roles' => [(string) $supportRole->id]])
        ->assertRedirect(route('users.index'));

    expect($target->fresh()->hasRole('support_staff'))->toBeTrue();
});

test('users without permission cannot manage user roles', function () {
    $actor = User::factory()->create();
    $target = User::factory()->create();

    $this->actingAs($actor)->get(route('users.index'))->assertForbidden();
    $this->get(route('users.edit', $target))->assertForbidden();
    $this->put(route('users.update', $target), ['roles' => []])->assertForbidden();
});

test('non-admin manager cannot assign or modify the admin role', function () {
    $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $managerRole = Role::create(['name' => 'user_manager', 'guard_name' => 'web']);
    $managerRole->givePermissionTo(['user.view', 'user.update']);
    $manager = User::factory()->create()->assignRole($managerRole);
    $admin = User::factory()->create()->assignRole($adminRole);
    $target = User::factory()->create();

    $this->actingAs($manager)->get(route('users.edit', $admin))->assertForbidden();
    $this->put(route('users.update', $target), ['roles' => [$adminRole->id]])->assertForbidden();
    expect($target->fresh()->hasRole('admin'))->toBeFalse();
});

test('admin cannot remove their own admin role', function () {
    $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $admin = User::factory()->create()->assignRole($adminRole);

    $this->actingAs($admin)->put(route('users.update', $admin), ['roles' => []])
        ->assertSessionHasErrors('roles');

    expect($admin->fresh()->hasRole('admin'))->toBeTrue();
});
