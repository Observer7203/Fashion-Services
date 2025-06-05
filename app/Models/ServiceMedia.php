<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceMedia extends Model
{
    use HasTranslations;

    public $translatable = ['quote_text'];

    protected $fillable = [
        'service_id',
        'type',
        'media_type',
        'path',
        'quote_text',
        'position',
        'is_active',
    ];

    protected $casts = [
        'quote_text' => 'json',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

