<?php

use App\Models\Client;
use App\Models\User;

it('filters clients whose contract period overlaps the selected date range', function () {
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
        'name' => 'Contract ending on range start',
        'start_date' => '2026-03-01',
        'end_date' => '2026-04-01',
    ]);
    Client::factory()->create([
        'name' => 'Contract starting on range end',
        'start_date' => '2026-04-30',
        'end_date' => '2026-05-15',
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

    $response = $this->actingAs(User::factory()->create())
        ->get(route('client.index', [
            'filter_start_date' => '2026-04-01',
            'filter_end_date' => '2026-04-30',
        ]));

    $response->assertOk()
        ->assertSee('Contract overlapping range')
        ->assertSee('Contract spanning range')
        ->assertSee('Contract ending on range start')
        ->assertSee('Contract starting on range end')
        ->assertDontSee('Contract ending before range')
        ->assertDontSee('Contract starting after range');
});

it('renders the empty state when no clients match the date range', function () {
    Client::factory()->create([
        'name' => 'Outside selected range',
        'start_date' => '2026-01-01',
        'end_date' => '2026-01-31',
    ]);

    $response = $this->actingAs(User::factory()->create())
        ->get(route('client.index', [
            'filter_start_date' => '2026-04-01',
            'filter_end_date' => '2026-04-30',
        ]));

    $response->assertOk()
        ->assertSee('لا توجد نتائج مطابقة لمعايير البحث والتصفية.')
        ->assertSee('id="paymentForm"', false)
        ->assertDontSee('Outside selected range');
});
