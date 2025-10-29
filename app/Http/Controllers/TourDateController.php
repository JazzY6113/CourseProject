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
            'tour_date_status_id' => 'sometimes|exists:tour_date_statuses,id',
        ]);

        $tourDate = TourDate::create([
            ...$validated,
            'tour_date_status_id' => $validated['tour_date_status_id'] ?? 1, // По умолчанию "available"
        ]);

        return response()->json($tourDate, 201);
    }

    /**
     * Обновить дату тура
     * PUT /api/tour-dates/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $tourDate = TourDate::findOrFail($id);

        $validated = $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'available_seats' => 'sometimes|integer|min:0',
            'current_price' => 'sometimes|numeric|min:0',
            'tour_date_status_id' => 'sometimes|exists:tour_date_statuses,id',
        ]);

        $tourDate->update($validated);

        return response()->json($tourDate);
    }

    /**
     * Удалить дату тура
     * DELETE /api/tour-dates/{id}
     */
    public function destroy($id): JsonResponse
    {
        $tourDate = TourDate::findOrFail($id);
        $tourDate->delete();

        return response()->json(null, 204);
    }
}
