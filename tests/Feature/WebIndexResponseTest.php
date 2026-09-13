<?php

use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('web index pages return views even when JSON is requested', function () {
    // Isolate response format from the separate permission configuration.
    Gate::before(fn () => true);
    $this->actingAs(User::factory()->create());

    foreach (['dashboard' => 'dashboard', 'connections' => 'connections.index', 'billing' => 'billing.index', 'packages' => 'packages.index'] as $path => $view) {
        $this->getJson('/'.$path)->assertOk()->assertViewIs($view);
    }
});
