<?php

use App\Models\Connection;
use App\Models\SupportTicket;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed([RoleSeeder::class, PermissionSeeder::class]);
});

function supportTicketFor(User $customer, string $subject): SupportTicket
{
    $connection = new Connection([
        'name' => $customer->name.' connection',
        'type' => 'home',
        'status' => 'active',
    ]);
    $connection->user()->associate($customer);
    $connection->save();

    $ticket = new SupportTicket([
        'connection_id' => $connection->id,
        'subject' => $subject,
        'category' => 'connectivity',
        'description' => 'The customer connection needs technical support.',
    ]);
    $ticket->user()->associate($customer);
    $ticket->save();

    return $ticket;
}

test('customer sees only their own support tickets', function () {
    $customer = User::factory()->create(['name' => 'First Customer'])->assignRole('customer');
    $otherCustomer = User::factory()->create(['name' => 'Other Customer'])->assignRole('customer');
    $ownTicket = supportTicketFor($customer, 'My connection issue');
    $otherTicket = supportTicketFor($otherCustomer, 'Other connection issue');

    $this->actingAs($customer)
        ->get(route('support.index'))
        ->assertOk()
        ->assertSee($ownTicket->subject)
        ->assertDontSee($otherTicket->subject);

    $this->get(route('support.show', $ownTicket))->assertOk();
    $this->get(route('support.show', $otherTicket))->assertNotFound();
});

test('support staff sees and can update every customer ticket', function () {
    $staff = User::factory()->create()->assignRole('support_staff');
    $firstCustomer = User::factory()->create(['name' => 'First Customer'])->assignRole('customer');
    $secondCustomer = User::factory()->create(['name' => 'Second Customer'])->assignRole('customer');
    $firstTicket = supportTicketFor($firstCustomer, 'First customer issue');
    $secondTicket = supportTicketFor($secondCustomer, 'Second customer issue');

    $this->actingAs($staff)
        ->get(route('support.index'))
        ->assertOk()
        ->assertSee($firstTicket->subject)
        ->assertSee($secondTicket->subject)
        ->assertSee($firstCustomer->email)
        ->assertSee($secondCustomer->email);

    $this->get(route('support.show', $firstTicket))->assertOk();
    $this->put(route('support.update', $firstTicket), [
        'connection_id' => $firstTicket->connection_id,
        'subject' => 'Updated by support staff',
        'category' => $firstTicket->category,
        'description' => $firstTicket->description,
        'status' => 'resolved',
    ])->assertSessionHasNoErrors();

    expect($firstTicket->fresh())
        ->subject->toBe('Updated by support staff')
        ->status->toBe('resolved');

    $this->put(route('support.update', $firstTicket), [
        'connection_id' => $firstTicket->connection_id,
        'subject' => 'Closed by support staff',
        'category' => $firstTicket->category,
        'description' => $firstTicket->description,
        'status' => 'closed',
    ])->assertSessionHasNoErrors();

    expect($firstTicket->fresh()->status)->toBe('closed');
});

test('admin sees every customer ticket', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $firstTicket = supportTicketFor(User::factory()->create()->assignRole('customer'), 'First admin-visible issue');
    $secondTicket = supportTicketFor(User::factory()->create()->assignRole('customer'), 'Second admin-visible issue');

    $this->actingAs($admin)
        ->get(route('support.index'))
        ->assertOk()
        ->assertSee($firstTicket->subject)
        ->assertSee($secondTicket->subject);

    $this->get(route('support.show', $secondTicket))->assertOk();
    $this->put(route('support.update', $secondTicket), [
        'connection_id' => $secondTicket->connection_id,
        'subject' => $secondTicket->subject,
        'category' => $secondTicket->category,
        'description' => $secondTicket->description,
        'status' => 'in_progress',
    ])->assertSessionHasNoErrors();

    expect($secondTicket->fresh()->status)->toBe('in_progress');
});

test('customer cannot change ticket status', function () {
    $customer = User::factory()->create()->assignRole('customer');
    $ticket = supportTicketFor($customer, 'Customer status attempt');

    $this->actingAs($customer)->put(route('support.update', $ticket), [
        'connection_id' => $ticket->connection_id,
        'subject' => $ticket->subject,
        'category' => $ticket->category,
        'description' => $ticket->description,
        'status' => 'closed',
    ])->assertSessionHasErrors('status');

    expect($ticket->fresh()->status)->toBe('open');
});
