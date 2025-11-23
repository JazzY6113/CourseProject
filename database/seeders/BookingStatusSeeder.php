<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookingStatus;

class BookingStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['id' => 1, 'booking_status_name' => 'pending'],
            ['id' => 2, 'booking_status_name' => 'confirmed'],
            ['id' => 3, 'booking_status_name' => 'cancelled'],
            ['id' => 4, 'booking_status_name' => 'completed'],
        ];

        foreach ($statuses as $status) {
            BookingStatus::updateOrCreate(
                ['id' => $status['id']],
                $status
            );
        }
    }
}
