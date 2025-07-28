<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\TourMedia;
use App\Models\TourPackage;
use App\Models\TourOption;
use App\Models\TourPreference;
use App\Models\TourSeason;
use App\Models\ReservationType;
use App\Models\Event;
use Spatie\Translatable\HasTranslations;

class Tour extends Model
{
    use HasTranslations;

    public $translatable = [
        'title', 'subtitle', 'short_description', 'description',
        'faq', 'locations', 'frequencies'
    ];

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'short_description',
        'description',
        'price',
        'faq',
        'locations',
        'frequencies',
        'reservation_type_id',
    ];

    protected $casts = [
        'title' => 'json',
        'subtitle' => 'json',
        'short_description' => 'json',
        'description' => 'json',
        'faq' => 'json',
        'locations' => 'json',
        'frequencies' => 'json',
    ];

    public function reservationType(): BelongsTo
    {
        return $this->belongsTo(ReservationType::class);
    }

        public function product()
    {
        return $this->hasOne(\App\Models\Product::class);
    }


    public function packages() { return $this->hasMany(TourPackage::class); }
    public function options() { return $this->hasMany(TourOption::class); }
    public function preferences() { return $this->hasMany(TourPreference::class); }
    public function seasons() { return $this->hasMany(TourSeason::class); }
    public function media() { return $this->hasMany(TourMedia::class); }
    public function events() { return $this->belongsToMany(Event::class); }
    public function mainImage()  { return $this->hasOne(TourMedia::class)->where('role', 'main_image'); }
    public function mainVideo()  { return $this->hasOne(TourMedia::class)->where('role', 'main_video'); }
    public function banner()     { return $this->hasOne(TourMedia::class)->where('role', 'banner'); }
    public function breadcrumbsBg() { return $this->hasOne(TourMedia::class)->where('role', 'breadcrumbs_bg'); }
    public function gallery()    { return $this->hasMany(TourMedia::class)->where('role', 'gallery')->orderBy('sort'); }

    public function getMainImageUrlAttribute(): ?string
{
    return optional($this->media->firstWhere('role', 'main_image'))?->url;
}

public function getMainVideoUrlAttribute(): ?string
{
    return optional($this->media->firstWhere('role', 'main_video'))?->url;
}

public function getBannerImageUrlAttribute(): ?string
{
    return optional($this->media->firstWhere('role', 'banner'))?->url;
}

public function getBreadcrumbsBgUrlAttribute(): ?string
{
    return optional($this->media->firstWhere('role', 'breadcrumbs_bg'))?->url;
}


    public function calculateFullPrice(): float
    {
        $total = 0;

        foreach ($this->packages()->get() as $package) {
            $total += $package->price;
        }

        foreach ($this->options()->get() as $option) {
            $total += $option->price;
        }

        foreach ($this->preferences()->get() as $pref) {
            $total += $pref->extra_cost;
        }

        return $total;
    }
}
