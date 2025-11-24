<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            BookingStatusSeeder::class,
            TourSeeder::class,
            TourDateSeeder::class,
            UserSeeder::class,
        ]);

        echo "\nБаза данных успешно заполнена!\n";
        echo "===============================\n";
        echo "Данные для входа:\n";
        echo "Администратор: JazzY6113@mail.ru / SuperAdmin1\n";
        echo "Пользователь: Exz000@mail.ru / SuperUser1\n";
    }
}
