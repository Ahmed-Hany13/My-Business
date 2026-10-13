<?php

use App\Models\Client;
use Livewire\Livewire;

it('filters clients whose contracts overlap the selected date range', function () {
    Client::factory()->create([
        'name' => 'Contract overlapping range',
        'start_date' => '2026-03-15',
        'end_date' => '2026-04-10',
    ]);
    Client::factory()->create([
        'name' => 'Contract spanning range',
        'start_date' => '2026-03-01',
        'end_date' => '2026-05-01',
    ]);
    Client::factory()->create([
        'name' => 'Contract ending before range',
        'start_date' => '2026-02-01',
        'end_date' => '2026-03-31',
    ]);
    Client::factory()->create([
        'name' => 'Contract starting after range',
        'start_date' => '2026-05-01',
        'end_date' => '2026-06-01',
    ]);

    Livewire::test('client-search')
        ->set('startDate', '2026-04-01')
        ->set('endDate', '2026-04-30')
        ->assertSee('Contract overlapping range')
        ->assertSee('Contract spanning range')
        ->assertDontSee('Contract ending before range')
        ->assertDontSee('Contract starting after range')
        ->call('clearFilters')
        ->assertSee('Contract ending before range')
        ->assertSee('Contract starting after range');
});
