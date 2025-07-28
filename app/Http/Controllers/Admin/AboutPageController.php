<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutPageController extends Controller
{
    public function edit()
    {
        // Получаем одну страницу About с вложенными сущностями
        $about = AboutPage::with([
            'testimonials',
            'experiences',
            'projects.media',
            'stats'
        ])->first();

        // Если записи нет — создаём пустую
        if (!$about) {
            $about = AboutPage::create([
                'banner_bg_url' => null,
                'about_image' => null,
                'about_profession' => '',
                'about_name' => '',
                'about_title' => '',
                'about_description' => '',
                'about_quote' => '',
            ]);
            $about->load(['testimonials','experiences','projects.media','stats']);
        }

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        // Валидация основных полей
        $validated = $request->validate([
            'banner_bg_url' => 'nullable|string',
            'about_image' => 'nullable|string',
            'about_profession' => 'nullable|string|max:255',
            'about_name' => 'nullable|string|max:255',
            'about_title' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'about_quote' => 'nullable|string|max:255',
            // вложенные массивы валидацию можно реализовать по аналогии или на фронте
        ]);

        DB::transaction(function() use ($request, $validated) {
            $about = AboutPage::first();
            if (!$about) {
                abort(404, 'Страница "Обо мне" не найдена');
            }

            // Сохраняем основные поля
            $about->update($validated);

            // --- Отзывы ---
            $about->testimonials()->delete();
            if ($request->has('testimonials')) {
                foreach ($request->input('testimonials', []) as $testimonial) {
                    if (isset($testimonial['text']) && $testimonial['text']) {
                        $about->testimonials()->create([
                            'text' => $testimonial['text'],
                            'author' => $testimonial['author'] ?? null,
                            'author_photo' => $testimonial['author_photo'] ?? null,
                        ]);
                    }
                }
            }

            // --- Опыт ---
            $about->experiences()->delete();
            if ($request->has('experiences')) {
                foreach ($request->input('experiences', []) as $i => $experience) {
                    if (isset($experience['title']) && $experience['title']) {
                        $about->experiences()->create([
                            'image' => $experience['image'] ?? null,
                            'title' => $experience['title'],
                            'description' => $experience['description'] ?? '',
                            'position' => $i,
                        ]);
                    }
                }
            }

            // --- Портфолио проекты + медиа ---
            $about->projects()->each(function($project) {
                $project->media()->delete();
            });
            $about->projects()->delete();

            if ($request->has('projects')) {
                foreach ($request->input('projects', []) as $pIndex => $project) {
                    if (isset($project['project_title']) && $project['project_title']) {
                        $proj = $about->projects()->create([
                            'project_title' => $project['project_title'],
                            'position' => $pIndex,
                        ]);
                        if (isset($project['media']) && is_array($project['media'])) {
                            foreach ($project['media'] as $mIndex => $media) {
                                if (isset($media['media_url']) && $media['media_url']) {
                                    $proj->media()->create([
                                        'media_type' => $media['media_type'] ?? 'image',
                                        'media_url' => $media['media_url'],
                                        'position' => $mIndex,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            // --- Статистика ---
            $about->stats()->delete();
            if ($request->has('stats')) {
                foreach ($request->input('stats', []) as $stat) {
                    if (isset($stat['stat_name']) && $stat['stat_name']) {
                        $about->stats()->create([
                            'stat_name' => $stat['stat_name'],
                            'stat_value' => $stat['stat_value'] ?? '',
                            'stat_desc' => $stat['stat_desc'] ?? '',
                        ]);
                    }
                }
            }
        });

        return redirect()->back()->with('success', 'Страница "Обо мне" успешно обновлена!');
    }
}
