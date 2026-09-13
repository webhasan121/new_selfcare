<?php

use App\Models\Connection;

use App\Models\User;
use Spatie\Permission\Models\Role;

test('all resource creation pages render without changing data', function () {
    $admin = User::factory()->create();
    $admin->assignRole(Role::create(['name' => 'Admin', 'guard_name' => 'web']));
    $this->actingAs($admin);
    foreach (['connections', 'billing', 'usage', 'support'] as $module) {
        $this->get('/'.$module.'/create')->assertOk()->assertSee('type="submit"', false)->assertDontSee('Unavailable');
    }
    expect(Connection::count())->toBe(0);
});

test('record details and edit pages render and protect ownership', function () {
    $owner = User::factory()->create();
    $owner->assignRole(Role::create(['name' => 'Admin', 'guard_name' => 'web']));
    $other = User::factory()->create();
    $connection = new Connection(['name' => 'My home', 'type' => 'home']);
    $connection->user()->associate($owner);
    $connection->save();
    $invoice = $connection->invoices()->create(['invoice_number' => 'DETAIL-001', 'amount' => '550.00', 'due_date' => today()]);
    $this->actingAs($owner);
    foreach (['connections' => $connection, 'billing' => $invoice] as $module => $record) {
        $this->get('/'.$module.'/'.$record->id)->assertOk()->assertSee('Record overview');
        $this->get('/'.$module.'/'.$record->id.'/edit')->assertOk()->assertSee('Save changes');
    }
    $this->actingAs($other);
    foreach (['connections' => $connection, 'billing' => $invoice] as $module => $record) {
        $this->get('/'.$module.'/'.$record->id)->assertNotFound();
        $this->get('/'.$module.'/'.$record->id.'/edit')->assertNotFound();
    }
});

test('missing records return not found', function () {
    $this->actingAs(User::factory()->create());
    foreach (['dashboard', 'usage', 'support'] as $module) {
        $this->get('/'.$module.'/1')->assertNotFound();
        $this->get('/'.$module.'/1/edit')->assertNotFound();
    }
});
