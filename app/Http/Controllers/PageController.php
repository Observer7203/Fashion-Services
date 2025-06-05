<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('pages.show', compact('page'));
    }

    public function about()
{
    // если нужна обычная страница:
    return view('about'); // если view называется about.blade.php
}

}
