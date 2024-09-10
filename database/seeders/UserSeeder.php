<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getPayload() as $item){
            if (!User::where('email', $item['email'] ?? '')->first()){
                User::factory(1)->create($item);
            }
        }
        User::factory(20)->create();
    }

    /**
     * Get payload for seeding.
     *
     * @return array
     */
    public function getPayload(): array
    {
        return [
            [
                'name' => "admin",
                'email' => "admin@test.com",
                'role' => "admin",
            ],
            [
                'name' => "usersAdmin",
                'email' => "usersAdmin@test.com",
                'role' => "usersAdmin",
            ],
            [
                'name' => "viewOnly",
                'email' => "viewOnly@test.com",
                'role' => "viewOnly",
            ],
            [
                'name' => "user",
                'email' => "user@test.com",
                'role' => "user",
            ]
        ];
    }
}
