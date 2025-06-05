<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'media',
        'category',
        'stock',
        'status',
        'options',
    ];

    protected $casts = [
        'media' => 'array',
        'options' => 'array',
    ];
}
