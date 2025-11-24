<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'full_description',
        'base_price',
        'duration_days',
        'max_group_size',
        'min_group_size',
        'included',
        'not_included',
        'requirements',
        'is_active',
        'is_hot',
        'booking_deadline_days',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_hot' => 'boolean',
        'included' => 'array',
        'not_included' => 'array',
        'requirements' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(TourImage::class)->orderBy('order_index');
    }

    public function tourDates()
    {
        return $this->hasMany(TourDate::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function activeTourDates()
    {
        return $this->hasMany(TourDate::class)
            ->where('start_date', '>', now())
            ->where('available_seats', '>', 0)
            ->orderBy('start_date');
    }

    public function getMainImageAttribute()
    {
        return $this->images->where('is_main', true)->first()
            ?? $this->images->first();
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getNextDepartureAttribute()
    {
        return $this->activeTourDates()->first();
    }

    public function getBookingDeadlineForNextDepartureAttribute()
    {
        $nextDeparture = $this->nextDeparture;
        if ($nextDeparture) {
            return $nextDeparture->start_date->subDays($this->booking_deadline_days);
        }
        return null;
    }
}
