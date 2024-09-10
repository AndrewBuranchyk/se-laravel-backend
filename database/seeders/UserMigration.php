<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Traits\Crypt;

class UserMigration extends Seeder
{
    use Crypt, WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (DB::connection('mariadb')->table('iweb_user')->get() as $user) {
            $role = 'user';
            if (Str::contains($user->roles, 'admin')) {
                $role = 'admin';
            }
            if (Str::contains($user->roles, 'users')) {
                $role = 'usersAdmin';
            }
            User::updateOrCreate(
                ['id' => $user->id],
                [
                    'name' => $this->decryptStr($user->name),
                    'email' => $this->decryptStr($user->email),
                    'password' => $this->decryptStr($user->pass),
                    'department_id' => $user->cong_id,
                    'role' => $role,
                    'remember_token' => Str::random(10),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
