<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'tour_date_status_id',
        'start_date',
        'end_date',
        'available_seats',
        'current_price',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'current_price' => 'decimal:2',
        ];
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function tourDateStatus()
    {
        return $this->belongsTo(TourDateStatus::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
