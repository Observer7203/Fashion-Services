@extends('layouts.app')

@section('content')
<div class="container max-w-3xl py-6">
    <h1 class="text-2xl font-bold mb-6">Оформление заказа</h1>

    @php
        $total = 0;
        $firstItem = collect($bucket)->first(fn($item) => !empty($item['currency']));
        $currency = $firstItem['currency'] ?? '₸';
        $hasDelivery = collect($bucket)->contains(fn($item) => in_array($item['type'], ['product','wear','jewelry']));
    @endphp

    <table class="w-full mb-6 border text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-left">Название</th>
                <th class="p-2 text-left">Детали</th>
                <th class="p-2 text-left">Цена</th>
                <th class="p-2 text-left">Сумма</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bucket as $item)
                @php
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
                @endphp
                <tr>
                    <td class="p-2 border font-medium">
                        {{ $item['title'] ?? $item['name'] ?? 'Без названия' }}
                        <div class="text-xs text-gray-500 mt-1">
                            @if($item['type'] === 'product') Товар @endif
                            @if($item['type'] === 'service') Услуга @endif
                            @if($item['type'] === 'tour') Тур @endif
                        </div>
                    </td>
                    <td class="p-2 border">
                        @if($item['type'] === 'tour')
                            <b>Пакет:</b> {{ $item['package_title'] ?? '' }}<br>
                            <b>Кол-во человек:</b> {{ $qty }}
                            @if(!empty($item['options_info']))
                                <br><b>Опции:</b>
                                <ul class="list-disc ml-4">
                                    @foreach($item['options_info'] as $opt)
                                        <li>{{ $opt['title'] }} ({{ number_format($opt['price'], 0, '.', ' ') }} {{ $currency }})</li>
                                    @endforeach
                                </ul>
                            @endif
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
                    <td class="p-2 border">
                        {{ number_format($onesum, 0, '.', ' ') }} {{ $currency }}@if($item['type'] === 'tour' || $item['type'] === 'product') <span class="text-xs">×{{ $qty }}</span>@endif
                    </td>
                    <td class="p-2 border font-semibold">
                        {{ number_format($rowTotal, 0, '.', ' ') }} {{ $currency }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-xl font-semibold mb-6">Итого: {{ number_format($total, 0, '.', ' ') }} {{ $currency }}</div>

    <form method="POST" action="{{ route('checkout.store') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1" for="first_name">Имя <span class="text-red-500">*</span></label>
                <input type="text" required name="first_name" id="first_name" class="form-input w-full"
                       value="{{ old('first_name', Auth::user()->first_name ?? '') }}">
            </div>
            <div>
                <label class="block font-medium mb-1" for="last_name">Фамилия <span class="text-red-500">*</span></label>
                <input type="text" required name="last_name" id="last_name" class="form-input w-full"
                       value="{{ old('last_name', Auth::user()->last_name ?? '') }}">
            </div>
        </div>

        <div>
            <label class="block font-medium mb-1" for="email">Email <span class="text-red-500">*</span></label>
            <input type="email" required name="email" id="email" class="form-input w-full"
                   value="{{ old('email', Auth::user()->email ?? '') }}">
        </div>
        <div>
            <label class="block font-medium mb-1" for="phone">Телефон <span class="text-red-500">*</span></label>
            <input type="text" required name="phone" id="phone" class="form-input w-full"
                   value="{{ old('phone', Auth::user()->phone ?? '') }}">
        </div>
        @if($hasDelivery)
        <div>
            <label class="block font-medium mb-1" for="address">Адрес доставки <span class="text-red-500">*</span></label>
            <input type="text" required name="address" id="address" class="form-input w-full"
                   value="{{ old('address', Auth::user()->address ?? '') }}">
        </div>
        @endif

        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" required name="agreement" class="form-checkbox mr-2">
                <span>Я согласен с <a href="/policy" target="_blank" class="underline">условиями обработки персональных данных</a></span>
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Подтвердить заказ</button>
    </form>
</div>
@endsection
