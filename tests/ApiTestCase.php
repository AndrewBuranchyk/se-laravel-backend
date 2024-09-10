<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\{Department, User};
use Database\Seeders\{DepartmentSeeder, UserSeeder};

abstract class ApiTestCase extends BaseTestCase
{
    protected const array USER_EMAILS = [
        "admin" => "admin@test.com",
        "usersAdmin" => "usersAdmin@test.com",
        "viewOnly" => "viewOnly@test.com",
        "user" => "user@test.com"
    ];

    /**
     * Test reading a listing of the resource.
     */
    abstract public function test_read_resource_list(): void;

    /**
     * Test creating a new resource with right data.
     */
    abstract public function test_create_resource_with_right_data(): void;

    /**
     * Test creating a new resource with wrong data.
     */
    abstract public function test_create_resource_with_wrong_data(): void;

    /**
     * Test reading the specified resource with right id.
     */
    abstract public function test_read_resource_with_right_id(): void;

    /**
     * Test reading the specified resource with wrong id.
     */
    abstract public function test_read_resource_with_wrong_id(): void;

    /**
     * Test updating the specified resource with right data.
     */
    abstract public function test_update_resource_with_right_data(): void;

    /**
     * Test updating the specified resource with wrong data.
     */
    abstract public function test_update_resource_with_wrong_data(): void;

    /**
     * Test deleting the specified resource with right id.
     */
    abstract public function test_delete_resource_with_right_id(): void;

    /**
     * Test deleting the specified resource with wrong id.
     */
    abstract public function test_delete_resource_with_wrong_id(): void;

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
