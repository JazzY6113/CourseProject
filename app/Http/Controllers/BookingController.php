<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TourDate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(): JsonResponse
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['tourDate.tour', 'bookingStatus'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookings);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tour_date_id' => 'required|exists:tour_dates,id',
            'guests_count' => 'required|integer|min:1',
            'contact_phone' => 'required|string|max:255',
            'special_requests' => 'nullable|string',
        ]);

        $tourDate = TourDate::findOrFail($validated['tour_date_id']);

        if ($tourDate->available_seats < $validated['guests_count']) {
            return response()->json([
                'message' => 'Недостаточно свободных мест'
            ], 422);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'tour_date_id' => $validated['tour_date_id'],
            'booking_status_id' => 1,
            'guests_count' => $validated['guests_count'],
            'total_price' => $tourDate->current_price * $validated['guests_count'],
            'contact_phone' => $validated['contact_phone'],
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        $tourDate->decrement('available_seats', $validated['guests_count']);

        return response()->json($booking->load(['tourDate.tour', 'bookingStatus']), 201);
    }

    public function cancel($id): JsonResponse
    {
        $booking = Booking::where('user_id', Auth::id())
            ->findOrFail($id);

        $booking->tourDate->increment('available_seats', $booking->guests_count);

        $booking->update(['booking_status_id' => 3]);

        return response()->json($booking);
    }
}
