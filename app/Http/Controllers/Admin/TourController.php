<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ReservationType;

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
            'price' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'reservation_type_id' => 'nullable|exists:reservation_types,id',
            'faq_en' => 'nullable|array',
            'faq_ru' => 'nullable|array',
            'packages' => 'nullable|array',
            'packages.*.title_en' => 'required_with:packages|string|max:255',
            'packages.*.title_ru' => 'required_with:packages|string|max:255',
            'packages.*.price' => 'required_with:packages|numeric|min:0',
            'packages.*.currency' => 'nullable|string|max:3',
            'packages.*.includes' => 'nullable|array',
            'packages.*.includes.*.content_en' => 'required_with:packages|string',
            'packages.*.includes.*.content_ru' => 'required_with:packages|string',
            'packages.*.places' => 'nullable|array',
            'packages.*.places.*.name_en' => 'required_with:packages|string',
            'packages.*.places.*.name_ru' => 'required_with:packages|string',
            'options' => 'nullable|array',
            'options.*.title_en' => 'required_with:options|string|max:255',
            'options.*.title_ru' => 'required_with:options|string|max:255',
            'options.*.price' => 'required_with:options|numeric|min:0',
            'preferences' => 'nullable|array',
            'preferences.*.title_en' => 'required_with:preferences|string|max:255',
            'preferences.*.title_ru' => 'required_with:preferences|string|max:255',
            'preferences.*.extra_cost' => 'required_with:preferences|numeric|min:0',
            'seasons' => 'nullable|array',
            'seasons.*.start' => 'required_with:seasons|date',
            'seasons.*.end' => 'required_with:seasons|date|after_or_equal:seasons.*.start',
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
        $tour->price = $data['price'];
        $tour->currency = $data['currency'];
        $tour->reservation_type_id = $data['reservation_type_id'] ?? null;
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
                                'en' => $include['content_en'],
                                'ru' => $include['content_ru'],
                            ]
                        ]);
                    }
                }
                // Места
                if (!empty($packageData['places'])) {
                    foreach ($packageData['places'] as $place) {
                        $package->places()->create([
                            'name' => [
                                'en' => $place['name_en'],
                                'ru' => $place['name_ru'],
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
                $tour->seasons()->create([
                    'start_date' => $seasonData['start'],
                    'end_date' => $seasonData['end'],
                ]);
            }
        }

        // Сохраняем сумму в тур
        $tour->update(['price' => $totalPrice]);

        return redirect()->route('tours.index')->with('success', 'Тур добавлен с общей ценой: ' . $totalPrice . ' ' . ($data['packages'][0]['currency'] ?? '€'));
    }

    public function edit(Tour $tour)
    {
        $reservationTypes = ReservationType::all();
        $tour->load(['packages', 'packages.includes', 'packages.places', 'packages.events', 'options', 'seasons']);
        if ($tour->packages === null) $tour->setRelation('packages', collect());
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
            'price' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'reservation_type_id' => 'nullable|exists:reservation_types,id',
            'packages' => 'nullable|array',
            'packages.*.title_en' => 'required_with:packages|string|max:255',
            'packages.*.title_ru' => 'required_with:packages|string|max:255',
            'packages.*.price' => 'required_with:packages|numeric|min:0',
            'packages.*.currency' => 'nullable|string|max:3',
            'packages.*.includes' => 'nullable|array',
            'packages.*.includes.*.content_en' => 'required_with:packages|string',
            'packages.*.includes.*.content_ru' => 'required_with:packages|string',
            'packages.*.places' => 'nullable|array',
            'packages.*.places.*.name_en' => 'required_with:packages|string',
            'packages.*.places.*.name_ru' => 'required_with:packages|string',
            'options' => 'nullable|array',
            'options.*.title_en' => 'required_with:options|string|max:255',
            'options.*.title_ru' => 'required_with:options|string|max:255',
            'options.*.price' => 'required_with:options|numeric|min:0',
            'preferences' => 'nullable|array',
            'preferences.*.title_en' => 'required_with:preferences|string|max:255',
            'preferences.*.title_ru' => 'required_with:preferences|string|max:255',
            'preferences.*.extra_cost' => 'required_with:preferences|numeric|min:0',
            'seasons' => 'nullable|array',
            'seasons.*.start' => 'required_with:seasons|date',
            'seasons.*.end' => 'required_with:seasons|date|after_or_equal:seasons.*.start',
        ]);

        $tour->setTranslations('title', ['en' => $data['title_en'], 'ru' => $data['title_ru']]);
        $tour->setTranslations('subtitle', ['en' => $data['subtitle_en'] ?? '', 'ru' => $data['subtitle_ru'] ?? '']);
        $tour->setTranslations('short_description', ['en' => $data['short_description_en'] ?? '', 'ru' => $data['short_description_ru'] ?? '']);
        $tour->setTranslations('description', ['en' => $data['description_en'] ?? '', 'ru' => $data['description_ru'] ?? '']);
        $tour->setTranslations('faq', [
            'en' => $data['faq_en'] ?? [],
            'ru' => $data['faq_ru'] ?? [],
        ]);
        $tour->price = $data['price'];
        $tour->currency = $data['currency'];
        $tour->reservation_type_id = $data['reservation_type_id'] ?? null;
        $tour->save();

        // Удаляем старое
        $tour->packages()->delete();
        $tour->options()->delete();
        $tour->preferences()->delete();
        $tour->seasons()->delete();

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

                // Включения
                if (!empty($packageData['includes'])) {
                    foreach ($packageData['includes'] as $include) {
                        $package->includes()->create([
                            'content' => [
                                'en' => $include['content_en'],
                                'ru' => $include['content_ru'],
                            ]
                        ]);
                    }
                }
                // Места
                if (!empty($packageData['places'])) {
                    foreach ($packageData['places'] as $place) {
                        $package->places()->create([
                            'name' => [
                                'en' => $place['name_en'],
                                'ru' => $place['name_ru'],
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
            }
        }

        // Сезоны
        if (!empty($data['seasons'])) {
            foreach ($data['seasons'] as $seasonData) {
                $tour->seasons()->create([
                    'start_date' => $seasonData['start'],
                    'end_date' => $seasonData['end'],
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
}
