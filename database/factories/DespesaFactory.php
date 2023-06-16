<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Despesa>
 */
class DespesaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => fake()->company(),
            'data' => fake()->date(),
            'valor' => fake()->randomFloat(2, 0, 1000),
            'dono' => User::inRandomOrder()->first()->id,
        ];
    }
}
