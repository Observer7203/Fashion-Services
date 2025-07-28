@extends('layouts.app')
@section('content')
<div class="container max-w-2xl py-8">
    <h1 class="text-2xl font-bold mb-6">Спасибо за заказ!</h1>
    <p>Ваш заказ №{{ $order->id }} успешно оформлен.</p>
    <ul class="mb-6">
        @foreach($order->items as $item)
            <li>
                {{ $item->title }} × {{ $item->qty }} — <b>{{ number_format($item->price * $item->qty, 0, '.', ' ') }} {{ $item->currency }}</b>
            </li>
        @endforeach
    </ul>
    <div class="font-bold text-lg mb-2">
        Общая сумма: {{ number_format($order->total_sum, 0, '.', ' ') }} {{ $order->items->first()->currency ?? '₸' }}
    </div>
</div>
@endsection
