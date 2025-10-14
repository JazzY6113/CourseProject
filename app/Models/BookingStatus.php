<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_status_name',
    ];

    /**
     * Get the bookings for the booking status.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
