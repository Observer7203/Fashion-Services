<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutProject extends Model
{
    protected $fillable = [
        'about_page_id', 'project_title', 'position'
    ];

    public function aboutPage()
    {
        return $this->belongsTo(AboutPage::class);
    }

    public function media()
    {
        return $this->hasMany(AboutProjectMedia::class)->orderBy('position');
    }
}
