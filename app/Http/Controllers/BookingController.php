<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TourDate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Получить бронирования текущего пользователя
     * GET /api/bookings
     */
    public function index(): JsonResponse
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['tourDate.tour', 'bookingStatus'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookings);
    }

    /**
     * Создать новое бронирование
     * POST /api/bookings
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tour_date_id' => 'required|exists:tour_dates,id',
            'guests_count' => 'required|integer|min:1',
            'contact_phone' => 'required|string|max:255',
            'special_requests' => 'nullable|string',
        ]);

        // Проверяем доступность даты тура
        $tourDate = TourDate::findOrFail($validated['tour_date_id']);

        if ($tourDate->available_seats < $validated['guests_count']) {
            return response()->json([
                'message' => 'Недостаточно свободных мест'
            ], 422);
        }

        // Создаем бронирование
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'tour_date_id' => $validated['tour_date_id'],
            'booking_status_id' => 1, // Предполагаем, что 1 = "pending"
            'guests_count' => $validated['guests_count'],
            'total_price' => $tourDate->current_price * $validated['guests_count'],
            'contact_phone' => $validated['contact_phone'],
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        // Обновляем количество доступных мест
        $tourDate->decrement('available_seats', $validated['guests_count']);

        return response()->json($booking->load(['tourDate.tour', 'bookingStatus']), 201);
    }

    /**
     * Отменить бронирование
     * PUT /api/bookings/{id}/cancel
     */
    public function cancel($id): JsonResponse
    {
        $booking = Booking::where('user_id', Auth::id())
            ->findOrFail($id);

        // Возвращаем места
        $booking->tourDate->increment('available_seats', $booking->guests_count);

        // Обновляем статус бронирования
        $booking->update(['booking_status_id' => 3]); // Предполагаем, что 3 = "cancelled"

        return response()->json($booking);
    }
}
