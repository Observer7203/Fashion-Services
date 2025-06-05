<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\TourMedia;
use App\Models\TourPackage;
use App\Models\TourOption;
use App\Models\TourPreference;
use App\Models\TourSeason;
use Spatie\Translatable\HasTranslations;

class Tour extends Model
{
    use HasTranslations;

    public $translatable = [
        'title', 'subtitle', 'short_description', 'description',
        'faq', 'locations'
    ];

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'short_description',
        'description',
        'price',
        'packages',
        'included',
        'additional_options',
        'individual_preferences',
        'faq',
        'locations',
        'media',
        'seasons',
        'reservation_type_id',
    ];

    protected $casts = [
        'title' => 'json',
        'subtitle' => 'json',
        'short_description' => 'json',
        'description' => 'json',
        'faq' => 'json',
        'locations' => 'json',
        'packages' => 'array',
        'included' => 'array',
        'additional_options' => 'array',
        'individual_preferences' => 'array',
        'media' => 'array',
        'seasons' => 'array',
    ];

    public function reservationType(): BelongsTo
    {
        return $this->belongsTo(ReservationType::class);
    }

    public function packages() { return $this->hasMany(TourPackage::class); }
    public function options() { return $this->hasMany(TourOption::class); }
    public function preferences() { return $this->hasMany(TourPreference::class); }
    public function seasons() { return $this->hasMany(TourSeason::class); }
    public function media() { return $this->hasMany(TourMedia::class); }
    public function events() { return $this->belongsToMany(Event::class); }

    public function calculateFullPrice(): float
    {
        $total = 0;

        foreach ($this->packages as $package) {
            $total += $package->price;
        }

        foreach ($this->options as $option) {
            $total += $option->price;
        }

        foreach ($this->preferences as $pref) {
            $total += $pref->extra_cost;
        }

        return $total;
    }
}
