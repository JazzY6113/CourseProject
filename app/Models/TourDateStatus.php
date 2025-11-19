<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDateStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_date_status_name',
    ];

    public function tourDates()
    {
        return $this->hasMany(TourDate::class);
    }
}
