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
        $userRole = Role::where('name', 'user')->first();
        $adminRole = Role::where('name', 'admin')->first();

        if (!$userRole || !$adminRole) {
            throw new \Exception('Роли не найдены в базе данных');
        }

        User::firstOrCreate(
            ['email' => 'JazzY6113@mail.ru'],
            [
                'role_id' => $adminRole->id,
                'first_name' => 'Кирилл',
                'last_name' => 'Богомолов',
                'patronymic' => null,
                'email' => 'JazzY6113@mail.ru',
                'phone' => '+79999999999',
                'password' => Hash::make('SuperAdmin1'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'Exz000@mail.ru'],
            [
                'role_id' => $userRole->id,
                'first_name' => 'Иван',
                'last_name' => 'Иванов',
                'patronymic' => 'Петрович',
                'email' => 'Exz000@mail.ru',
                'phone' => '+78888888888',
                'password' => Hash::make('SuperUser1'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        echo "Созданы пользователи:\n";
        echo "- Администратор: JazzY6113@mail.ru / SuperAdmin1\n";
        echo "- Пользователь: Exz000@mail.ru / SuperUser1\n";
    }
}
