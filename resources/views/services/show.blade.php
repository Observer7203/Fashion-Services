@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h1 class="text-3xl font-bold mb-4">{{ $service->title }}</h1>

    <p class="text-gray-600 mb-2">{{ $service->subtitle }}</p>
    <p class="mb-4">{{ $service->description }}</p>

    <div class="mb-4">
        <strong>Цена:</strong> {{ number_format($service->price, 0, '.', ' ') }} ₸
    </div>

    @if($service->reservation_type_id)
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type_id" value="{{ $service->reservation_type_id }}">
            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <button class="btn btn-primary">Зарезервировать</button>
        </form>
    @endif
</div>
@endsection
