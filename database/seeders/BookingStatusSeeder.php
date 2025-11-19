<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookingStatus;

class BookingStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['booking_status_name' => 'pending'],
            ['booking_status_name' => 'confirmed'],
            ['booking_status_name' => 'cancelled'],
            ['booking_status_name' => 'completed'],
        ];

        foreach ($statuses as $status) {
            BookingStatus::create($status);
        }
    }
}
