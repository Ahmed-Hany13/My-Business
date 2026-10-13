<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'product' => $this->faker->word(),
            'monthly_payment' => $this->faker->randomFloat(2, 100, 1000),
            'balance' => $this->faker->randomFloat(2, 0, 5000),
            'debt' => $this->faker->randomFloat(2, 0, 2000),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'notes' => $this->faker->paragraph(),
        ];
    }
}
