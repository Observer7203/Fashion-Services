<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutTestimonial extends Model
{
    protected $fillable = [
        'about_page_id', 'text', 'author', 'author_photo'
    ];

    public function aboutPage()
    {
        return $this->belongsTo(AboutPage::class);
    }
}
