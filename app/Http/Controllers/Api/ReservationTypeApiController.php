<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReservationType;
use Illuminate\Http\Request;

class ReservationTypeApiController extends Controller
{
    public function items($typeId)
    {
        $type = ReservationType::findOrFail($typeId);

        // Туры или услуги связанные с этим типом
        $tours = $type->tours()->get(['id', 'title']);
        $services = $type->services()->get(['id', 'title']);

        // Если у типа есть только туры — выводим их
        $items = $tours->count() ? $tours : $services;

        // Пакеты, опции и предпочтения для первого попавшегося тура/услуги (если выбрали)
        $packages = $items->first()?->packages()->get(['id', 'title', 'price', 'currency']) ?? [];
        $options = $items->first()?->options()->get(['id', 'title', 'price', 'currency']) ?? [];
        $preferences = $items->first()?->preferences()->get(['id', 'title', 'extra_cost', 'currency']) ?? [];

        return response()->json([
            'items' => $items,
            'packages' => $packages,
            'options' => $options,
            'preferences' => $preferences,
        ]);
    }
}
