<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tour;

class TourMedia extends Model
{
    protected $fillable = [
        'tour_id',
        'path',
        'type',
        'role',
        'mime',
        'sort',
    ];

    protected $appends = ['url'];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
