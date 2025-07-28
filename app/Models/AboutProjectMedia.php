<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutProjectMedia extends Model
{
    protected $fillable = [
        'about_project_id', 'media_type', 'media_url', 'position'
    ];

    public function project()
    {
        return $this->belongsTo(AboutProject::class, 'about_project_id');
    }
}
