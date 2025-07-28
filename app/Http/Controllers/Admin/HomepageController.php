<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homepage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller
{
        public function edit()
    {
        $homepage = Homepage::firstOrCreate([]);

        $homepage->slides = $homepage->slides ?? [
            [
                'bg' => 'https://thumbsnap.com/i/BUr92HgV.jpg?0520',
                'title' => 'BAKTYGUL BULATKALI',
                'subtitle' => 'Fashion stylist',
                'description' => 'Fashion influencer with unique own vision in fashion industry advancing freshness and creativity',
                'button_text' => 'LEARN MORE',
                'button_url' => route('about'),
            ],
            [
                'bg' => 'https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/379410672_845717123525682_6733083808991049778_n.jpg?_t=1747850731',
                'title' => 'TOUR ACTIONS',
                'subtitle' => 'Fashion stylist',
                'description' => 'Seasonal discounts with VIP access to exclusive worldwide fashion events & runway shows',
                'button_text' => 'LEARN MORE',
                'button_url' => '#',
            ],
        ];

        $homepage->about_bg = $homepage->about_bg ?? 'https://thumbsnap.com/i/qAsZZaWT.jpg';
        $homepage->about_text = $homepage->about_text ?? 'Fashion stylist, personalized selection of clothing and accessories, boutique shopping assistance, and creation of individual looks tailored to your style and goals.';

        return view('admin.homepage.edit', compact('homepage'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'slides' => 'required|array',
            'slides.*.bg' => 'required|string',
            'slides.*.title' => 'nullable|string',
            'slides.*.subtitle' => 'nullable|string',
            'slides.*.description' => 'nullable|string',
            'slides.*.button_text' => 'nullable|string',
            'slides.*.button_url' => 'nullable|string',
            'about_bg' => 'nullable|string',
            'about_text' => 'nullable|string',
        ]);

        $homepage = Homepage::first();
        $homepage->slides = $data['slides'];
        $homepage->about_bg = $data['about_bg'];
        $homepage->about_text = $data['about_text'];
        $homepage->save();

        return back()->with('success', 'Главная страница обновлена');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,mp4,mov,avi|max:102400', // до 100MB
        ]);

        $path = $request->file('file')->store('uploads', 'public');
        return response()->json(['url' => Storage::url($path)]);
    }
}

