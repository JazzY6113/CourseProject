<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

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

    protected function casts(): array
    {
        return [
            'booking_deadline' => 'datetime',
            'is_active' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    public function tourDates()
    {
        return $this->hasMany(TourDate::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, TourDate::class);
    }

    public function images()
    {
        return $this->hasMany(TourImage::class)->orderBy('order_index');
    }

    public static function getHotTours()
    {
        return self::where('is_active', true)
            ->whereHas('tourDates', function($query) {
                $query->where('start_date', '>', now())
                    ->where('available_seats', '>', 0)
                    ->orderBy('start_date');
            })
            ->with(['tourDates' => function($query) {
                $query->where('start_date', '>', now())
                    ->where('available_seats', '>', 0)
                    ->orderBy('start_date')
                    ->limit(1);
            }])
            ->get()
            ->sortBy(function($tour) {
                return $tour->tourDates->first()->start_date ?? now()->addYears(10);
            })
            ->take(3);
    }

    public static function getAllActiveTours()
    {
        return self::where('is_active', true)
            ->with(['images', 'tourDates' => function($query) {
                $query->where('start_date', '>', now())
                    ->where('available_seats', '>', 0)
                    ->orderBy('start_date');
            }])
            ->get();
    }

    public function getMainImageAttribute()
    {
        return $this->images->first()->image_path ?? null;
    }
}
