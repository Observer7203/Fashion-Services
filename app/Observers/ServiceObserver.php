<?php

namespace App\Observers;

use App\Models\Service;
use App\Models\Product;
use Illuminate\Support\Str;

class ServiceObserver
{

    private function generateUniqueProductSlug($base): string
    {
        $baseSlug = Str::slug($base) . '-product';
        $slug = $baseSlug;
        $counter = 1;
    
        while (\App\Models\Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
    
        return $slug;
    }
    

    /**
     * После создания услуги — создать продукт.
     */
    public function created(Service $service)
    {
        \Log::info('Создана услуга, генерируем продукт', ['service_id' => $service->id]);

        $slug = $this->generateUniqueProductSlug($service->getTranslation('title', 'en'));

        Product::create([
            'title' => [
                'ru' => $service->getTranslation('title', 'ru'),
                'en' => $service->getTranslation('title', 'en'),
            ],
            'short_description' => [
                'ru' => $service->getTranslation('short_description', 'ru'),
                'en' => $service->getTranslation('short_description', 'en'),
            ],
            'description' => [
                'ru' => $service->getTranslation('description', 'ru'),
                'en' => $service->getTranslation('description', 'en'),
            ],
            'slug'        => $service->slug ?: Str::slug($service->title) . '-' . $service->id,
            'price'       => $service->price,
            'media'       => $service->media, // если media как JSON
            'stock'       => 999, // услуги не ограничены
            'status'      => $service->status ?? 'active',
            'options'     => null,
            'service_id'  => $service->id, // если хочешь сохранить связь (см. миграцию ниже)
            'type' => 'service',
        ]);
    }

    /**
     * При обновлении услуги — обновить связанный продукт.
     */
    public function updated(Service $service)
    {
        $product = Product::where('service_id', $service->id)->first();
        if ($product) {
            $product->update([
                'title'       => $service->title,
                'slug'        => $service->slug ?: Str::slug($service->title) . '-' . $service->id,
                'description' => $service->description,
                'short_description' => $service->short_description, //
                'price'       => $service->price,
                'media'       => $service->media,
                'status'      => $service->status ?? 'active',
            ]);
        }
    }

    /**
     * При удалении услуги — удалить продукт, если нужно.
     */
    public function deleted(Service $service)
    {
        Product::where('service_id', $service->id)->delete();
    }
}
