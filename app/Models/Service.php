<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ServiceAddon;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'subtitle', 'short_description', 'description'];

    protected $fillable = [
        'title',
        'subtitle',
        'short_description',
        'description',
        'media',
        'price',
        'currency',
        'reservation_type_id',
    ];

    protected $casts = [
        'title' => 'json',
        'subtitle' => 'json',
        'short_description' => 'json',
        'description' => 'json',
        'media' => 'array',
    ];

    public function reservationType(): BelongsTo
    {
        return $this->belongsTo(ReservationType::class);
    }

        public function product()
    {
        return $this->hasOne(\App\Models\Product::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(ServiceAddon::class);
    }

    public function includes()
    {
        return $this->hasMany(ServiceInclude::class);
    }

    public function mediaFiles()
    {
        return $this->hasMany(\App\Models\ServiceMedia::class, 'service_id');
    }
    
}
