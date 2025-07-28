<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
        'banner_bg_url', 'about_image', 'about_profession', 'about_name', 'about_title', 'about_description', 'about_quote'
    ];

    public function testimonials()
    {
        return $this->hasMany(AboutTestimonial::class);
    }

    public function experiences()
    {
        return $this->hasMany(AboutExperience::class)->orderBy('position');
    }

    public function projects()
    {
        return $this->hasMany(AboutProject::class)->orderBy('position');
    }

    public function stats()
    {
        return $this->hasMany(AboutStat::class);
    }
}
