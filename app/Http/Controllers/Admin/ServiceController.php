<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ReservationType;

class ServiceController extends Controller
{
    // Список всех услуг
    public function index()
    {
        $services = Service::latest()->paginate(10); // или любое другое число на страницу
        return view('admin.services.index', compact('services'));
    }

    // Форма создания
    public function create()
    {
        $reservationTypes = ReservationType::all();
        return view('admin.services.create');
    }

    // Сохранение новой услуги
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
        'media' => 'nullable|array',
        'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mkv,webm|max:51200', // макс 50МБ, можно изменить
        'options' => 'nullable|array',
        'options.*.title_en' => 'required_with:options|string|max:255',
        'options.*.title_ru' => 'required_with:options|string|max:255',
        'options.*.price' => 'required_with:options|numeric|min:0',
        'includes' => 'nullable|array',
        'includes.*.title_en' => 'required|string|max:255',
        'includes.*.title_ru' => 'required|string|max:255',
        'media.main' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.detail1' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.detail2' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.detail3' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.detail4' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.banner' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.video' => 'nullable|file|mimes:mp4,webm,mkv|max:51200',
    ]);

    $service = new Service();
    $service->setTranslations('title', ['en' => $data['title_en'], 'ru' => $data['title_ru']]);
    $service->setTranslations('subtitle', ['en' => $data['subtitle_en'] ?? '', 'ru' => $data['subtitle_ru'] ?? '']);
    $service->setTranslations('short_description', ['en' => $data['short_description_en'] ?? '', 'ru' => $data['short_description_ru'] ?? '']);
    $service->setTranslations('description', ['en' => $data['description_en'] ?? '', 'ru' => $data['description_ru'] ?? '']);
    $service->price = $data['price'];
    $service->currency = $data['currency'];
    $service->reservation_type_id = $data['reservation_type_id'] ?? null;
// Получаем slug или генерируем его из названия
$slug = $data['slug'] ?? Str::slug($data['title_en'] ?? $data['title_ru']);
if (empty($slug)) {
    // Если slug после всех манипуляций пустой — ставим id
    $slug = $service->id;
}
$service->slug = $slug;
$service->save();

    
    // Медиа — сохраняем файлы и добавляем в service_media
    if ($request->hasFile('media')) {
        foreach ($request->file('media') as $type => $file) {
            if ($file) {
                $mediaType = $type === 'video' ? 'video' : 'image';
                $filePath = $file->store('services', 'public');

                $service->mediaFiles()->create([
                    'type' => $type,
                    'media_type' => $mediaType,
                    'path' => $filePath,
                ]);
            }
        }
    }

    // options
    if (!empty($data['options'])) {
        foreach ($data['options'] as $option) {
            $service->options()->create([
                'title' => [
                    'en' => $option['title_en'],
                    'ru' => $option['title_ru'],
                ],
                'price' => $option['price'],
            ]);
        }
    }
    // includes
    if (!empty($data['includes'])) {
        foreach ($data['includes'] as $item) {
            $service->includes()->create([
                'title' => [
                    'en' => $item['title_en'],
                    'ru' => $item['title_ru'],
                ]
            ]);
        }
    }
    return redirect()->route('services.index')->with('success', 'Услуга добавлена');
}


    // Форма редактирования
    public function edit(Service $service)
    {
        $reservationTypes = ReservationType::all();
        return view('admin.services.edit', compact('service'));
    }

    // Обновление услуги
    public function update(Request $request, Service $service)
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
        'media' => 'nullable|array',
        'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mkv,webm|max:51200',
        'options' => 'nullable|array',
        'options.*.title_en' => 'required_with:options|string|max:255',
        'options.*.title_ru' => 'required_with:options|string|max:255',
        'options.*.price' => 'required_with:options|numeric|min:0',
        'includes' => 'nullable|array',
        'includes.*.title_en' => 'required|string|max:255',
        'includes.*.title_ru' => 'required|string|max:255',
        'media.main' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.detail1' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.detail2' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.detail3' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.detail4' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.banner' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:51200',
        'media.video' => 'nullable|file|mimes:mp4,webm,mkv|max:51200',
    ]);

    $service->setTranslations('title', ['en' => $data['title_en'], 'ru' => $data['title_ru']]);
    $service->setTranslations('subtitle', ['en' => $data['subtitle_en'] ?? '', 'ru' => $data['subtitle_ru'] ?? '']);
    $service->setTranslations('short_description', ['en' => $data['short_description_en'] ?? '', 'ru' => $data['short_description_ru'] ?? '']);
    $service->setTranslations('description', ['en' => $data['description_en'] ?? '', 'ru' => $data['description_ru'] ?? '']);
    $service->price = $data['price'];
    $service->currency = $data['currency'];
    $service->reservation_type_id = $data['reservation_type_id'] ?? null;
    // Получаем slug или генерируем его из названия
    $slug = $data['slug'] ?? Str::slug($data['title_en'] ?? $data['title_ru']);
    if (empty($slug)) {
        // Если slug после всех манипуляций пустой — ставим id
        $slug = $service->id;
    }
    $service->slug = $slug;
    $service->save();

    $service->options()->delete();
    if (!empty($data['options'])) {
        foreach ($data['options'] as $option) {
            $service->options()->create([
                'title' => [
                    'en' => $option['title_en'],
                    'ru' => $option['title_ru'],
                ],
                'price' => $option['price'],
            ]);
        }
    }
    $service->includes()->delete();
    if (!empty($data['includes'])) {
        foreach ($data['includes'] as $item) {
            $service->includes()->create([
                'title' => [
                    'en' => $item['title_en'],
                    'ru' => $item['title_ru'],
                ]
            ]);
        }
    }
     // Медиа
     if ($request->hasFile('media')) {
        foreach ($request->file('media') as $type => $file) {
            if ($file) {
                // Найти старый медиафайл этого типа
                $oldMedia = $service->mediaFiles()->where('type', $type)->first();
                if ($oldMedia) {
                    // Удалить файл из storage, если хочешь:
                    // Storage::disk('public')->delete($oldMedia->path);
                    $oldMedia->delete();
                }
                $mediaType = $type === 'video' ? 'video' : 'image';
                $filePath = $file->store('services', 'public');
                $service->mediaFiles()->create([
                    'type' => $type,
                    'media_type' => $mediaType,
                    'path' => $filePath,
                ]);
            }
        }
    }
    return redirect()->route('services.index')->with('success', 'Услуга обновлена');
}


    // Удаление
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Услуга удалена');
    }
}
