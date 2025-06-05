@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h1 class="text-3xl font-bold mb-6">Туры</h1>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach($tours as $tour)
            <div class="border p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">{{ $tour->title }}</h2>
                <p class="text-sm text-gray-600 mb-2">{{ $tour->short_description }}</p>
                <div class="mb-2"><strong>Цена:</strong> {{ number_format($tour->price, 0, '.', ' ') }} ₸</div>
                <a href="{{ url('/tours/' . $tour->slug) }}" class="text-blue-600 hover:underline">Подробнее</a>
            </div>
        @endforeach
    </div>
</div>
@endsection
