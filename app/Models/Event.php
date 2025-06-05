<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'short_description',
        'description',
        'included',
        'dates',
        'media',
        'faq',
        'frequency',
        'seasons',
        'historical',
        'format',
        'participants',
        'organizers',
        'location',
        'streams',
        'tours_included',
    ];

    protected $casts = [
        'included' => 'array',
        'dates' => 'array',
        'media' => 'array',
        'faq' => 'array',
        'seasons' => 'array',
        'participants' => 'array',
        'organizers' => 'array',
        'streams' => 'array',
        'tours_included' => 'array',
    ];


    public function tourPackages()
{
    return $this->belongsToMany(TourPackage::class, 'event_tour_package');
}

}
