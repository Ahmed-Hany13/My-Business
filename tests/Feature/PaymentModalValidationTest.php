<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;

it('stores payment notes on the generated invoice', function () {
    $client = Client::factory()->create();
    $notes = 'Paid in cash at the office';

    $this->actingAs(User::factory()->create())
        ->post(route('client.pay', $client), [
            'amount' => '25.00',
            'client_id' => (string) $client->id,
            'notes' => $notes,
        ])
        ->assertRedirect();

    expect(Invoice::query()->where('client_id', $client->id)->value('notes'))->toBe($notes);
});

it('keeps payment validation errors in the payment modal', function () {
    $client = Client::factory()->create();

    $response = $this->actingAs(User::factory()->create())
        ->from(route('client.index'))
        ->followingRedirects()
        ->post(route('client.pay', $client), [
            'amount' => '0',
            'client_id' => (string) $client->id,
        ]);

    $response->assertOk()
        ->assertSee('id="paymentModal"', false)
        ->assertSee('id="addClientModal"', false)
        ->assertSee('class="hidden fixed inset-0', false)
        ->assertSee('class=" fixed inset-0', false)
        ->assertSee('id="paymentAmount" type="number" name="amount" value="0"', false)
        ->assertSee('button.dataset.clientId ===', false);
});
