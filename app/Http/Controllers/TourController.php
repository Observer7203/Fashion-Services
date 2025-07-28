<?php

namespace App\Http\Controllers;

use App\Models\Tour;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::latest()->get();
        return view('tours_2.index', compact('tours'));
    }

    public function show($locale, $slug)
    {    
        
        $tour = \App\Models\Tour::with([
            'media',
            'seasons',
            'packages.includes', // <- includes = TourPackageItem
            'packages.places',
            'packages.events',
            'options',
            'preferences'
        ])->where('slug', $slug)->firstOrFail();
        
        $tour = Tour::where('slug', $slug)->firstOrFail();
        return view('tours_2.show', compact('tour'));
    }
    
}
