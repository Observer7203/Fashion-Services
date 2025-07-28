<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'description',
        'short_description',
        'price',
        'media',
        'stock',
        'status',
        'attributes',
        'service_id',
        'tour_id',
    ];

    public $translatable = [
        'title',
        'description',
        'short_description',
    ];

    protected $casts = [
        'media' => 'array',
        'attributes' => 'array',
    ];

    // Связь с услугой
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Связь с туром
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
