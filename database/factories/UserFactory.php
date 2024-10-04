<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\{Department, User};

/**
 * @extends Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $email = fake()->unique()->safeEmail();
        } while (User::where('email', $email)->first());

        return [
            'name' => fake()->name(),
            'email' => $email,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123456'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement(['admin', 'usersAdmin', 'viewOnly', 'user']),
            'department_id' => Department::inRandomOrder()->first(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
