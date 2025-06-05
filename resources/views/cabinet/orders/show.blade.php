@extends('layouts.app')

@section('content')
<div class="container py-6 max-w-3xl">
    <h1 class="text-2xl font-bold mb-4">Заказ #{{ $order->id }}</h1>

    <p class="mb-2 text-gray-700">
        <strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}<br>
        <strong>Статус:</strong> {{ ucfirst($order->status) }}<br>
        <strong>Сумма:</strong> {{ number_format($order->total, 2) }} €
            <strong>Оплачено:</strong>
    {{ $order->status === 'paid' ? 'Да' : 'Нет' }}
    </p>

    <a href="{{ route('cabinet.orders.invoice', $order) }}" class="text-blue-600 underline">
    Скачать квитанцию
    </a>

    <h2 class="text-xl font-semibold mt-6 mb-2">Товары</h2>

    <table class="w-full border rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Название</th>
                <th class="p-2 text-left">Цена</th>
                <th class="p-2 text-left">Кол-во</th>
                <th class="p-2 text-left">Сумма</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td class="p-2 border-b">{{ $item->title }}</td>
                    <td class="p-2 border-b">{{ number_format($item->price, 2) }} €</td>
                    <td class="p-2 border-b">{{ $item->quantity }}</td>
                    <td class="p-2 border-b">{{ number_format($item->price * $item->quantity, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
