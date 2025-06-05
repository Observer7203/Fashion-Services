<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourSeason extends Model
{
    protected $fillable = ['tour_id', 'start_date', 'end_date'];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
