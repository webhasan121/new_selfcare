<?php

use App\Models\Connection;
use App\Models\SupportTicket;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed([RoleSeeder::class, PermissionSeeder::class]);
});

test('customer role can use customer features but not administration', function () {
    $customer = User::factory()->create()->assignRole('customer');

    $this->actingAs($customer)->get(route('dashboard'))->assertOk();
    $this->get(route('connections.index'))->assertOk();
    $this->get(route('billing.index'))->assertOk();
    $this->get(route('packages.index'))->assertOk();
    $this->get(route('usage.index'))->assertOk();
    $this->get(route('support.index'))->assertOk();
    $this->get(route('settings.index'))->assertForbidden();
    $this->get(route('roles.index'))->assertForbidden();
    $this->get(route('users.index'))->assertForbidden();
});

test('customer and support staff actions follow seeded permissions', function () {
    $customer = User::factory()->create()->assignRole('customer');
    $support = User::factory()->create()->assignRole('support_staff');
    $connection = new Connection(['name' => 'Home', 'type' => 'home', 'status' => 'pending']);
    $connection->user()->associate($customer);
    $connection->save();
    $ticket = new SupportTicket([
        'connection_id' => $connection->id,
        'subject' => 'Connection issue',
        'category' => 'connectivity',
        'description' => 'The customer needs help with their connection.',
    ]);
    $ticket->user()->associate($customer);
    $ticket->save();

    $this->actingAs($customer)->get(route('connections.create'))->assertOk();
    $this->delete(route('connections.destroy', $connection))->assertForbidden();
    $this->delete(route('support.destroy', $ticket))->assertForbidden();
    $this->delete(route('connections.destroy', 999))->assertNotFound();
    $this->delete(route('support.destroy', 999))->assertNotFound();

    $this->actingAs($support)->get(route('connections.index'))->assertOk();
    $this->get(route('connections.create'))->assertForbidden();
    $this->delete(route('support.destroy', 999))->assertNotFound();
});
