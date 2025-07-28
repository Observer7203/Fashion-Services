<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutExperience extends Model
{
    protected $fillable = [
        'about_page_id', 'image', 'title', 'description', 'position'
    ];

    public function aboutPage()
    {
        return $this->belongsTo(AboutPage::class);
    }
}
