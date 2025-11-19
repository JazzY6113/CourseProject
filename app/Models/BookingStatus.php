<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_status_name',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
