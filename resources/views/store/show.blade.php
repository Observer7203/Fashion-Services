@extends('layouts.app')

@section('content')
<div class="container py-6 max-w-3xl">
    <h1 class="text-3xl font-bold mb-4">{{ $product->title }}</h1>

    @if(!empty($product->media) && is_array($product->media))
        <div class="mb-4">
            <img src="{{ $product->media[0] }}" alt="{{ $product->title }}" class="w-full rounded shadow">
        </div>
    @endif

    <div class="text-lg text-gray-700 mb-4">
        {!! nl2br(e($product->description)) !!}
    </div>

    <div class="text-xl font-semibold mb-4">
        Цена: {{ number_format($product->price, 0, '.', ' ') }} ₸
    </div>

    <form method="POST" action="{{ route('store.bucket.add', $product->id) }}">
        @csrf
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            В корзину
        </button>
    </form>
</div>
@endsection
