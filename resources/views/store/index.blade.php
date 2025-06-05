@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h1 class="text-3xl font-bold mb-6">Магазин</h1>

    @if($products->isEmpty())
        <p class="text-gray-600">Товары пока не добавлены.</p>
    @else
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="border p-4 rounded shadow hover:shadow-md transition">
                    @if(!empty($product->media) && is_array($product->media))
                        <img src="{{ $product->media[0] }}" alt="{{ $product->title }}" class="mb-3 w-full h-48 object-cover rounded">
                    @endif

                    <h2 class="text-xl font-semibold mb-1">{{ $product->title }}</h2>
                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 100) }}</p>
                    <div class="text-lg font-semibold mb-2">{{ number_format($product->price, 0, '.', ' ') }} ₸</div>

                    <a href="{{ route('store.show', $product->slug) }}" class="text-blue-600 hover:underline">Подробнее</a>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
