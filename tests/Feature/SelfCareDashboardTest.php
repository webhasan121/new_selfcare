<?php

use App\Models\Connection;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Payment;

test('self care requires login', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('self care sections render for an account without connections', function (string $section) {
    $this->actingAs(User::factory()->create())
        ->get(($section === 'overview' ? '/dashboard' : '/'.$section))
        ->assertOk()->assertSee('My connections')->assertSee('All connections');
})->with(['overview', 'connections', 'billing', 'packages', 'usage', 'support']);

test('connection selection isolates invoices and rejects another account', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $connections = collect();
    foreach ([[$owner, 'Home'], [$owner, 'Office'], [$other, 'Private service']] as [$user, $name]) {
        $connection = new Connection(['name' => $name]);
        $connection->user()->associate($user);
        $connection->save();
        $connection->invoices()->create([
            'invoice_number' => 'INV-'.$connection->id,
            'amount' => '550.00',
            'due_date' => today(),
        ]);
        $connections->push($connection);
    }
    [$home, $office, $private] = $connections->all();
    $this->actingAs($owner)->get('/billing?connection='.$home->id)
        ->assertOk()->assertSee('INV-'.$home->id)
        ->assertDontSee('INV-'.$office->id)->assertDontSee('Private service');
    $this->get('/billing')->assertOk()
        ->assertSee('INV-'.$home->id)->assertSee('INV-'.$office->id)
        ->assertDontSee('INV-'.$private->id);
    $this->get('/dashboard?connection='.$private->id)->assertNotFound();
});

test('profile renders inside self care navigation', function () {
    $this->actingAs(User::factory()->create())->get('/profile')
        ->assertOk()->assertSee('My connections')->assertSee('Password & security', false);
});

test('old section bookmarks redirect to named routes', function () {
    $this->actingAs(User::factory()->create())->get('/dashboard?section=connections')
        ->assertRedirect(route('connections.index'));
});

test('resources expose only the current users records and validate filters', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    foreach ([$owner, $other] as $user) {
        $connection = new Connection(['name' => 'Service '.$user->id]);
        $connection->user()->associate($user);
        $connection->save();
    }
    $this->actingAs($owner)->getJson('/connections')->assertOk()->assertViewIs('connections.index')
        ->assertSee('Service '.$owner->id)->assertDontSee('Service '.$other->id);
    $this->getJson('/billing')->assertOk()->assertViewIs('billing.index');
    $this->getJson('/dashboard')->assertOk()->assertViewIs('dashboard');
    $this->getJson('/packages')->assertOk()->assertViewIs('packages.index')->assertSee('Home Plus');
    $this->getJson('/connections?connection=invalid')->assertUnprocessable()->assertJsonValidationErrors('connection');
    $this->getJson('/billing?invoices_page=0')->assertUnprocessable()->assertJsonValidationErrors('invoices_page');
    $this->getJson('/connections?connection='.$connection->id)->assertNotFound();
});
