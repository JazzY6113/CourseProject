<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tour_id',
        'tour_date_status_id',
        'start_date',
        'end_date',
        'available_seats',
        'current_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'current_price' => 'decimal:2',
        ];
    }

    /**
     * Get the tour that owns the tour date.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Get the tour date status that owns the tour date.
     */
    public function tourDateStatus()
    {
        return $this->belongsTo(TourDateStatus::class);
    }

    /**
     * Get the bookings for the tour date.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
