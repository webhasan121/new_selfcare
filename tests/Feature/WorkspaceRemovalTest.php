<?php

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

test('dashboard remains available without workspace preferences', function () {
    Gate::before(fn () => true);
    $this->actingAs(User::factory()->create())->get('/dashboard')
        ->assertOk()->assertViewIs('dashboard')->assertDontSee('Manage preferences');
    expect(Schema::hasTable('workspace_preferences'))->toBeFalse();
    $this->get('/dashboard/create')->assertNotFound();
    $this->get('/dashboard/1')->assertNotFound();
    $this->get('/dashboard/1/edit')->assertNotFound();
    $this->post('/dashboard')->assertStatus(405);
    $this->put('/dashboard/1')->assertNotFound();
    $this->delete('/dashboard/1')->assertNotFound();
});

test('dashboard still requires its viewing permission', function () {
    Gate::define('dashboard.view', fn () => false);
    $this->actingAs(User::factory()->create())->get('/dashboard')->assertForbidden();
});
