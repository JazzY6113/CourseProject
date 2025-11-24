<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatus;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'tourDate.tour', 'status'])
            ->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status) {
            $query->whereHas('status', function($q) use ($request) {
                $q->where('name', $request->status);
            });
        }

        $bookings = $query->paginate(20);
        $statuses = BookingStatus::all();

        return view('admin.bookings.index', compact('bookings', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status_id' => 'required|exists:booking_statuses,id'
        ]);

        $booking->update([
            'booking_status_id' => $request->status_id
        ]);

        return back()->with('success', 'Статус бронирования обновлен');
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'tourDate.tour', 'status'])->findOrFail($id);

        return response()->json([
            'booking' => $booking,
            'participants' => $booking->participants_info
        ]);
    }
}
