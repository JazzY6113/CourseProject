<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TourController extends Controller
{
    /**
     * Получить список всех активных туров
     * GET /api/tours
     */
    public function index(): JsonResponse
    {
        $tours = Tour::where('is_active', true)
            ->with(['tourDates' => function($query) {
                $query->where('available_seats', '>', 0)
                    ->where('start_date', '>', now());
            }])
            ->get();

        return response()->json($tours);
    }

    /**
     * Показать детальную информацию о туре
     * GET /api/tours/{id}
     */
    public function show($id): JsonResponse
    {
        $tour = Tour::with(['tourDates.tourDateStatus', 'tourDates.bookings'])
            ->findOrFail($id);

        return response()->json($tour);
    }

    /**
     * Создать новый тур (только для администраторов)
     * POST /api/tours
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'full_description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'booking_deadline' => 'required|date',
            'duration_days' => 'required|integer|min:1',
            'max_group_size' => 'required|integer|min:1',
        ]);

        $tour = Tour::create($validated);

        return response()->json($tour, 201);
    }

    /**
     * Обновить информацию о туре
     * PUT /api/tours/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $tour = Tour::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'short_description' => 'sometimes|string|max:255',
            'full_description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'booking_deadline' => 'sometimes|date',
            'is_active' => 'sometimes|boolean',
            'duration_days' => 'sometimes|integer|min:1',
            'max_group_size' => 'sometimes|integer|min:1',
        ]);

        $tour->update($validated);

        return response()->json($tour);
    }

    /**
     * Удалить тур
     * DELETE /api/tours/{id}
     */
    public function destroy($id): JsonResponse
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();

        return response()->json(null, 204);
    }
}
