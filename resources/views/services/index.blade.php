@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h1 class="text-3xl font-bold mb-6">Услуги</h1>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach($services as $service)
            <div class="border p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">{{ $service->title }}</h2>
                <p class="text-sm text-gray-600 mb-2">{{ $service->short_description }}</p>
                <div class="mb-2"><strong>Цена:</strong> {{ number_format($service->price, 0, '.', ' ') }} ₸</div>
                <a href="{{ url('/services/' . $service->slug) }}" class="text-blue-600 hover:underline">Подробнее</a>
            </div>
        @endforeach
    </div>
</div>
@endsection
