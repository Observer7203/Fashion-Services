@extends('layouts.app')

@section('content')
<div class="container max-w-3xl py-6">
    <h1 class="text-2xl font-bold mb-4">Оформление заказа</h1>

    <table class="w-full mb-6 border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-left">Товар</th>
                <th class="p-2 text-left">Цена</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($products as $product)
                <tr>
                    <td class="p-2 border">{{ $product->title }}</td>
                    <td class="p-2 border">{{ number_format($product->price, 0, '.', ' ') }} ₸</td>
                </tr>
                @php $total += $product->price; @endphp
            @endforeach
        </tbody>
    </table>

    <div class="text-xl font-semibold mb-4">Итого: {{ number_format($total, 0, '.', ' ') }} ₸</div>

    <form method="POST" action="{{ route('store.checkout.store') }}">
        @csrf
        <button class="btn btn-primary">Подтвердить заказ</button>
    </form>
</div>
@endsection
