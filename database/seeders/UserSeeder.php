<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userRole = Role::where('role_name', 'user')->first();
        $adminRole = Role::where('role_name', 'admin')->first();

        User::firstOrCreate(
            ['email' => 'JazzY6113@mail.ru'],
            [
                'role_id' => $adminRole->id,
                'first_name' => 'Кирилл',
                'last_name' => 'Богомолов',
                'email' => 'JazzY6113@mail.ru',
                'password_hash' => Hash::make('SuperAdmin1'),
                'is_email_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'Exz000@mail.ru'],
            [
                'role_id' => $userRole->id,
                'first_name' => 'Иван',
                'last_name' => 'Иванов',
                'email' => 'Exz000@mail.ru',
                'password_hash' => Hash::make('SuperUser1'),
                'is_email_verified' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
