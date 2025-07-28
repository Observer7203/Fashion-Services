<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Homepage.php
class Homepage extends Model
{
    protected $fillable = ['slides', 'about_bg', 'about_text'];
    protected $casts = [
        'slides' => 'array',
    ];
}
