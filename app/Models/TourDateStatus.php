<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDateStatus extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tour_date_status_name',
    ];

    /**
     * Get the tour dates for the tour date status.
     */
    public function tourDates()
    {
        return $this->hasMany(TourDate::class);
    }
}
