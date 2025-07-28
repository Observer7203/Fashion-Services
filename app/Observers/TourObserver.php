<?php

namespace App\Observers;

use App\Models\Tour;
use App\Models\Product;
use Illuminate\Support\Str;

class TourObserver
{
    /**
     * После создания тура — создать продукт.
     */

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
     

    public function created(Tour $tour)
    {
        \Log::info('Создан тур, генерируем продукт', ['tour_id' => $tour->id]);

        $slug = $this->generateUniqueProductSlug($tour->getTranslation('title', 'en'));

        Product::create([
            'title' => [
                'ru' => $tour->getTranslation('title', 'ru'),
                'en' => $tour->getTranslation('title', 'en'),
            ],
            'short_description' => [
                'ru' => $tour->getTranslation('short_description', 'ru'),
                'en' => $tour->getTranslation('short_description', 'en'),
            ],
            'description' => [
                'ru' => $tour->getTranslation('description', 'ru'),
                'en' => $tour->getTranslation('description', 'en'),
            ],
            'slug'        => $tour->slug ?: Str::slug($tour->title) . '-' . $tour->id,
            'price'       => $tour->price,
            'media'       => $tour->media, // если media хранится как JSON
            'type'    => 'tour',
            'stock'       => 999, // например, туры не ограничены
            'status'      => $tour->status ?? 'active',
            'options'     => null,
            'tour_id'     => $tour->id, // если хочешь сохранить связь (нужно добавить поле tour_id в products!)
        ]);
    }

    /**
     * При обновлении тура — обновить связанный продукт.
     */
    public function updated(Tour $tour)
    {
        $product = Product::where('tour_id', $tour->id)->first();
        if ($product) {
            $product->update([
                'title'       => $tour->title,
                'slug'        => $tour->slug ?: Str::slug($tour->title) . '-' . $tour->id,
                'description' => $tour->description,
                'short_description' => $tour->short_description,
                'price'       => $tour->price,
                'media'       => $tour->media,
                'status'      => $tour->status ?? 'active',
            ]);
        }
    }

    /**
     * При удалении тура — можно удалить продукт, если требуется.
     */
    public function deleted(Tour $tour)
    {
        Product::where('tour_id', $tour->id)->delete();
    }
}
