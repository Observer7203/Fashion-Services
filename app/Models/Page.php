<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'content',
        'meta',
        'status',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * Получить SEO Title (падает на meta['title'], иначе title)
     */
    public function getSeoTitle(): string
    {
        return $this->meta['title'] ?? $this->title;
    }

    /**
     * Получить SEO Description (или пусто)
     */
    public function getSeoDescription(): ?string
    {
        return $this->meta['description'] ?? null;
    }

    /**
     * Получить OpenGraph изображение (или дефолтное)
     */
    public function getOgImage(): string
    {
        return $this->meta['og_image'] ?? '/images/default-og.png';
    }

    /**
     * Проверка — опубликована ли страница
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
