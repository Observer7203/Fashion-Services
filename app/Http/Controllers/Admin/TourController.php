<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ReservationType;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::query();

        if ($request->filled('search')) {
            $query->where('title->' . app()->getLocale(), 'like', '%' . $request->search . '%')
                  ->orWhere('id', $request->search);
        }

        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('direction', 'asc'));
        }

        $tours = $query->paginate(10);

        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        $reservationTypes = ReservationType::all();
        return view('admin.tours.create', compact('reservationTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'subtitle_ru' => 'nullable|string|max:255',
            'short_description_en' => 'nullable|string',
            'short_description_ru' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'price' => 'nullable|numeric',
            'currency' => 'nullable|string|max:3',
            'reservation_type_id' => 'nullable|exists:reservation_types,id',
            'faq_en' => 'nullable|array',
            'faq_ru' => 'nullable|array',
            'packages' => 'nullable|array',
            'packages.*.title_en' => 'required_with:packages|string|max:255',
            'packages.*.title_ru' => 'required_with:packages|string|max:255',
            'packages.*.price' => 'required_with:packages|numeric|min:0',
            'packages.*.currency' => 'nullable|string|max:3',
            'packages.*.includes' => 'nullable|array',
            'packages.*.includes.*.ru' => 'nullable|string',
            'packages.*.includes.*.en' => 'nullable|string',
            'packages.*.places' => 'nullable|array',
            'packages.*.places.*.ru' => 'nullable|string',
            'packages.*.places.*.en' => 'nullable|string',
            'options' => 'nullable|array',
            'options.*.title_en' => 'nullable|string|max:255',
            'options.*.title_ru' => 'nullable|string|max:255',
            'options.*.price' => 'nullable|numeric|min:0',
            'preferences' => 'nullable|array',
            'preferences.*.title_en' => 'nullable|string|max:255',
            'preferences.*.title_ru' => 'nullable|string|max:255',
            'preferences.*.extra_cost' => 'nullable|numeric|min:0',
            'seasons' => 'nullable|array',
            'seasons.*.start' => 'nullable|date',
            'seasons.*.end' => 'nullable|date',
            'main_image'      => 'nullable|image|max:10240',
            'main_video'      => 'nullable|mimetypes:video/mp4,video/avi,video/quicktime|max:51200',
            'banner'          => 'nullable|image|max:10240',
            'breadcrumbs_bg'  => 'nullable|image|max:10240',
            'media_gallery.*' => 'nullable|file|max:51200',
            'locations' => 'nullable|array',
            'locations.*.ru' => 'nullable|string',
            'locations.*.en' => 'nullable|string',
            'frequencies' => 'nullable|array',
            'frequencies.*.ru' => 'nullable|string',
            'frequencies.*.en' => 'nullable|string',
        ]);

        $tour = new Tour();
        $tour->setTranslations('title', ['en' => $data['title_en'], 'ru' => $data['title_ru']]);
        $tour->setTranslations('subtitle', ['en' => $data['subtitle_en'] ?? '', 'ru' => $data['subtitle_ru'] ?? '']);
        $tour->setTranslations('short_description', ['en' => $data['short_description_en'] ?? '', 'ru' => $data['short_description_ru'] ?? '']);
        $tour->setTranslations('description', ['en' => $data['description_en'] ?? '', 'ru' => $data['description_ru'] ?? '']);
        $tour->setTranslations('faq', [
            'en' => $data['faq_en'] ?? [],
            'ru' => $data['faq_ru'] ?? [],
        ]);
        $tour->setTranslations('locations', [
            'ru' => collect($data['locations'])->pluck('ru')->toArray(),
            'en' => collect($data['locations'])->pluck('en')->toArray(),
        ]);
        
        $tour->setTranslations('frequencies', [
            'ru' => collect($data['frequencies'])->pluck('ru')->toArray(),
            'en' => collect($data['frequencies'])->pluck('en')->toArray(),
        ]);        
        $tour->price = 0;
        $tour->reservation_type_id = $data['reservation_type_id'] ?? null;
        $tour->slug = Str::slug($data['title_en'] ?? $data['title_ru']);
        $tour->save();

        $totalPrice = 0;

        // Пакеты
        if (!empty($data['packages'])) {
            foreach ($data['packages'] as $packageData) {
                $package = $tour->packages()->create([
                    'title' => [
                        'en' => $packageData['title_en'],
                        'ru' => $packageData['title_ru'],
                    ],
                    'price' => $packageData['price'] ?? 0,
                    'currency' => $packageData['currency'] ?? '€',
                ]);
                $totalPrice += $package->price;

                // Включения
                if (!empty($packageData['includes'])) {
                    foreach ($packageData['includes'] as $include) {
                        $package->includes()->create([
                            'content' => [
                                'en' => $include['en'] ?? '',
                                'ru' => $include['ru'] ?? '',
                            ]
                        ]);
                    }
                }
                // Места
                if (!empty($packageData['places'])) {
                    foreach ($packageData['places'] as $place) {
                        $package->places()->create([
                            'name' => [
                                'en' => $place['en'] ?? '',
                                'ru' => $place['ru'] ?? '',
                            ]
                        ]);
                    }
                }
                // События
                if (!empty($packageData['events'])) {
                    $package->events()->sync($packageData['events']);
                }
            }
        }

        // Опции
        if (!empty($data['options'])) {
            foreach ($data['options'] as $optionData) {
                $tour->options()->create([
                    'title' => [
                        'en' => $optionData['title_en'],
                        'ru' => $optionData['title_ru'],
                    ],
                    'price' => $optionData['price'] ?? 0,
                ]);
                $totalPrice += $optionData['price'] ?? 0;
            }
        }

        // Предпочтения
        if (!empty($data['preferences'])) {
            foreach ($data['preferences'] as $prefData) {
                $tour->preferences()->create([
                    'title' => [
                        'en' => $prefData['title_en'],
                        'ru' => $prefData['title_ru'],
                    ],
                    'extra_cost' => $prefData['extra_cost'] ?? 0,
                ]);
                $totalPrice += $prefData['extra_cost'] ?? 0;
            }
        }

        // Сезоны
        if (!empty($data['seasons'])) {
            foreach ($data['seasons'] as $seasonData) {
                \Log::info('Saving season:', $seasonData); // вот это
                $tour->seasons()->create([
                    'start_date' => $seasonData['start'],
                    'end_date' => $seasonData['end'],
                ]);
            }
        }
        

        // Сохраняем сумму в тур
        $tour->update(['price' => $totalPrice]);


            // ------------------ МЕДИА ЗАГРУЗКА ------------------

        // Основная картинка
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $path = $file->store('tours', 'public');
            $tour->media()->create([
                'path' => $path,
                'type' => 'image',
                'role' => 'main_image',
                'mime' => $file->getClientMimeType(),
                'sort' => 0,
            ]);
        }

        // Основное видео
        if ($request->hasFile('main_video')) {
            $file = $request->file('main_video');
            $path = $file->store('tours', 'public');
            $tour->media()->create([
                'path' => $path,
                'type' => 'video',
                'role' => 'main_video',
                'mime' => $file->getClientMimeType(),
                'sort' => 0,
            ]);
        }

        // Баннер
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $path = $file->store('tours', 'public');
            $tour->media()->create([
                'path' => $path,
                'type' => 'image',
                'role' => 'banner',
                'mime' => $file->getClientMimeType(),
                'sort' => 0,
            ]);
        }

        // Фон для хлебных крошек
        if ($request->hasFile('breadcrumbs_bg')) {
            $file = $request->file('breadcrumbs_bg');
            $path = $file->store('tours', 'public');
            $tour->media()->create([
                'path' => $path,
                'type' => 'image',
                'role' => 'breadcrumbs_bg',
                'mime' => $file->getClientMimeType(),
                'sort' => 0,
            ]);
        }

        // Галерея
        if ($request->hasFile('media_gallery')) {
            foreach ($request->file('media_gallery') as $i => $file) {
                $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';
                $path = $file->store('tours', 'public');
                $tour->media()->create([
                    'path' => $path,
                    'type' => $type,
                    'role' => 'gallery',
                    'mime' => $file->getClientMimeType(),
                    'sort' => $i,
                ]);
            }
        }

                // Локации
        if (!empty($data['locations'])) {
            $tour->setTranslations('locations', [
                'ru' => collect($data['locations'])->pluck('ru')->toArray(),
                'en' => collect($data['locations'])->pluck('en')->toArray(),
            ]);
        }

        // Периодичность
        if (!empty($data['frequencies'])) {
            $tour->setTranslations('frequencies', [
                'ru' => collect($data['frequencies'])->pluck('ru')->toArray(),
                'en' => collect($data['frequencies'])->pluck('en')->toArray(),
            ]);
        }


        return redirect()->route('tours.index')->with('success', 'Тур добавлен с общей ценой: ' . $totalPrice . ' ' . ($data['packages'][0]['currency'] ?? '€'));
    }

    public function edit(Tour $tour)
    {
        $reservationTypes = ReservationType::all();
        // Загрузить все нужные отношения!
        $tour->load([
            'packages',
            'packages.includes',
            'packages.places',
            'packages.events',
            'options',
            'seasons',
            'gallery', // если есть отдельная связь для галереи
        ]);
        return view('admin.tours.edit', compact('tour', 'reservationTypes'));
    }    

    public function update(Request $request, Tour $tour)
{
    $data = $request->validate([
        'title_en' => 'required|string|max:255',
        'title_ru' => 'required|string|max:255',
        'subtitle_en' => 'nullable|string|max:255',
        'subtitle_ru' => 'nullable|string|max:255',
        'short_description_en' => 'nullable|string',
        'short_description_ru' => 'nullable|string',
        'description_en' => 'nullable|string',
        'description_ru' => 'nullable|string',
        'faq_en' => 'nullable|array',
        'faq_ru' => 'nullable|array',
        'price' => 'nullable|numeric',
        'currency' => 'nullable|string|max:3',
        'reservation_type_id' => 'nullable|exists:reservation_types,id',
        'packages' => 'nullable|array',
        'packages.*.title_en' => 'required_with:packages|string|max:255',
        'packages.*.title_ru' => 'required_with:packages|string|max:255',
        'packages.*.price' => 'required_with:packages|numeric|min:0',
        'packages.*.currency' => 'nullable|string|max:3',
        'packages.*.includes' => 'nullable|array',
        'packages.*.includes.*.ru' => 'nullable|string',
        'packages.*.includes.*.en' => 'nullable|string',
        'packages.*.places' => 'nullable|array',
        'packages.*.places.*.ru' => 'nullable|string',
        'packages.*.places.*.en' => 'nullable|string',
        'options' => 'nullable|array',
        'options.*.title_en' => 'nullable|string|max:255',
        'options.*.title_ru' => 'nullable|string|max:255',
        'options.*.price' => 'nullable|numeric|min:0',
        'preferences' => 'nullable|array',
        'preferences.*.title_en' => 'nullable|string|max:255',
        'preferences.*.title_ru' => 'nullable|string|max:255',
        'preferences.*.extra_cost' => 'nullable|numeric|min:0',
        'seasons' => 'nullable|array',
        'seasons.*.start' => 'nullable|date',
        'seasons.*.end' => 'nullable|date',
        'main_image'      => 'nullable|image|max:10240',
        'main_video'      => 'nullable|mimetypes:video/mp4,video/avi,video/quicktime|max:51200',
        'banner'          => 'nullable|image|max:10240',
        'breadcrumbs_bg'  => 'nullable|image|max:10240',
        'media_gallery.*' => 'nullable|file|max:51200',
        'locations' => 'nullable|array',
        'locations.*.ru' => 'nullable|string',
        'locations.*.en' => 'nullable|string',
        'frequencies' => 'nullable|array',
        'frequencies.*.ru' => 'nullable|string',
        'frequencies.*.en' => 'nullable|string',
    ]);

    $tour->setTranslations('title', ['en' => $data['title_en'], 'ru' => $data['title_ru']]);
    $tour->setTranslations('subtitle', ['en' => $data['subtitle_en'] ?? '', 'ru' => $data['subtitle_ru'] ?? '']);
    $tour->setTranslations('short_description', ['en' => $data['short_description_en'] ?? '', 'ru' => $data['short_description_ru'] ?? '']);
    $tour->setTranslations('description', ['en' => $data['description_en'] ?? '', 'ru' => $data['description_ru'] ?? '']);
    $tour->setTranslations('faq', [
        'en' => $data['faq_en'] ?? [],
        'ru' => $data['faq_ru'] ?? [],
    ]);
    $tour->price = 0;
    $tour->reservation_type_id = $data['reservation_type_id'] ?? null;
    $tour->slug = Str::slug($data['title_en'] ?? $data['title_ru']);
    $tour->save();

    // Удаляем старые связи
    $tour->packages()->delete();
    $tour->options()->delete();
    $tour->preferences()->delete();
    $tour->seasons()->delete();

    $totalPrice = 0;

    // Пакеты
    if (!empty($data['packages'])) {
        foreach ($data['packages'] as $packageData) {
            $package = $tour->packages()->create([
                'title' => [
                    'en' => $packageData['title_en'],
                    'ru' => $packageData['title_ru'],
                ],
                'price' => $packageData['price'] ?? 0,
                'currency' => $packageData['currency'] ?? '€',
            ]);
            $totalPrice += $package->price;

            // Включения
            if (!empty($packageData['includes'])) {
                foreach ($packageData['includes'] as $include) {
                    $package->includes()->create([
                        'content' => [
                            'en' => $include['en'] ?? '',
                            'ru' => $include['ru'] ?? '',
                        ]
                    ]);
                }
            }
            // Места
            if (!empty($packageData['places'])) {
                foreach ($packageData['places'] as $place) {
                    $package->places()->create([
                        'name' => [
                            'en' => $place['en'] ?? '',
                            'ru' => $place['ru'] ?? '',
                        ]
                    ]);
                }
            }
            // События
            if (!empty($packageData['events'])) {
                $package->events()->sync($packageData['events']);
            }
        }
    }

    if (!empty($data['locations'])) {
        $tour->setTranslations('locations', [
            'ru' => collect($data['locations'])->pluck('ru')->toArray(),
            'en' => collect($data['locations'])->pluck('en')->toArray(),
        ]);
    }
    
    if (!empty($data['frequencies'])) {
        $tour->setTranslations('frequencies', [
            'ru' => collect($data['frequencies'])->pluck('ru')->toArray(),
            'en' => collect($data['frequencies'])->pluck('en')->toArray(),
        ]);
    }    
    

    // Опции
    if (!empty($data['options'])) {
        foreach ($data['options'] as $optionData) {
            $tour->options()->create([
                'title' => [
                    'en' => $optionData['title_en'] ?? '',
                    'ru' => $optionData['title_ru'] ?? '',
                ],
                'price' => $optionData['price'] ?? 0,
            ]);
            $totalPrice += $optionData['price'] ?? 0;
        }
    }

    // Предпочтения
    if (!empty($data['preferences'])) {
        foreach ($data['preferences'] as $prefData) {
            $tour->preferences()->create([
                'title' => [
                    'en' => $prefData['title_en'] ?? '',
                    'ru' => $prefData['title_ru'] ?? '',
                ],
                'extra_cost' => $prefData['extra_cost'] ?? 0,
            ]);
            $totalPrice += $prefData['extra_cost'] ?? 0;
        }
    }

    // Сезоны
    if (!empty($data['seasons'])) {
        foreach ($data['seasons'] as $seasonData) {
            if (!empty($seasonData['start']) && !empty($seasonData['end'])) {
                $tour->seasons()->create([
                    'start_date' => $seasonData['start'],
                    'end_date' => $seasonData['end'],
                ]);
            }
        }
    }
    
    
    // Сохраняем сумму в тур
    $tour->update(['price' => $totalPrice]);

    // ------------------ ОЧИСТКА СТАРЫХ МЕДИА ------------------
    foreach (['main_image', 'main_video', 'banner', 'breadcrumbs_bg'] as $role) {
        $old = $tour->media()->where('role', $role)->first();
        if ($old) {
            Storage::disk('public')->delete($old->path);
            $old->delete();
        }
    }
    // Галерея: очищаем только если пришли новые файлы
    if ($request->hasFile('media_gallery')) {
        $oldGallery = $tour->media()->where('role', 'gallery')->get();
        foreach ($oldGallery as $media) {
            Storage::disk('public')->delete($media->path);
            $media->delete();
        }
    }

    // ------------------ МЕДИА ЗАГРУЗКА ------------------

    if ($request->hasFile('main_image')) {
        $file = $request->file('main_image');
        $path = $file->store('tours', 'public');
        $tour->media()->create([
            'path' => $path,
            'type' => 'image',
            'role' => 'main_image',
            'mime' => $file->getClientMimeType(),
            'sort' => 0,
        ]);
    }

    if ($request->hasFile('main_video')) {
        $file = $request->file('main_video');
        $path = $file->store('tours', 'public');
        $tour->media()->create([
            'path' => $path,
            'type' => 'video',
            'role' => 'main_video',
            'mime' => $file->getClientMimeType(),
            'sort' => 0,
        ]);
    }

    if ($request->hasFile('banner')) {
        $file = $request->file('banner');
        $path = $file->store('tours', 'public');
        $tour->media()->create([
            'path' => $path,
            'type' => 'image',
            'role' => 'banner',
            'mime' => $file->getClientMimeType(),
            'sort' => 0,
        ]);
    }

    if ($request->hasFile('breadcrumbs_bg')) {
        $file = $request->file('breadcrumbs_bg');
        $path = $file->store('tours', 'public');
        $tour->media()->create([
            'path' => $path,
            'type' => 'image',
            'role' => 'breadcrumbs_bg',
            'mime' => $file->getClientMimeType(),
            'sort' => 0,
        ]);
    }

    if ($request->hasFile('media_gallery')) {
        foreach ($request->file('media_gallery') as $i => $file) {
            $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';
            $path = $file->store('tours', 'public');
            $tour->media()->create([
                'path' => $path,
                'type' => $type,
                'role' => 'gallery',
                'mime' => $file->getClientMimeType(),
                'sort' => $i,
            ]);
        }
    }

    return redirect()->route('tours.index')->with('success', 'Тур обновлён');
}


    public function toggleStatus(Tour $tour)
    {
        $tour->is_active = !$tour->is_active;
        $tour->save();

        return back()->with('success', 'Статус изменён');
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return redirect()->route('tours.index')->with('success', 'Тур удалён');
    }

    public function massDestroy(Request $request)
{
    $ids = $request->input('ids', []);

    if (!empty($ids)) {
        Tour::whereIn('id', $ids)->each(function ($tour) {
            $tour->delete(); // или добавить очистку media и связей если нужно
        });
    }

    return redirect()->route('tours.index')->with('success', 'Выбранные туры удалены.');
}

}
