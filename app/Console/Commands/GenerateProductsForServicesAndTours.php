<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\Tour;
use App\Models\Product;
use Illuminate\Support\Str;

class GenerateProductsForServicesAndTours extends Command
{
    protected $signature = 'products:generate';
    protected $description = 'Создаёт продукты для уже существующих туров и услуг, если их нет';

    public function handle()
    {
        $this->info("🔁 Поиск услуг без продуктов...");
        Service::all()->each(function ($service) {
            if (!Product::where('service_id', $service->id)->exists()) {
                Product::create([
                    'title'       => $service->title,
                    'slug'        => $service->slug ?: Str::slug($service->title) . '-' . $service->id,
                    'description' => $service->description,
                    'short_description' => $service->short_description ?? null,
                    'price'       => $service->price,
                    'media'       => $service->media,
                    'category'    => 'service',
                    'type'        => 'service',
                    'stock'       => 999,
                    'status'      => $service->status ?? 'active',
                    'options'     => null,
                    'service_id'  => $service->id,
                ]);
                $this->info("✅ Создан продукт для услуги ID={$service->id}");
            }
        });

        $this->info("🔁 Поиск туров без продуктов...");
        Tour::all()->each(function ($tour) {
            if (!Product::where('tour_id', $tour->id)->exists()) {
                Product::create([
                    'title'       => $tour->title,
                    'slug'        => $tour->slug ?: Str::slug($tour->title) . '-' . $tour->id,
                    'description' => $tour->description,
                    'short_description' => $tour->short_description ?? null,
                    'price'       => $tour->price,
                    'media'       => $tour->media,
                    'category'    => 'tour',
                    'type'        => 'tour',
                    'stock'       => 999,
                    'status'      => $tour->status ?? 'active',
                    'options'     => null,
                    'tour_id'     => $tour->id,
                ]);
                $this->info("✅ Создан продукт для тура ID={$tour->id}");
            }
        });

        $this->info("🎉 Завершено.");
    }
}
