<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourDate;
use Carbon\Carbon;

class TourDateSeeder extends Seeder
{
    public function run()
    {
        $tours = Tour::all();

        foreach ($tours as $tour) {
            for ($i = 1; $i <= 4; $i++) {
                $startDate = Carbon::now()->addDays($i * 15);
                $endDate = $startDate->copy()->addDays($tour->duration_days - 1);

                TourDate::firstOrCreate(
                    [
                        'tour_id' => $tour->id,
                        'start_date' => $startDate->format('Y-m-d'),
                    ],
                    [
                        'end_date' => $endDate->format('Y-m-d'),
                        'available_seats' => $tour->max_group_size,
                        'current_price' => $tour->base_price * (1 + ($i * 0.1)),
                        'is_guaranteed' => $i <= 2,
                        'notes' => $i <= 2 ? 'Гарантированный departure' : null,
                    ]
                );
            }
        }

        echo "Созданы даты туров:\n";
        $tourDates = TourDate::with('tour')->get();
        foreach ($tourDates as $date) {
            echo "- {$date->tour->title}: {$date->start_date} - {$date->end_date} ({$date->current_price} руб.)\n";
        }
    }
}
