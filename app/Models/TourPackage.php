<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class TourPackage extends Model
{
    use HasTranslations;

    public $translatable = ['title'];

    protected $fillable = ['tour_id', 'title', 'price', 'currency'];

    protected $casts = [
        'title' => 'json',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function includes(): HasMany
    {
        return $this->hasMany(TourPackageItem::class);
    }

    public function places()
    {
        return $this->hasMany(TourPackagePlace::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_tour_package');
    }
}
