<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceInclude extends Model
{
    use HasTranslations;

    public $translatable = ['title'];

    protected $fillable = ['service_id', 'title'];

    protected $casts = [
        'title' => 'json',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
