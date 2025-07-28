<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (Auth::check()) {
            // Для авторизованных: грузим корзину из базы
            $items = \App\Models\UserCart::where('user_id', Auth::id())
                ->with(['product', 'service', 'tour', 'package'])
                ->get();
    
            $bucket = [];
            foreach ($items as $item) {
                if ($item->product_id) {
                    $type = $item->product->type ?? 'product';
                    $title = $item->product->title ?? 'Товар';
                    $price = $item->product->price ?? 0;
                } elseif ($item->service_id) {
                    $type = 'service';
                    $title = $item->service->title ?? 'Услуга';
                    $price = $item->service->price ?? 0;
                } elseif ($item->tour_id) {
                    $type = 'tour';
                    $title = $item->tour->title ?? 'Тур';
                    $price = $item->package ? $item->package->price : 0;
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
                    // ВСЕГДА получаем актуальную цену услуги и опций из БД!
                    $service = \App\Models\Service::find($item->service_id);
                    $price = $service ? $service->price : 0;
                    $options_info = [];
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
                }
    
                $bucket[] = [
                    'type' => $type,
                    'title' => $title,
                    'qty' => $item->quantity ?? 1,
                    'price' => $price,
                    'package_title' => $item->package ? $item->package->getTranslation('title', app()->getLocale()) : null,
                    'package_price' => $item->package ? $item->package->price : null,
                    'options_info' => $options_info,
                ];
            }
        } else {
            // Для гостей: корзина из сессии
            $bucket = session('bucket', []);
        }
    
        return view('checkout.show', compact('user', 'bucket'));
    }
    

    public function process(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:80',
            'last_name'  => 'required|string|max:80',
            'email'      => 'required|email|max:120',
            'phone'      => 'nullable|string|max:32',
            'address'    => 'nullable|string|max:255',
            // можно добавить delivery_type, payment_method, etc.
        ]);

        // Получаем корзину
        $bucket = Auth::check()
            ? app('App\Http\Controllers\BucketController')->getBucketForUser(Auth::id())
            : Session::get('bucket', []);

        if (empty($bucket)) {
            return redirect()->route('bucket.index')->with('error', 'Ваша корзина пуста!');
        }

        // Создаём заказ
        $order = Order::create([
            'user_id'    => Auth::id() ?? null,
            'guest_email'=> Auth::check() ? null : $data['email'],
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'] ?? null,
            'address'    => $data['address'] ?? null,
            'status'     => 'pending',
            'total_sum'  => collect($bucket)->sum(fn($i) => ($i['price'] ?? 0) * ($i['qty'] ?? 1)),
        ]);

        
        \Log::info('Order created:', $order->toArray());

        // Добавляем товары к заказу
        foreach ($bucket as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'type'       => $item['type'],
                'title'      => $item['title'],
                'product_id' => $item['product_id'] ?? null,
                'service_id' => $item['service_id'] ?? null,
                'tour_id'    => $item['tour_id'] ?? null,
                'package_id' => $item['package_id'] ?? null,
                'qty'        => $item['qty'] ?? 1,
                'price'      => $item['price'] ?? 0,
                'currency'   => $item['currency'] ?? '₸',
                'options'    => json_encode($item['options'] ?? []),
            ]);
        }

        // Очищаем корзину
        if (Auth::check()) {
            \App\Models\UserCart::where('user_id', Auth::id())->delete();
        } else {
            Session::forget('bucket');
        }

        // Редиректим на страницу заказа/спасибо
        return redirect()->route('checkout.thankyou', ['order' => $order->id]);
    }

    // Страница "Спасибо за заказ"
    public function thankyou($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        return view('checkout.thankyou', compact('order'));
    }

    // Получение корзины (универсальная функция)
    public function getBucketForUser($userId)
    {
        $items = \App\Models\UserCart::where('user_id', $userId)->get();
        return $items->map(function ($item) {
            return [
                'type'       => $item->type,
                'title'      => $item->title,
                'product_id' => $item->product_id,
                'service_id' => $item->service_id,
                'tour_id'    => $item->tour_id,
                'package_id' => $item->package_id,
                'qty'        => $item->quantity ?? 1,
                'price'      => $item->price ?? 0,
                'currency'   => $item->currency ?? '₸',
                'options'    => $item->options ? json_decode($item->options, true) : [],
            ];
        })->toArray();
    }

    public function store(Request $request)
    {

        \Log::info('Checkout form data:', $request->all());

        // 1. Валидация формы
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:64',
            'address' => 'nullable|string|max:512',
        ]);

        // 2. Получение корзины
        $bucket = Auth::check()
            ? $this->getUserBucket(Auth::id())
            : session('bucket', []);

        \Log::info('Bucket data at checkout:', $bucket);

            // ! ВРЕМЕННО добавь
        dd($bucket);

        if (empty($bucket)) {
            return back()->with('error', 'Ваша корзина пуста.');
        }

        // 3. Подсчет суммы
        $total = 0;
        foreach ($bucket as $item) {
            $qty = $item['qty'] ?? 1;
            if($item['type'] === 'tour') {
                $base = $item['package_price'] ?? 0;
                $optsum = collect($item['options_info'] ?? [])->sum('price');
                $onesum = $base + $optsum;
                $rowTotal = $onesum * $qty;
            } elseif($item['type'] === 'service') {
                $onesum = ($item['price'] ?? 0) + collect($item['options_info'] ?? [])->sum('price');
                $rowTotal = $onesum * $qty;
            } else {
                $onesum = $item['price'] ?? 0;
                $rowTotal = $onesum * $qty;
            }
            $total += $rowTotal;
        }

        // 4. Создание заказа
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total' => $total,
            'meta' => [
                'customer_name' => $data['name'],
                'customer_email' => $data['email'],
                'customer_phone' => $data['phone'],
                'customer_address' => $data['address'] ?? null,
                'guest' => Auth::guest() ? 1 : 0,
            ]
        ]);

        // 5. Запись позиций заказа
        foreach ($bucket as $item) {
            $qty = $item['qty'] ?? 1;
            $itemType = $item['type'];
            $itemId = $item['product_id'] ?? $item['service_id'] ?? $item['tour_id'] ?? null;
            $itemTitle = $item['title'] ?? $item['name'] ?? 'Без названия';
            // Цена одной позиции (БЕЗ qty)
            if($itemType === 'tour') {
                $base = $item['package_price'] ?? 0;
                $optsum = collect($item['options_info'] ?? [])->sum('price');
                $onesum = $base + $optsum;
            } elseif($itemType === 'service') {
                $onesum = ($item['price'] ?? 0) + collect($item['options_info'] ?? [])->sum('price');
            } else {
                $onesum = $item['price'] ?? 0;
            }

            OrderItem::create([
                'order_id'  => $order->id,
                'type'      => $itemType,
                'item_id'   => $itemId,
                'title'     => $itemTitle,
                'price'     => $onesum,
                'quantity'  => $qty,
                'options'   => json_encode([
                    'package_id' => $item['package_id'] ?? null,
                    'package_title' => $item['package_title'] ?? null,
                    'options_info' => $item['options_info'] ?? [],
                ]),
            ]);
        }

        // 6. Очистить корзину
        if (Auth::check()) {
            \App\Models\UserCart::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('bucket');
        }

        // 7. Редирект с сообщением
        return redirect()->route('home')->with('success', 'Ваш заказ успешно оформлен!');
    }

    // Получение корзины пользователя (авторизованный)
    protected function getUserBucket($userId)
    {
        $items = \App\Models\UserCart::where('user_id', $userId)
            ->with(['product', 'service', 'tour', 'package'])
            ->get();

        $bucket = [];
        foreach ($items as $item) {
            if ($item->product_id) {
                $type = $item->product->type ?? 'product';
                $title = $item->product->title ?? 'Товар';
                $price = $item->product->price ?? 0;
            } elseif ($item->service_id) {
                $type = 'service';
                $title = $item->service->title ?? 'Услуга';
                $price = $item->service->price ?? 0;
            } elseif ($item->tour_id) {
                $type = 'tour';
                $title = $item->tour->title ?? 'Тур';
                $price = $item->package ? $item->package->price : 0;
            } else {
                $type = 'unknown';
                $title = 'Без названия';
                $price = 0;
            }

            $options_info = [];
            if ($type === 'tour' && $item->options) {
                $optionIds = is_array($item->options) ? $item->options : json_decode($item->options, true);
                $tourOptions = \App\Models\TourOption::whereIn('id', $optionIds)->get();
                foreach ($tourOptions as $opt) {
                    $options_info[] = [
                        'title' => $opt->getTranslation('title', app()->getLocale()),
                        'price' => $opt->price,
                    ];
                }
            } elseif ($type === 'service' && $item->options) {
                $addonIds = is_array($item->options) ? $item->options : json_decode($item->options, true);
                $addons = \App\Models\ServiceAddon::whereIn('id', $addonIds)->get();
                foreach ($addons as $addon) {
                    $options_info[] = [
                        'title' => $addon->getTranslation('title', app()->getLocale()),
                        'price' => $addon->price,
                    ];
                }
            }

            $bucket[] = [
                'type' => $type,
                'product_id' => $item->product_id,
                'service_id' => $item->service_id,
                'tour_id' => $item->tour_id,
                'package_id' => $item->package_id,
                'package_title' => $item->package ? $item->package->getTranslation('title', app()->getLocale()) : null,
                'package_price' => $item->package ? $item->package->price : null,
                'qty' => $item->quantity ?? 1,
                'title' => $title,
                'price' => $price,
                'options_info' => $options_info,
            ];
        }
        return $bucket;
    }
}
