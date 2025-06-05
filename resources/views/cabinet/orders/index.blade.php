@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-4">Мои заказы</h1>

    @if($orders->isEmpty())
        <p class="text-gray-600">У вас пока нет заказов.</p>
    @else
        <table class="min-w-full bg-white shadow rounded">
            <thead>
                <tr>
                    <th class="py-3 px-4 border-b text-left">ID</th>
                    <th class="py-3 px-4 border-b text-left">Дата</th>
                    <th class="py-3 px-4 border-b text-left">Сумма</th>
                    <th class="py-3 px-4 border-b text-left">Статус</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $order->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $order->created_at->format('d.m.Y') }}</td>
                        <td class="py-2 px-4 border-b">{{ number_format($order->total, 2) }} €</td>
                        <td class="py-2 px-4 border-b">{{ ucfirst($order->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
