<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TourDate;
use App\Models\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;

class BookingController extends Controller
{
    public function showBookingForm($tourDateId)
    {
        $tourDate = TourDate::with(['tour.images'])
            ->where('id', $tourDateId)
            ->where('start_date', '>', now())
            ->where('available_seats', '>', 0)
            ->firstOrFail();

        return view('bookings.form', compact('tourDate'));
    }

    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'tour_date_id' => 'required|exists:tour_dates,id',
                'adults_count' => 'required|integer|min:1|max:10',
                'children_count' => 'required|integer|min:0|max:5',
                'contact_phone' => 'required|string|max:20',
                'contact_email' => 'required|email',
                'special_requests' => 'nullable|string|max:1000',
                'participants' => 'required|string',
            ]);

            $tourDate = TourDate::with('tour')->findOrFail($validated['tour_date_id']);
            $totalParticipants = $validated['adults_count'] + $validated['children_count'];

            if ($tourDate->available_seats < $totalParticipants) {
                return response()->json([
                    'success' => false,
                    'message' => 'Недостаточно свободных мест. Доступно: ' . $tourDate->available_seats
                ], 422);
            }

            $bookingDeadline = $tourDate->start_date->subDays($tourDate->tour->booking_deadline_days);
            if (now()->gt($bookingDeadline)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Бронирование на эту дату закрыто. Дедлайн: ' . $bookingDeadline->format('d.m.Y')
                ], 422);
            }

            $adultPrice = $tourDate->current_price;
            $childPrice = $adultPrice * 0.7;
            $totalPrice = ($adultPrice * $validated['adults_count']) + ($childPrice * $validated['children_count']);

            $pendingStatus = BookingStatus::where('name', 'pending')->first();

            $participants = json_decode($validated['participants'], true);

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'tour_date_id' => $validated['tour_date_id'],
                'booking_status_id' => $pendingStatus->id,
                'adults_count' => $validated['adults_count'],
                'children_count' => $validated['children_count'],
                'total_price' => $totalPrice,
                'contact_phone' => $validated['contact_phone'],
                'contact_email' => $validated['contact_email'],
                'special_requests' => $validated['special_requests'] ?? null,
                'participants_info' => $participants,
                'expires_at' => now()->addHours(24),
            ]);

            $tourDate->decrement('available_seats', $totalParticipants);

            try {
                Mail::to($validated['contact_email'])
                    ->send(new \App\Mail\BookingConfirmationMail($booking));
            } catch (\Exception $e) {
                Log::error('Email sending failed: ' . $e->getMessage());
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'booking' => $booking->load(['tourDate.tour', 'status']),
                'message' => 'Бронирование успешно создано! Подтверждение отправлено на email.'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при бронировании: ' . $e->getMessage()
            ], 500);
        }
    }

    public function confirm($bookingId)
    {
        try {
            DB::beginTransaction();

            $booking = Booking::where('user_id', Auth::id())
                ->with(['tourDate', 'status'])
                ->findOrFail($bookingId);

            if ($booking->status->name !== 'pending') {
                throw new \Exception('Невозможно подтвердить эту бронь');
            }

            $confirmedStatus = BookingStatus::where('name', 'confirmed')->first();
            $booking->update(['booking_status_id' => $confirmedStatus->id]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Бронь подтверждена!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function cancel($bookingId): JsonResponse
    {
        try {
            DB::beginTransaction();

            $booking = Booking::where('user_id', Auth::id())
                ->with(['tourDate', 'status'])
                ->findOrFail($bookingId);

            if (!$booking->canBeCancelled()) {
                $reasons = [];

                if (!in_array($booking->status->name, ['pending', 'confirmed'])) {
                    $reasons[] = 'неправильный статус (' . $booking->status->name . ')';
                }

                if ($booking->is_expired) {
                    $reasons[] = 'бронь истекла';
                }

                if ($booking->tourDate->start_date <= now()->addDays(3)) {
                    $reasons[] = 'до начала тура осталось меньше 3 дней';
                }

                throw new \Exception('Невозможно отменить эту бронь: ' . implode(', ', $reasons));
            }

            $booking->tourDate->increment('available_seats', $booking->total_participants);

            $cancelledStatus = BookingStatus::where('name', 'cancelled')->first();
            $booking->update(['booking_status_id' => $cancelledStatus->id]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Бронирование успешно отменено'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking cancellation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function userBookings()
    {
        $bookings = Booking::with(['tourDate.tour.images', 'status'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.user-list', compact('bookings'));
    }
}
