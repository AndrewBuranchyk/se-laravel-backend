<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase;
use App\Models\{Department, User};
use Database\Seeders\{DepartmentSeeder, UserSeeder};

class ApiTestCase extends TestCase
{
    protected const array USER_EMAILS = [
        "admin" => "admin@test.com",
        "usersAdmin" => "usersAdmin@test.com",
        "viewOnly" => "viewOnly@test.com",
        "user" => "user@test.com"
    ];

    /**
     * Get test user by Email.
     *
     * @param string $userEmail
     * @return User | null
     */
    protected function getTestUserByEmail(string $userEmail): User | null
    {
        $user = User::where('email', $userEmail)->first();
        if (!$user){
            $this->seed(UserSeeder::class);
            $this->assertDatabaseHas('users', [
                'email' => $userEmail,
            ]);
            $user = User::where('email', $userEmail)->first();
        }

        return $user;
    }

    /**
     * Get Department.
     *
     * @return Department | null
     */
    protected function getDepartment(): Department | null
    {
        $department = Department::inRandomOrder()->first();
        if (!$department){
            $this->seed(DepartmentSeeder::class);
            $department = Department::inRandomOrder()->first();
        }

        return $department;
    }
}
