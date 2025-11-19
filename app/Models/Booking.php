<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

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

    protected function casts(): array
    {
        return [
            'booking_date' => 'datetime',
            'total_price' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tourDate()
    {
        return $this->belongsTo(TourDate::class);
    }

    public function bookingStatus()
    {
        return $this->belongsTo(BookingStatus::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
