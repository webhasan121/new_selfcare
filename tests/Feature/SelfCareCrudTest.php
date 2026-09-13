<?php

use App\Models\Connection;
use Illuminate\Support\Facades\Http;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Payment;
use App\Models\SupportTicket;
use App\Models\UsageReport;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    config(['services.provider.user_check_url' => 'https://jsonplaceholder.typicode.com/todos/1']);
    Http::preventStrayRequests();
    Http::fake(['https://jsonplaceholder.typicode.com/todos/1' => Http::response(['userId' => 1, 'id' => 1, 'title' => 'Sample todo', 'completed' => false])]);
});

function crudOwner(bool $admin = false): User
{
    $user = User::factory()->create();
    if ($admin) {
        $user->assignRole(Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']));
    }

    return $user;
}

function crudConnection(User $owner, string $status = 'pending'): Connection
{
    $connection = new Connection(['name' => 'Home', 'type' => 'home', 'status' => $status]);
    $connection->user()->associate($owner);
    $connection->save();

    return $connection;
}

test('customers can create update and delete their connection metadata', function () {
    $owner = crudOwner();
    $this->actingAs($owner)->post('/connections', ['name' => 'Home', 'type' => 'home', 'installation_address' => 'Dhaka', 'username' => 'customer-1', 'password' => 'connection-secret'])
        ->assertSessionHasNoErrors()->assertRedirect();
    $record = Connection::sole();
    expect($record->user_id)->toBe($owner->id)->and($record->status)->toBe('pending');
    $this->put('/connections/'.$record->id, ['name' => 'Office', 'type' => 'office'])
        ->assertSessionHasNoErrors()->assertRedirect(route('connections.show', $record));
    expect($record->fresh()->name)->toBe('Office');
    $this->delete('/connections/'.$record->id)->assertSessionHasNoErrors()->assertRedirect(route('connections.index'));
    expect(Connection::count())->toBe(0);
});

test('connection writes reject forged ownership invalid status and foreign IDs', function () {
    $owner = crudOwner();
    $other = crudOwner();
    $foreign = crudConnection($other);
    $this->actingAs($owner)->post('/connections', ['name' => 'Bad', 'type' => 'home', 'user_id' => $other->id, 'status' => 'invalid'])
        ->assertSessionHasErrors(['user_id', 'status']);
    $this->put('/connections/'.$foreign->id, ['name' => 'Takeover', 'type' => 'home'])->assertNotFound();
    $this->delete('/connections/'.$foreign->id)->assertNotFound();
    expect($foreign->fresh()->name)->toBe('Home');
});

test('connection deletion preserves active service and invoice history', function () {
    $owner = crudOwner();
    $active = crudConnection($owner, 'active');
    $pending = crudConnection($owner);
    $pending->invoices()->create(['invoice_number' => 'KEEP-1', 'amount' => '550.00', 'due_date' => today()]);
    $this->actingAs($owner)->delete('/connections/'.$active->id)->assertSessionHasErrors('record');
    $this->delete('/connections/'.$pending->id)->assertSessionHasErrors('record');
    expect(Connection::count())->toBe(2);
});

test('packages are read only and do not expose the local catalogue', function () {
    $package = Package::create(['name' => 'Local catalogue only', 'price' => '100.00', 'speed_mbps' => 10, 'validity_days' => 30]);
    $this->actingAs(crudOwner())->get('/packages')->assertOk()
        ->assertSee('Package name')->assertSee('Expire date')->assertSee('Upgrade')->assertSee('Downgrade')
        ->assertDontSee('Local catalogue only')->assertDontSee('Package form');
    $this->get('/packages/create')->assertNotFound();
    $this->get('/packages/'.$package->id)->assertNotFound();
    $this->get('/packages/'.$package->id.'/edit')->assertNotFound();
    $this->post('/packages', [])->assertStatus(405);
    $this->put('/packages/'.$package->id, [])->assertNotFound();
    $this->delete('/packages/'.$package->id)->assertNotFound();
    expect($package->fresh())->not->toBeNull();
    $this->getJson('/packages')->assertOk()->assertViewIs('packages.index')->assertSee('Demo preview');
});

test('package connection filter rejects another customers connection', function () {
    $connection = crudConnection(crudOwner());
    $this->actingAs(crudOwner())->get('/packages?connection='.$connection->id)->assertNotFound();
});

test('owned invoices support creation correction and deletion before payment', function () {
    $admin = crudOwner();
    $connection = crudConnection($admin);
    $data = ['invoice_number' => 'NEW-001', 'connection_id' => $connection->id, 'amount' => '550.00', 'due_date' => today()->toDateString()];
    $this->actingAs($admin)->post('/billing', $data)->assertSessionHasNoErrors();
    $invoice = Invoice::sole();
    expect($invoice->status)->toBe('unpaid')->and($invoice->connection_id)->toBe($connection->id);
    $this->put('/billing/'.$invoice->id, array_replace($data, ['amount' => '600.00']))->assertSessionHasNoErrors();
    expect($invoice->fresh()->amount)->toBe('600.00');
    $this->post('/billing', $data)->assertSessionHasErrors('invoice_number');
    $this->delete('/billing/'.$invoice->id)->assertSessionHasNoErrors();
    expect(Invoice::count())->toBe(0);
});

test('owners can correct invoices but payment linked changes are denied', function () {
    $customer = crudOwner();
    $connection = crudConnection($customer);
    $data = ['invoice_number' => 'LOCK-1', 'connection_id' => $connection->id, 'amount' => '550.00', 'due_date' => today()->toDateString()];
    $invoice = $connection->invoices()->create($data);
    $this->actingAs($customer)->put('/billing/'.$invoice->id, $data)->assertSessionHasNoErrors();
    $payment = new Payment(['transaction_id' => 'LOCK-PAY', 'total_amount' => '550.00', 'payment_method' => 'test']);
    $payment->user()->associate($customer); $payment->save();
    $payment->items()->create(['invoice_id' => $invoice->id, 'amount' => '550.00']);
    $this->put('/billing/'.$invoice->id, $data)->assertSessionHasErrors('record');
    $this->delete('/billing/'.$invoice->id)->assertSessionHasErrors('record');
    expect($invoice->fresh())->not->toBeNull();
});


test('report criteria can be saved edited listed and deleted without fabricated usage', function () {
    $owner = crudOwner();
    $connection = crudConnection($owner);
    $data = ['connection_id' => $connection->id, 'start_date' => today()->subDays(5)->toDateString(), 'end_date' => today()->toDateString()];
    $this->actingAs($owner)->post('/usage', $data)->assertSessionHasNoErrors();
    $record = UsageReport::sole();
    $this->get('/usage')->assertOk()->assertSee('Saved report criteria');
    $this->get('/usage/'.$record->id)->assertOk()->assertSee('Network usage measurements are not connected yet.');
    $this->put('/usage/'.$record->id, array_replace($data, ['start_date' => today()->subDays(3)->toDateString()]))->assertSessionHasNoErrors();
    $this->delete('/usage/'.$record->id)->assertSessionHasNoErrors();
    expect(UsageReport::count())->toBe(0);
});

test('support tickets can be created edited listed and deleted', function () {
    $owner = crudOwner();
    $connection = crudConnection($owner);
    $data = ['connection_id' => $connection->id, 'subject' => 'Connection issue', 'category' => 'connectivity', 'description' => 'Internet has been unavailable since this morning.'];
    $this->actingAs($owner)->post('/support', $data)->assertSessionHasNoErrors();
    $ticket = SupportTicket::sole();
    expect($ticket->user_id)->toBe($owner->id)->and($ticket->status)->toBe('open');
    $this->get('/support')->assertOk()->assertSee('Connection issue');
    $this->put('/support/'.$ticket->id, array_replace($data, ['subject' => 'Updated issue']))->assertSessionHasNoErrors();
    expect($ticket->fresh()->subject)->toBe('Updated issue');
    $this->delete('/support/'.$ticket->id)->assertSessionHasNoErrors();
    expect(SupportTicket::count())->toBe(0);
});

test('new resource mutations enforce ownership and date validation', function () {
    $owner = crudOwner();
    $other = crudOwner();
    $connection = crudConnection($other);
    $report = new UsageReport(['connection_id' => $connection->id, 'start_date' => today(), 'end_date' => today()]);
    $report->user()->associate($other); $report->save();
    $ticket = new SupportTicket(['connection_id' => $connection->id, 'subject' => 'Private', 'category' => 'other', 'description' => 'Private issue description.']);
    $ticket->user()->associate($other); $ticket->save();
    $this->actingAs($owner);
    foreach (['usage' => $report, 'support' => $ticket] as $module => $record) {
        $this->get('/'.$module.'/'.$record->id)->assertNotFound();
        $this->delete('/'.$module.'/'.$record->id)->assertNotFound();
    }
    $this->post('/usage', ['connection_id' => $connection->id, 'start_date' => '2026-02-30', 'end_date' => '2020-01-01'])->assertSessionHasErrors(['connection_id', 'start_date']);
    $this->post('/support', ['connection_id' => $connection->id, 'subject' => 'x', 'category' => 'other', 'description' => 'A long enough description'])->assertSessionHasErrors('connection_id');
    $ownConnection = crudConnection($owner);
    $this->put('/usage/'.$report->id, ['connection_id' => $ownConnection->id, 'start_date' => today()->toDateString(), 'end_date' => today()->toDateString()])->assertNotFound();
    $this->put('/support/'.$ticket->id, ['connection_id' => $ownConnection->id, 'subject' => 'x', 'category' => 'other', 'description' => 'A long enough description'])->assertNotFound();
});



test('connection credentials are required and encrypted without being exposed', function () {
    $this->actingAs(crudOwner())->post('/connections', ['name' => 'Home', 'type' => 'home'])
        ->assertSessionHasErrors(['username', 'password']);
    expect(Connection::count())->toBe(0);
    $this->post('/connections', ['name' => 'Home', 'type' => 'home', 'username' => 'isp-user', 'password' => 'secret-connection-password'])
        ->assertSessionHasNoErrors()->assertRedirect();
    $record = Connection::sole();
    expect($record->username)->toBe('isp-user')
        ->and($record->password)->toBe('secret-connection-password')
        ->and($record->getRawOriginal('password'))->not->toBe('secret-connection-password')
        ->and($record->toArray())->not->toHaveKey('password');
    $this->get('/connections/'.$record->id)->assertOk()->assertSee('isp-user')->assertDontSee('secret-connection-password');
    $this->getJson('/connections')->assertOk()->assertViewIs('connections.index')->assertDontSee('secret-connection-password');
});

test('failed provider verification does not save a connection', function () {
    $controller = Mockery::mock(\App\Http\Controllers\ConnectionController::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $controller->shouldReceive('providerUserExists')->once()->with('missing-user', 'wrong-password')->andReturn(false);
    $this->app->instance(\App\Http\Controllers\ConnectionController::class, $controller);
    $this->actingAs(crudOwner())->from('/connections/create')->post('/connections', [
        'name' => 'Home', 'type' => 'home', 'username' => 'missing-user', 'password' => 'wrong-password',
    ])->assertSessionHasErrors('username')->assertSessionMissing('_old_input.password');
    expect(Connection::count())->toBe(0);
});


test('sample verification sends no customer credentials', function () {
    $this->actingAs(crudOwner())->post('/connections', [
        'name' => 'Home', 'type' => 'home', 'username' => 'private-user', 'password' => 'private-password',
    ])->assertSessionHasNoErrors()->assertRedirect();
    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && $request->url() === 'https://jsonplaceholder.typicode.com/todos/1'
        && $request->data() === [] && ! $request->hasHeader('Authorization'));
});

test('sample API failures prevent connection creation', function ($failure) {
    Http::swap(new \Illuminate\Http\Client\Factory());
    Http::preventStrayRequests();
    Http::fake(['https://jsonplaceholder.typicode.com/todos/1' => match ($failure) {
        'timeout' => Http::failedConnection(),
        'invalid' => Http::response(['id' => 2]),
        'malformed' => Http::response('not json'),
        default => Http::response([], 500),
    }]);
    $this->actingAs(crudOwner())->post('/connections', [
        'name' => 'Home', 'type' => 'home', 'username' => 'isp-user', 'password' => 'private-password',
    ])->assertSessionHasErrors('username');
    expect(Connection::count())->toBe(0);
})->with(['timeout', 'invalid', 'malformed', 'server error']);
