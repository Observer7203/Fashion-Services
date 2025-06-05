<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class TourPreference extends Model
{
    use HasTranslations;

    public $translatable = ['title'];

    protected $fillable = ['tour_id', 'title', 'price'];

    protected $casts = [
        'title' => 'json',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
