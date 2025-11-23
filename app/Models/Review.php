<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function getAuthorNameAttribute()
    {
        if ($this->user_id && $this->user) {
            return $this->user->first_name . ' ' . $this->user->last_name;
        }

        return $this->attributes['author_name'] ?? 'Анонимный пользователь';
    }

    public function getAuthorAvatarAttribute()
    {
        if ($this->user_id && $this->user) {
            return $this->user->avatar_url;
        }

        return asset('img/default-avatar.png');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function getFormattedDateAttribute()
    {
        $months = [
            1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
            5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
            9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
        ];

        return $this->created_at->format('d') . ' ' . $months[$this->created_at->format('n')] . ' ' . $this->created_at->format('Yг.');
    }

    public function getShortCommentAttribute()
    {
        return strlen($this->comment) > 100
            ? substr($this->comment, 0, 100) . '...'
            : $this->comment;
    }
}
