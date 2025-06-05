<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'key',
        'title',
        'content',
        'media',
        'type',   // image, video, slider, custom
        'order',
        'status'  // draft, published
    ];

    protected $casts = [
        'media' => 'array',
    ];

    /**
     * Проверка опубликован ли блок
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
