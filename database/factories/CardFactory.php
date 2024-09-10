<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;

/**
 * @extends Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::inRandomOrder()->first(),
            'gr' => fake()->randomNumber(1, true),
            'el' => fake()->randomNumber(1, true),
            'ms' => fake()->randomNumber(1, true),
            'rp' => fake()->randomNumber(1, true),
            'data' => fake()->sentence(1, true),
        ];
    }
}
