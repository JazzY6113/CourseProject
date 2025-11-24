<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'start_date',
        'end_date',
        'available_seats',
        'current_price',
        'is_guaranteed',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'current_price' => 'decimal:2',
        'is_guaranteed' => 'boolean',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function confirmedBookings()
    {
        return $this->bookings()->whereHas('status', function($query) {
            $query->whereIn('name', ['confirmed', 'paid']);
        });
    }

    public function getBookedSeatsAttribute()
    {
        return $this->confirmedBookings()->sum('adults_count') + $this->confirmedBookings()->sum('children_count');
    }

    public function getIsAvailableAttribute()
    {
        return $this->available_seats > 0 && $this->start_date > now();
    }

    public function getIsFullyBookedAttribute()
    {
        return $this->available_seats <= 0;
    }

    public function getBookingDeadlineAttribute()
    {
        return $this->start_date->subDays($this->tour->booking_deadline_days);
    }
}
