<?php

use App\Models\Expense;
use App\Models\User;

it('creates an expense from the add expense form', function () {
    $response = $this->actingAs(User::factory()->create())
        ->post(route('expense.store'), [
            'product' => 'Office supplies',
            'price' => '125.50',
        ]);

    $response->assertRedirect(route('expense.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('expenses', [
        'product' => 'Office supplies',
        'price' => '125.50',
    ]);
});

it('rejects expenses with an invalid amount', function () {
    $response = $this->actingAs(User::factory()->create())
        ->from(route('expense.index'))
        ->post(route('expense.store'), [
            'product' => 'Office supplies',
            'price' => '0',
        ]);

    $response->assertRedirect(route('expense.index'))
        ->assertSessionHasErrors('price');

    expect(Expense::query()->count())->toBe(0);
});

it('updates an existing expense', function () {
    $expense = Expense::create([
        'product' => 'Old name',
        'price' => '20.00',
    ]);

    $response = $this->actingAs(User::factory()->create())
        ->put(route('expense.update', $expense), [
            'product' => 'Updated name',
            'price' => '35.75',
            'expense_id' => (string) $expense->id,
        ]);

    $response->assertRedirect(route('expense.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('expenses', [
        'id' => $expense->id,
        'product' => 'Updated name',
        'price' => '35.75',
    ]);
});

it('returns validation errors when an expense update is invalid', function () {
    $expense = Expense::create([
        'product' => 'Office supplies',
        'price' => '20.00',
    ]);

    $response = $this->actingAs(User::factory()->create())
        ->from(route('expense.index'))
        ->put(route('expense.update', $expense), [
            'product' => '',
            'price' => '0',
            'expense_id' => (string) $expense->id,
        ]);

    $response->assertRedirect(route('expense.index'))
        ->assertSessionHasErrors(['product', 'price'])
        ->assertSessionHasInput('expense_id', (string) $expense->id);

    $this->assertDatabaseHas('expenses', [
        'id' => $expense->id,
        'product' => 'Office supplies',
        'price' => '20.00',
    ]);
});

it('shows overall expense totals and a working edit action', function () {
    $expense = Expense::create([
        'product' => 'Printer paper',
        'price' => '42.75',
    ]);

    Expense::create([
        'product' => 'Pens',
        'price' => '7.25',
    ]);

    $response = $this->actingAs(User::factory()->create())
        ->get(route('expense.index'));

    $response->assertOk()
        ->assertSee('50.00')
        ->assertSee('data-action="' . route('expense.update', $expense) . '"', false)
        ->assertSee('data-expense-id="' . $expense->id . '"', false)
        ->assertSee('data-product="Printer paper"', false)
        ->assertSee('data-price="42.75"', false);
});
