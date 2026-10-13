<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;

it('shows business totals and recent invoices on the dashboard', function () {
    $client = Client::factory()->create([
        'name' => 'Dashboard Client',
        'balance' => 125.50,
        'debt' => 75.25,
    ]);

    Invoice::create([
        'client_id' => $client->id,
        'invoice_number' => 'INV-DASH-1',
        'total_amount' => 50.00,
    ]);

    $response = $this->actingAs(User::factory()->create())
        ->get(route('dashboard'));

    $response->assertOk()
        ->assertSee('Dashboard Client')
        ->assertSee('INV-DASH-1')
        ->assertSee('125.50')
        ->assertSee('75.25')
        ->assertSee('50.00');
});
