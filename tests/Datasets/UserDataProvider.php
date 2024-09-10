<?php

namespace Tests\Datasets;

final class UserDataProvider
{
    public static function getRightUser(): array
    {
        return [
            'Right User' => [
                'department_id' => fake()->randomDigitNotNull(),
                'name' => fake()->name(),
                'password' => fake()->bothify('?????-#####'),
                'role' => fake()->randomElement(['usersAdmin', 'viewOnly', 'user']),
            ]
        ];
    }

    public static function getWrongUser(): array
    {
        return [
            'Wrong department id' => [
                'department_id' => fake()->name(),
                'name' => fake()->name(),
                'password' => fake()->bothify('?????-#####'),
                'role' => fake()->randomElement(['usersAdmin', 'viewOnly', 'user']),
            ],
            'Wrong name' => [
                'department_id' => fake()->randomDigitNotNull(),
                'name' => fake()->randomDigitNotNull(),
                'password' => fake()->bothify('?????-#####'),
                'role' => fake()->randomElement(['usersAdmin', 'viewOnly', 'user']),
            ],
            'Wrong password' => [
                'department_id' => fake()->randomDigitNotNull(),
                'name' => fake()->name(),
                'password' => fake()->bothify('?????'),
                'role' => fake()->randomElement(['usersAdmin', 'viewOnly', 'user']),
            ],
            'Wrong role' => [
                'department_id' => fake()->randomDigitNotNull(),
                'name' => fake()->name(),
                'password' => fake()->bothify('?????-#####'),
                'role' => fake()->name(),
            ]
        ];
    }
}
