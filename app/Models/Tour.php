<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'short_description',
        'full_description',
        'price',
        'booking_deadline',
        'is_active',
        'duration_days',
        'max_group_size',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'booking_deadline' => 'datetime',
            'is_active' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the tour dates for the tour.
     */
    public function tourDates()
    {
        return $this->hasMany(TourDate::class);
    }

    /**
     * Get the bookings for the tour through tour dates.
     */
    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, TourDate::class);
    }
}
