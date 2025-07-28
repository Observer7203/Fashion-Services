@extends('layouts.app')

@section('content')
<div class="container py-6 max-w-3xl">
    <h1 class="text-2xl font-bold mb-6">Корзина</h1>

    @php
        // $bucket должен приходить из контроллера: session('bucket', []) или из базы (по user_id)
        $total = 0;
        // можно вынести currency из первого не пустого товара
        $firstItem = collect($bucket)->first(fn($item) => !empty($item['currency']));
        $currency = $firstItem['currency'] ?? '₸';
    @endphp

    @if(empty($bucket))
        <p class="text-gray-600">Ваша корзина пуста.</p>
    @else
        <table class="w-full mb-6 border border-gray-200 text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left p-3">Название</th>
                    <th class="text-left p-3">Детали</th>
                    <th class="text-left p-3">Цена</th>
                    <th class="text-left p-3">Сумма</th>
                    <th class="text-left p-3">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bucket as $i => $item)
                    @php
                        $qty = $item['qty'] ?? 1;
                        $rowTotal = 0;
                    @endphp
                    <tr class="border-b">
                        <td class="p-3 align-top font-semibold">
                            {{ $item['title'] ?? $item['name'] ?? 'Без названия' }}
                            <div class="text-xs text-gray-500 mt-1">
                                @if($item['type'] === 'jewelry')
                                Ювелирка
                            @elseif($item['type'] === 'wear')
                                Одежда
                            @elseif($item['type'] === 'tour')
                                Тур
                            @elseif($item['type'] === 'service')
                                Услуга
                            @endif
                            </div>
                        </td>
                        <td class="p-3 align-top">
                            @if($item['type'] === 'tour')
                                <div>
                                    <b>Пакет:</b> {{ $item['package_title'] ?? '' }}
                                    <br>
                                    <b>Кол-во человек:</b> {{ $qty }}
                                    @if(!empty($item['options_info']))
                                        <br><b>Опции:</b>
                                        <ul class="list-disc ml-4">
                                            @foreach($item['options_info'] as $opt)
                                                <li>{{ $opt['title'] }} ({{ number_format($opt['price'], 0, '.', ' ') }} {{ $currency }})</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @elseif($item['type'] === 'service')
                                @if(!empty($item['options_info']))
                                    <b>Опции:</b>
                                    <ul class="list-disc ml-4">
                                        @foreach($item['options_info'] as $opt)
                                            <li>{{ $opt['title'] }} ({{ number_format($opt['price'], 0, '.', ' ') }} {{ $currency }})</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>—</span>
                                @endif
                            @else
                                <span>—</span>
                            @endif
                        </td>
                        <td class="p-3 align-top">
                            @if($item['type'] === 'tour')
                                @php
                                    $base = $item['package_price'] ?? 0;
                                    $optsum = collect($item['options_info'] ?? [])->sum('price');
                                    $onesum = $base + $optsum;
                                    $rowTotal = $onesum * $qty;
                                @endphp
                                {{ number_format($onesum, 0, '.', ' ') }} {{ $currency }} <span class="text-xs">×{{ $qty }}</span>
                            @elseif($item['type'] === 'service')
                                @php
                                    $onesum = ($item['price'] ?? 0) + collect($item['options_info'] ?? [])->sum('price');
                                    $rowTotal = $onesum * $qty;
                                @endphp
                                {{ number_format($onesum, 0, '.', ' ') }} {{ $currency }} <span class="text-xs">×{{ $qty }}</span>
                            @else
                                @php
                                    $onesum = $item['price'] ?? 0;
                                    $rowTotal = $onesum * $qty;
                                @endphp
                                {{ number_format($onesum, 0, '.', ' ') }} {{ $currency }} <span class="text-xs">×{{ $qty }}</span>
                            @endif
                        </td>
                        <td class="p-3 align-top font-semibold">
                            {{ number_format($rowTotal, 0, '.', ' ') }} {{ $currency }}
                            @php $total += $rowTotal; @endphp
                        </td>
                        <td class="p-3 align-top">
                            <form method="POST" action="{{ route('bucket.remove', Auth::check() ? ($item['id'] ?? $i) : $i) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-xl font-semibold mb-4">
            Итого: {{ number_format($total, 0, '.', ' ') }} {{ $currency }}
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('checkout.show') }}"
               class="custom-cart-btn">
                <span class="btn-text">Оформить заказ</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="cart-icon" viewBox="0 0 24 24" fill="none">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 
                        1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 
                        1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 
                        1 5.513 7.5h12.974c.576 0 1.059.435 
                        1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 
                        0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 
                        1-.75 0 .375.375 0 0 1 .75 0Z"
                        stroke="currentColor" stroke-width="1.5"/>
                </svg>
            </a>
        </div>
        
    <style>
    .custom-cart-btn {
        display: inline-flex;
        align-items: center; 
        justify-content: center;
        gap: 8px;
        padding: 10px 20px;
        border: 1px solid black;
        background-color: white;
        color: black;
        font-size: 16px;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
        line-height: 1;
    }

    .custom-cart-btn svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        display: inline-block;
    }


    .custom-cart-btn:hover {
        background-color: black;
        color: white;
    }

    .custom-cart-btn.added {
        background-color: black;
        color: white;
    }

    .btn-icon {
        width: 20px;
        height: 20px;
    }
    
    .button-text {
    font-weight: 400;
    font-family: 'Mulish';
    font-size: 16px;
    }
    </style>    
               
    
    @endif
</div>
@endsection
