@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-6">Бронирования клиентов</h1>

    <form method="GET" class="mb-4">
    <label for="status" class="mr-2 font-medium">Фильтр по статусу:</label>
    <select name="status" id="status" onchange="this.form.submit()" class="form-select inline-block w-auto">
        <option value="all">Все</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Ожидает</option>
        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>В процессе</option>
        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершено</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменено</option>
    </select>
</form>

    @foreach($reservations as $reservation)
        <div class="bg-white p-4 mb-4 rounded shadow border">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold">{{ $reservation->tour_name }}</h2>
                <a href="{{ route('reservations.edit', $reservation->id) }}" class="text-blue-600 hover:underline text-sm">Редактировать</a>
            </div>
            <p class="text-gray-600 text-sm">
                Пользователь: {{ $reservation->user->name }} | {{ $reservation->created_at->format('d.m.Y') }}<br>
                Этап: {{ $reservation->current_step }} | {{ $reservation->progress_percent }}%
            </p>
        </div>
    @endforeach

    {{ $reservations->links() }}
</div>
@endsection
