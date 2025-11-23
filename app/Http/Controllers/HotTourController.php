<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Support\Facades\DB;

class HotTourController extends Controller
{
    public function index()
    {
        $hotTours = Tour::where('is_active', true)
            ->whereHas('tourDates', function($query) {
                $query->where('start_date', '>', now())
                    ->where('available_seats', '>', 0)
                    ->where('tour_date_status_id', 1);
            })
            ->with(['images', 'tourDates' => function($query) {
                $query->where('start_date', '>', now())
                    ->where('available_seats', '>', 0)
                    ->where('tour_date_status_id', 1)
                    ->orderBy('start_date')
                    ->limit(1);
            }])
            ->get()
            ->map(function($tour) {
                $tour->nearest_date = $tour->tourDates->first();
                return $tour;
            })
            ->sortBy(function($tour) {
                return $tour->nearest_date ? $tour->nearest_date->start_date : now()->addYears(10);
            })
            ->take(3);

        return view('hot', compact('hotTours'));
    }
}
