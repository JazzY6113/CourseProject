<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'tour_id',
        'author_name',
        'rating',
        'comment',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tour that the review is for.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Get author name (user's name or custom author name)
     */
    public function getAuthorNameAttribute()
    {
        if ($this->user_id && $this->user) {
            return $this->user->first_name . ' ' . $this->user->last_name;
        }

        return $this->attributes['author_name'] ?? 'Анонимный пользователь';
    }

    /**
     * Get author avatar
     */
    public function getAuthorAvatarAttribute()
    {
        if ($this->user_id && $this->user) {
            return $this->user->avatar_url;
        }

        return asset('img/default-avatar.png');
    }

    /**
     * Scope a query to only include approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending reviews.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Check if review is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if review is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Get formatted created date in Russian.
     */
    public function getFormattedDateAttribute()
    {
        $months = [
            1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
            5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
            9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
        ];

        return $this->created_at->format('d') . ' ' . $months[$this->created_at->format('n')] . ' ' . $this->created_at->format('Yг.');
    }

    /**
     * Get star rating HTML.
     */
    public function getStarRatingAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<img src="' . asset('img/звезда.svg') . '" alt="star' . $i . '" style="width: 20px; height: 20px;">';
            } else {
                $stars .= '<img src="' . asset('img/star-empty.svg') . '" alt="star' . $i . '" style="width: 20px; height: 20px;">';
            }
        }
        return $stars;
    }

    /**
     * Get short comment (first 100 characters)
     */
    public function getShortCommentAttribute()
    {
        return strlen($this->comment) > 100
            ? substr($this->comment, 0, 100) . '...'
            : $this->comment;
    }
}
