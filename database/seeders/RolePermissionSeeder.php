<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'user-registration',
            'password-change',
            'user-logout',
            'assign-permission',
            'assign-permission-role',
            'assign-role',
            'assign-user-role',
            'user_index',
            'permission_create',
            'permission_store',
            'permission_edit',
            'permission_update',
            'permission_index',
            'permission_destroy',
            'role_create',
            'role_store',
            'role_edit',
            'role_update',
            'role_index',
            'role_destroy',
            'user_edit',
            'user_update',
            'password-reset',
            'test-sms-send',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        foreach ($permissions as $permission) {
            if (! $adminRole->hasPermissionTo($permission)) {
                $adminRole->givePermissionTo($permission);
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
