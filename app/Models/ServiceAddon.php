<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class ServiceAddon extends Model
{
    use HasTranslations;

    public $translatable = ['title'];

    protected $fillable = [
        'service_id',
        'title',
        'price',
    ];

    protected $casts = [
        'title' => 'json',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
