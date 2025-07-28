<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\UserCart;

class BucketController extends Controller
{
    // Показать корзину
    public function index()
    {
        if (Auth::check()) {
            // Для авторизованных — приводим к массиву
            $items = UserCart::where('user_id', Auth::id())
                ->with(['product', 'service', 'tour', 'package'])
                ->get();
    
            $bucket = [];
            foreach ($items as $item) {
                $options_info = [];
                $type = 'unknown';
                $title = 'Без названия';
                $price = 0;
                $currency = '₸';


                if ($item->product_id) {
                    $type = $item->product->type ?? 'product';
                    $title = $item->product->title ?? 'Товар';
                    $price = $item->product->price ?? 0;
                    $currency = $item->product->currency ?? $currency;
                } elseif ($item->service_id) {
                    $type = 'service';
                    $title = $item->service->title ?? 'Услуга';
                    // ВСЕГДА получаем актуальную цену услуги и опций из БД!
                    $service = \App\Models\Service::find($item->service_id);
                    $price = $service ? $service->price : 0;
                    $currency = $service ? ($service->currency ?? $currency) : $currency;
                    $optionIds = is_array($item->options) ? $item->options : json_decode($item->options, true);
                    if (!empty($optionIds)) {
                        $addons = \App\Models\ServiceAddon::whereIn('id', $optionIds)->get();
                        foreach ($addons as $addon) {
                            $options_info[] = [
                                'title' => $addon->getTranslation('title', app()->getLocale()),
                                'price' => $addon->price,
                            ];
                            $price += $addon->price;
                        }
                    }
                } elseif ($item->tour_id) {
                    $type = 'tour';
                    $title = $item->tour->title ?? 'Тур';
                    $price = $item->package ? $item->package->price : 0;
                    $currency = $item->package ? ($item->package->currency ?? $currency) : $currency;
                } else {
                    $type = 'unknown';
                    $title = 'Без названия';
                    $price = 0;
                }
    
                // Опции и пакет для тура/услуги
                $options_info = [];
                if ($type === 'tour' && $item->options) {
                    $optionIds = is_array($item->options) ? $item->options : json_decode($item->options, true);
                    $tourOptions = \App\Models\TourOption::whereIn('id', $optionIds)->get();
                    foreach ($tourOptions as $opt) {
                        $options_info[] = [
                            'title' => $opt->getTranslation('title', app()->getLocale()),
                            'price' => $opt->price,
                        ];
                        $price += $opt->price;
                    }
                } elseif ($type === 'service' && $item->service_id) {
                    $type = 'service';
                    $title = $item->service->title ?? 'Услуга';
                    // ВСЕГДА получаем актуальную цену услуги и опций из БД!
                    $service = \App\Models\Service::find($item->service_id);
                    $price = $service ? $service->price : 0;
                    $currency = $service ? ($service->currency ?? $currency) : $currency;
                    $options_info = [];
                    $optionIds = is_array($item->options) ? $item->options : json_decode($item->options, true);
                    if (!empty($optionIds)) {
                        $addons = \App\Models\ServiceAddon::whereIn('id', $optionIds)->get();
                        foreach ($addons as $addon) {
                            $options_info[] = [
                                'title' => $addon->getTranslation('title', app()->getLocale()),
                                'price' => $addon->price,
                            ];
                        }
                    }
                }
    
                $bucket[] = [
                    'id' => $item->id,
                    'type' => $type,
                    'title' => $title,
                    'qty' => $item->quantity ?? 1,
                    'price' => $price,
                    'currency' => $currency,
                    'package_title' => $item->package ? $item->package->getTranslation('title', app()->getLocale()) : null,
                    'package_price' => $item->package ? $item->package->price : null,
                    'options_info' => $options_info,
                ];
            }
        } else {
            // Для гостей — просто достаем массив из сессии,
            // если он есть, иначе создаем пустой массив (иначе Blade сломается)
            $bucket = Session::get('bucket', []);

            $bucket = array_map(function ($item) {
                $options_info = $item['options_info'] ?? [];
                $qty = $item['qty'] ?? 1;
                $price = $item['price'] ?? 0;
                $package_title = null;
                $package_price = null;
                $currency = $item['currency'] ?? '₸';
            
                // Услуга
                if ($item['type'] === 'service' && !empty($item['service_id'])) {
                    $service = \App\Models\Service::find($item['service_id']);
                    if ($service) {
                        $price = $service->price;
                        $currency = $service->currency ?? $currency;
                        if (!empty($item['options'])) {
                            $optionIds = is_array($item['options']) ? $item['options'] : json_decode($item['options'], true);
                            $addons = \App\Models\ServiceAddon::whereIn('id', $optionIds)->get();
                            $options_info = [];
                            foreach ($addons as $addon) {
                                $options_info[] = [
                                    'title' => $addon->getTranslation('title', app()->getLocale()),
                                    'price' => $addon->price,
                                ];
                                
                            }
                        }
                    }
                }
                // Тур
                elseif ($item['type'] === 'tour' && !empty($item['package_id'])) {
                    $package = \App\Models\TourPackage::find($item['package_id']);
                    if ($package) {
                        $package_title = $package->getTranslation('title', app()->getLocale());
                        $package_price = $package->price;
                        $price = $package_price;
                        if (!empty($item['options'])) {
                            $optionIds = is_array($item['options']) ? $item['options'] : json_decode($item['options'], true);
                            $tourOptions = \App\Models\TourOption::whereIn('id', $optionIds)->get();
                            $options_info = [];
                            foreach ($tourOptions as $opt) {
                                $options_info[] = [
                                    'title' => $opt->getTranslation('title', app()->getLocale()),
                                    'price' => $opt->price,
                                ];
                                $price += $opt->price;
                            }
                        }
                    }
                }
                // Товар/одежда/украшение
                else {
                    $price = $item['price'] ?? 0;
                }
            
                return [
                    'type'          => $item['type']      ?? 'product',
                    'product_id'    => $item['product_id']?? null,
                    'service_id'    => $item['service_id']?? null,
                    'tour_id'       => $item['tour_id']   ?? null,
                    'package_id'    => $item['package_id']?? null,
                    'qty'           => $qty,
                    'title'         => $item['title']     ?? 'Без названия',
                    'price'         => $price,
                    'currency'      => $currency,
                    'package_title' => $package_title,
                    'package_price' => $package_price,
                    'options_info'  => $options_info,
                ];
            }, $bucket);            
        }
        return view('bucket.index', ['bucket' => $bucket]);
    }
    

