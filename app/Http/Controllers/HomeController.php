<?php

namespace App\Http\Controllers;

use App\Models\Block;

class HomeController extends Controller
{
    public function index()
    {
        $blocks = Block::where('status', 'published')->orderBy('order')->get();
        return view('home', compact('blocks'));
    }
}
