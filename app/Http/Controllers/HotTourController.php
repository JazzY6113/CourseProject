<?php

namespace App\Http\Controllers;

use App\Models\Tour;

class HotTourController extends Controller
{
    /**
     * Показать горящие туры
     */
    public function index()
    {
        $hotTours = Tour::where('is_active', true)
            ->whereHas('tourDates', function($query) {
                $query->where('start_date', '>', now())
                    ->where('available_seats', '>', 0)
                    ->orderBy('start_date');
            })
            ->with(['images', 'tourDates' => function($query) {
                $query->where('start_date', '>', now())
                    ->where('available_seats', '>', 0)
                    ->orderBy('start_date')
                    ->limit(1);
            }])
            ->get()
            ->sortBy(function($tour) {
                return $tour->tourDates->first()->start_date ?? now()->addYears(10);
            })
            ->take(3);

        return view('hot', compact('hotTours'));
    }
}
