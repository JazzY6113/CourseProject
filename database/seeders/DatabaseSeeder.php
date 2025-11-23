<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            TourDateStatusSeeder::class,
            BookingStatusSeeder::class,
            UserSeeder::class,
            TourDateSeeder::class,
        ]);
    }
}
