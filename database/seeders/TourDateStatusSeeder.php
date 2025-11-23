<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TourDateStatus;

class TourDateStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['id' => 1, 'tour_date_status_name' => 'available'],
            ['id' => 2, 'tour_date_status_name' => 'fully_booked'],
            ['id' => 3, 'tour_date_status_name' => 'cancelled'],
        ];

        foreach ($statuses as $status) {
            TourDateStatus::updateOrCreate(
                ['id' => $status['id']],
                $status
            );
        }
    }
}
