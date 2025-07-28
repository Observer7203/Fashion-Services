<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::with(['mediaFiles'])->get();
        $blocks = Block::where('status', 'published')->orderBy('order')->get();
        $homepage = \App\Models\Homepage::first(); // добавляем
    
        return view('home', compact('services', 'homepage', 'blocks'));
    }    
}
