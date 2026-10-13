<?php

use App\Models\Client;
use App\Models\Invoice;
use Livewire\Livewire;

it('filters invoices by client name and invoice number', function () {
    $matchingClient = Client::factory()->create(['name' => 'Searchable Client']);
    $otherClient = Client::factory()->create(['name' => 'Other Client']);

    Invoice::create([
        'client_id' => $matchingClient->id,
        'invoice_number' => 'INV-1001',
        'total_amount' => 100,
    ]);
    Invoice::create([
        'client_id' => $otherClient->id,
        'invoice_number' => 'INV-2002',
        'total_amount' => 200,
    ]);

    Livewire::test('user-search')
        ->assertSee('Searchable Client')
        ->assertSee('Other Client')
        ->set('search', 'Searchable')
        ->assertSee('Searchable Client')
        ->assertDontSee('Other Client')
        ->set('search', '2002')
        ->assertSee('Other Client')
        ->assertDontSee('Searchable Client');
});
