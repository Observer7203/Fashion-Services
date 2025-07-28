<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index() {
        $services = Service::with('mediaFiles')->get();
        return view('services', compact('services'));
    }

    public function show($locale, $slugOrId)
    {
        // Search by slug, if not found — fallback to id
        $service = Service::with(['mediaFiles', 'options', 'includes'])
            ->where('slug', $slugOrId)
            ->orWhere('id', $slugOrId)
            ->firstOrFail();

        // Main image
        $mainImage = $service->mediaFiles->where('type', 'main')->first();

        // 4 images with type = detail1..detail4 (or sequentially if insufficient)
        $detailImages = collect([
            $service->mediaFiles->where('type', 'detail1')->first(),
            $service->mediaFiles->where('type', 'detail2')->first(),
            $service->mediaFiles->where('type', 'detail3')->first(),
            $service->mediaFiles->where('type', 'detail4')->first(),
        ])->filter();

        // Split description into paragraphs (max 4 for display between images)
        $desc = $service->getTranslation('description', app()->getLocale()) ?? '';
        $paragraphs = preg_split("/\r?\n\r?\n+/", $desc);
        $paragraphs = array_slice($paragraphs, 0, 4);

        // Includes
        $includes = $service->includes;

        // Additional options
        $options = $service->options;

        return view('services_2.show', compact('service', 'mainImage', 'detailImages', 'paragraphs', 'includes', 'options'));
    }
}
