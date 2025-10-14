<?php

namespace App\Http\Controllers;

use App\Models\TourDate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TourDateController extends Controller
{
    /**
     * Получить доступные даты для тура
     * GET /api/tours/{tourId}/dates
     */
    public function index($tourId): JsonResponse
    {
        $dates = TourDate::where('tour_id', $tourId)
            ->where('available_seats', '>', 0)
            ->where('start_date', '>', now())
            ->with('tourDateStatus')
            ->orderBy('start_date')
            ->get();

        return response()->json($dates);
    }

    /**
     * Создать новую дату для тура
     * POST /api/tour-dates
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'available_seats' => 'required|integer|min:1',
            'current_price' => 'required|numeric|min:0',
        ]);

        $tourDate = TourDate::create([
            ...$validated,
            'tour_date_status_id' => 1, // Предполагаем, что 1 = "available"
        ]);

        return response()->json($tourDate, 201);
    }
}
