<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear permission cache
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Dashboard
            'dashboard.view',

            // Profile
            'profile.view',
            'profile.update',

            // Connection
            'connection.view',
            'connection.create',
            'connection.update',
            'connection.delete',

            // Package
            'package.view',
            'package.create',
            'package.update',
            'package.delete',

            // Subscription
            'subscription.view',
            'subscription.create',
            'subscription.update',
            'subscription.delete',
            'subscription.upgrade',
            'subscription.downgrade',

            // Billing
            'billing.view',
            'billing.create',
            'billing.update',

            // Invoice
            'invoice.view',
            'invoice.create',
            'invoice.update',

            // Payment
            'payment.view',
            'payment.create',

            // Usage
            'usage.view',

            // Support
            'support.view',
            'support.create',
            'support.update',
            'support.delete',

            // User Management
            'user.view',
            'user.create',
            'user.update',
            'user.delete',

            // Role Management
            'role.view',
            'role.create',
            'role.update',
            'role.delete',

            // Permission Management
            'permission.view',
            'permission.create',
            'permission.update',
            'permission.delete',

            // Settings
            'settings.view',
            'settings.update',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Default Role Permissions
        |--------------------------------------------------------------------------
        */

        $customerPermissions = [
            'dashboard.view',
            'profile.view',
            'profile.update',
            'connection.view',
            'connection.create',
            'connection.update',
            'package.view',
            'billing.view',
            'invoice.view',
            'payment.view',
            'payment.create',
            'usage.view',
            'support.view',
            'support.create',
            'support.update',
        ];

        $supportStaffPermissions = [
            'dashboard.view',
            'profile.view',
            'profile.update',
            'connection.view',
            'connection.update',
            'package.view',
            'subscription.view',
            'billing.view',
            'invoice.view',
            'payment.view',
            'usage.view',
            'support.view',
            'support.create',
            'support.update',
            'support.delete',
        ];

        Role::firstOrCreate([
            'name' => 'customer',
            'guard_name' => 'web',
        ])->syncPermissions($customerPermissions);

        Role::firstOrCreate([
            'name' => 'support_staff',
            'guard_name' => 'web',
        ])->syncPermissions($supportStaffPermissions);

        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ])->syncPermissions($permissions);

        /*
        |--------------------------------------------------------------------------
        | Clear Permission Cache
        |--------------------------------------------------------------------------
        */

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
