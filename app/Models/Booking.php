<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'tour_date_id',
        'booking_status_id',
        'adults_count',
        'children_count',
        'total_price',
        'paid_amount',
        'contact_phone',
        'contact_email',
        'special_requests',
        'participants_info',
        'expires_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'booking_date' => 'datetime',
        'expires_at' => 'datetime',
        'participants_info' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = 'BK-' . date('Ymd') . '-' . strtoupper(uniqid());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tourDate()
    {
        return $this->belongsTo(TourDate::class);
    }

    public function status()
    {
        return $this->belongsTo(BookingStatus::class, 'booking_status_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getTotalParticipantsAttribute()
    {
        return $this->adults_count + $this->children_count;
    }

    public function getRemainingAmountAttribute()
    {
        return $this->total_price - $this->paid_amount;
    }

    public function getIsPaidAttribute()
    {
        return $this->paid_amount >= $this->total_price;
    }

    public function canBeCancelled()
    {
        $cancellableStatuses = ['pending', 'confirmed'];
        $canCancelByStatus = in_array($this->status->name, $cancellableStatuses);

        $isNotExpired = !$this->is_expired;

        $hasEnoughTime = $this->tourDate->start_date > now()->addDays(3);

        return $canCancelByStatus && $isNotExpired && $hasEnoughTime;
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
