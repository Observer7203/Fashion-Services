<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\Tour;
use App\Models\Product;
use Illuminate\Support\Str;


class GenerateProductsForExistingServicesAndTours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-products-for-existing-services-and-tours';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🔄 Генерация продуктов для услуг...");

        Service::doesntHave('product')->get()->each(function ($service) {
            Product::create([
                'title'       => $service->title,
                'slug'        => $service->slug ?: Str::slug($service->title) . '-' . $service->id,
                'description' => $service->description,
                'price'       => $service->price,
                'media'       => $service->media,
                'category'    => 'service',
                'type'        => 'service',
                'stock'       => 999,
                'status'      => $service->status ?? 'active',
                'options'     => null,
                'service_id'  => $service->id,
            ]);
            $this->info("✅ Продукт для услуги {$service->id} создан");
        });
    
        $this->info("🔄 Генерация продуктов для туров...");
    
        Tour::doesntHave('product')->get()->each(function ($tour) {
            Product::create([
                'title'       => $tour->title,
                'slug'        => $tour->slug ?: Str::slug($tour->title) . '-' . $tour->id,
                'description' => $tour->description,
                'price'       => $tour->price,
                'media'       => $tour->media,
                'category'    => 'tour',
                'type'        => 'tour',
                'stock'       => 999,
                'status'      => $tour->status ?? 'active',
                'options'     => null,
                'tour_id'     => $tour->id,
            ]);
            $this->info("✅ Продукт для тура {$tour->id} создан");
        });
    
        $this->info("🎉 Завершено.");
    }
}
