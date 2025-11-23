<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TourDate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'tour_date_id' => 'required|exists:tour_dates,id',
                'guests_count' => 'required|integer|min:1|max:10',
                'contact_phone' => 'required|string|max:255',
                'special_requests' => 'nullable|string|max:1000',
            ]);

            $tourDate = TourDate::with('tour')->findOrFail($validated['tour_date_id']);

            if ($tourDate->available_seats < $validated['guests_count']) {
                return response()->json([
                    'message' => 'Недостаточно свободных мест. Доступно: ' . $tourDate->available_seats
                ], 422);
            }

            if ($tourDate->start_date <= now()) {
                return response()->json([
                    'message' => 'Невозможно забронировать прошедший тур'
                ], 422);
            }

            if ($tourDate->tour_date_status_id != 1) {
                return response()->json([
                    'message' => 'Эта дата тура недоступна для бронирования'
                ], 422);
            }

            $totalPrice = $tourDate->current_price * $validated['guests_count'];

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'tour_date_id' => $validated['tour_date_id'],
                'booking_status_id' => 1,
                'guests_count' => $validated['guests_count'],
                'total_price' => $totalPrice,
                'contact_phone' => $validated['contact_phone'],
                'special_requests' => $validated['special_requests'] ?? null,
                'booking_date' => now(),
            ]);

            $tourDate->decrement('available_seats', $validated['guests_count']);

            if ($tourDate->available_seats <= 0) {
                $tourDate->update(['tour_date_status_id' => 2]);
            }

            DB::commit();

            return response()->json([
                'booking' => $booking->load(['tourDate.tour', 'tourDate.tour.images', 'bookingStatus']),
                'message' => 'Бронирование успешно создано!'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Произошла ошибка при бронировании: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancel($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $booking = Booking::where('user_id', Auth::id())
                ->with('tourDate')
                ->findOrFail($id);

            $booking->tourDate->increment('available_seats', $booking->guests_count);

            $booking->update(['booking_status_id' => 3]);

            if ($booking->tourDate->tour_date_status_id == 2) {
                $booking->tourDate->update(['tour_date_status_id' => 1]);
            }

            DB::commit();

            return response()->json([
                'booking' => $booking->load(['tourDate.tour', 'bookingStatus']),
                'message' => 'Бронирование успешно отменено'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking cancellation error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Произошла ошибка при отмене бронирования'
            ], 500);
        }
    }
}
