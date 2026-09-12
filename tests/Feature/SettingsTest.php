<?php

use App\Models\Setting;
use App\Models\User;
use Spatie\Permission\Models\Role;

test('only admins can view settings and see the settings menu', function () {
    Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $admin = User::factory()->create()->assignRole('admin');
    $customer = User::factory()->create();
    Setting::create(['name' => 'site_name', 'type' => 'raw', 'value' => 'Selfcare']);

    $this->actingAs($admin)
        ->get(route('settings.index'))
        ->assertOk()
        ->assertSee('Settings')
        ->assertSee('Site name')
        ->assertSee('Selfcare');

    $this->actingAs($customer)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertDontSee(route('settings.index'));

    $this->get(route('settings.index'))->assertForbidden();
});

test('an admin can update a database setting but a customer cannot', function () {
    Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $admin = User::factory()->create()->assignRole('admin');
    $customer = User::factory()->create();
    $setting = Setting::create(['name' => 'site_name', 'type' => 'raw', 'value' => 'Old name']);

    $this->actingAs($admin)
        ->put(route('settings.update', $setting), ['value' => 'New name'])
        ->assertRedirect(route('settings.index'));

    expect($setting->fresh()->value)->toBe('New name');

    $this->actingAs($customer)
        ->put(route('settings.update', $setting), ['value' => 'Forbidden name'])
        ->assertForbidden();

    expect($setting->fresh()->value)->toBe('New name');
});
