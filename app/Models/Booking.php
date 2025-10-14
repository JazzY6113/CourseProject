<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'tour_date_id',
        'booking_status_id',
        'booking_date',
        'guests_count',
        'total_price',
        'contact_phone',
        'special_requests',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'booking_date' => 'datetime',
            'total_price' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tour date that owns the booking.
     */
    public function tourDate()
    {
        return $this->belongsTo(TourDate::class);
    }

    /**
     * Get the booking status that owns the booking.
     */
    public function bookingStatus()
    {
        return $this->belongsTo(BookingStatus::class);
    }

    /**
     * Get the review for the booking.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
