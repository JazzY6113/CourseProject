<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourDate;
use App\Models\TourDateStatus;
use Carbon\Carbon;

class TourDateSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['tour_date_status_name' => 'available'],
            ['tour_date_status_name' => 'fully_booked'],
            ['tour_date_status_name' => 'cancelled'],
        ];

        foreach ($statuses as $status) {
            TourDateStatus::firstOrCreate(
                ['tour_date_status_name' => $status['tour_date_status_name']],
                $status
            );
        }

        $availableStatus = TourDateStatus::where('tour_date_status_name', 'available')->first();

        $tours = Tour::all();

        foreach ($tours as $tour) {
            for ($i = 1; $i <= 3; $i++) {
                $startDate = Carbon::now()->addDays($i * 15);

                TourDate::create([
                    'tour_id' => $tour->id,
                    'tour_date_status_id' => $availableStatus->id,
                    'start_date' => $startDate,
                    'end_date' => $startDate->copy()->addDays($tour->duration_days - 1),
                    'available_seats' => $tour->max_group_size,
                    'current_price' => $tour->price,
                ]);
            }
        }
    }
}
