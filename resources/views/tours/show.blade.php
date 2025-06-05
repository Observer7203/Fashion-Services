@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h1 class="text-3xl font-bold mb-4">{{ $tour->title }}</h1>

    <p class="text-gray-600 mb-2">{{ $tour->subtitle }}</p>
    <p class="mb-4">{{ $tour->description }}</p>

    <div class="mb-4">
        <strong>Цена:</strong> {{ number_format($tour->price, 0, '.', ' ') }} ₸
    </div>

    @if($tour->reservation_type_id)
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type_id" value="{{ $tour->reservation_type_id }}">
            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
            <button class="btn btn-primary">Зарезервировать</button>
        </form>
    @endif
</div>
@endsection
