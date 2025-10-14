<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Получить отзывы для тура
     * GET /api/tours/{tourId}/reviews
     */
    public function index($tourId): JsonResponse
    {
        $reviews = Review::whereHas('booking.tourDate', function($query) use ($tourId) {
            $query->where('tour_id', $tourId);
        })
            ->with(['user', 'booking'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }

    /**
     * Создать новый отзыв
     * POST /api/reviews
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
        ]);

        // Проверяем, что бронирование принадлежит пользователю
        $booking = Booking::where('id', $validated['booking_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Проверяем, что отзыв еще не оставлен
        if (Review::where('booking_id', $validated['booking_id'])->exists()) {
            return response()->json([
                'message' => 'Отзыв для этого бронирования уже оставлен'
            ], 422);
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'booking_id' => $validated['booking_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json($review->load('user'), 201);
    }
}
