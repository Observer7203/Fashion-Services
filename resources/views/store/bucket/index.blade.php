@extends('layouts.app')

@section('content')
<div class="container py-6 max-w-3xl">
    <h1 class="text-2xl font-bold mb-6">Корзина</h1>

    @php
        $products = \App\Models\Product::whereIn('id', $items)->get();
        $total = $products->sum('price');
    @endphp

    @if($products->isEmpty())
        <p class="text-gray-600">Ваша корзина пуста.</p>
    @else
        <table class="w-full mb-6 border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left p-3">Товар</th>
                    <th class="text-left p-3">Цена</th>
                    <th class="text-left p-3">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-b">
                        <td class="p-3">{{ $product->title }}</td>
                        <td class="p-3">{{ number_format($product->price, 0, '.', ' ') }} ₸</td>
                        <td class="p-3">
                            <form method="POST" action="{{ route('store.bucket.remove', $product->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-xl font-semibold mb-4">Итого: {{ number_format($total, 0, '.', ' ') }} ₸</div>

        <a href="#" class="btn btn-primary">Перейти к оформлению</a> {{-- checkout будет позже --}}
    @endif
</div>
@endsection