    // Добавить товар/услугу/тур в корзину
    public function add(Request $request)
{
    $type = $request->input('type', 'product');
    $qty = (int)($request->input('qty', 1));
    $options = $request->input('options', []);
    $package_id = $request->input('package_id');
    $product_id = $type === 'product' || $type === 'jewelry' || $type === 'wear' || $type === 'service' || $type === 'tour' ? $request->input('product_id') : null;
    $service_id = $type === 'service' ? $request->input('service_id') : null;
    $tour_id = $type === 'tour' ? $request->input('tour_id') : null;

    // Логирование для проверки
    \Log::info('Bucket add request:', [
        'user_id' => Auth::id(),
        'type' => $type,
        'product_id' => $product_id,
        'service_id' => $service_id,
        'tour_id' => $tour_id,
        'package_id' => $package_id,
        'qty' => $qty,
        'options' => $options,
    ]);

    if (Auth::check()) {
        $cartItem = UserCart::where('user_id', Auth::id())
            ->where('product_id', $product_id)
            ->where('service_id', $service_id)
            ->where('tour_id', $tour_id)
            ->where('package_id', $package_id)
            ->where('options', json_encode($options))
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $qty;
            $cartItem->save();
            \Log::info('Cart item updated', ['id' => $cartItem->id]);
        } else {
            $cart = UserCart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product_id,
                'service_id' => $service_id,
                'tour_id'    => $tour_id,
                'package_id' => $package_id,
                'quantity'   => $qty,
                'options'    => $options,
            ]);
            \Log::info('Cart item created', ['id' => $cart->id]);
        }
    } else {
        // Для гостей — в сессию
        $bucket = Session::get('bucket', []);
        $found = false;
    
        // Получаем цену и валюту для типа
        $price = 0;
        $currency = '₸';
        $options_info = [];
    
        if ($type === 'product' || $type === 'jewelry' || $type === 'wear') {
            $product = \App\Models\Product::find($product_id);
            if ($product) {
                $price = $product->price;
                $currency = $product->currency ?? $currency;
            }
        } elseif ($type === 'service') {
            $service = \App\Models\Service::find($service_id);
            if ($service) {
                $price = $service->price;
                $currency = $service->currency ?? $currency;
                // Плюсуем цены выбранных опций, если они есть
                if (!empty($options)) {
                    $addons = \App\Models\ServiceAddon::whereIn('id', $options)->get();
                    foreach ($addons as $addon) {
                        $options_info[] = [
                            'title' => $addon->getTranslation('title', app()->getLocale()),
                            'price' => $addon->price,
                        ];
                    $price += $addons->sum('price');
                    }
                }
            }
        } elseif ($type === 'tour') {
            $package = \App\Models\TourPackage::find($package_id);
            if ($package) {
                $price = $package->price;
                $currency = $package->currency ?? $currency;
                // Плюсуем цены выбранных опций, если они есть
                if (!empty($options)) {
                    $tourOptions = \App\Models\TourOption::whereIn('id', $options)->get();
                    foreach ($tourOptions as $opt) {
                        $options_info[] = [
                            'title' => $opt->getTranslation('title', app()->getLocale()),
                            'price' => $opt->price,
                        ];
                    $price += $tourOptions->sum('price');
                    }
                }
            }
        }
    
        foreach ($bucket as &$item) {
            if (
                $item['product_id'] == $product_id
                && $item['service_id'] == $service_id
                && $item['tour_id'] == $tour_id
                && $item['package_id'] == $package_id
                && $item['options'] == $options
                && $item['price'] == (float)$request->input('price')
                && $item['title'] == $request->input('title')
                && $item['currency'] == $request->input('currency', '₸') 
            ) {
                $item['qty'] += $qty;
                $found = true;
                break;
            }
        }
        unset($item);
    
        if (!$found) {
            $bucket[] = [
                'type'       => $type,
                'product_id' => $product_id,
                'service_id' => $service_id,
                'tour_id'    => $tour_id,
                'package_id' => $package_id,
                'qty'        => $qty,
                'options'    => $options,
                'options_info' => $options_info,
                'title'      => $request->input('title'),       
                'price'      => (float)$request->input('price'), 
                'currency'   => $request->input('currency', '₸') 
            ];
        }
        Session::put('bucket', $bucket);
        \Log::info('Bucket updated in session', ['bucket' => $bucket]);
    }

    return redirect()->route('bucket.index')->with('success', 'Товар добавлен в корзину');
}


    // Удалить по индексу (гость) или id (пользователь)
    public function remove(Request $request, $id)
    {
        if (Auth::check()) {
            UserCart::where('user_id', Auth::id())->where('id', $id)->delete();
        } else {
            $bucket = Session::get('bucket', []);
            if (isset($bucket[$id])) {
                unset($bucket[$id]);
            }
            Session::put('bucket', array_values($bucket));
        }
        return redirect()->route('bucket.index')->with('success', 'Товар удалён из корзины');
    }

    // Очистить корзину
    public function clear()
    {
        if (Auth::check()) {
            UserCart::where('user_id', Auth::id())->delete();
        } else {
            Session::forget('bucket');
        }
        return redirect()->route('bucket.index')->with('success', 'Корзина очищена');
    }
}
