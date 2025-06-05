@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-4">Моё бронирование</h1>

    <!-- Основная информация -->
    <div class="mb-6 space-y-2">
        <p><strong>Тип:</strong> {{ $reservation->reservationType->title ?? '—' }}</p>
        <p><strong>Статус:</strong> {{ ucfirst($reservation->status) }}</p>
        <p><strong>Прогресс:</strong> {{ $progress }}%</p>

        @if($reservation->tour)
            <p><strong>Тур:</strong> {{ $reservation->tour->title }}</p>
        @endif

        @if($reservation->service)
            <p><strong>Услуга:</strong> {{ $reservation->service->title }}</p>
        @endif

        @if($reservation->package)
            <p><strong>Выбранный пакет:</strong> {{ $reservation->package->title }} ({{ $reservation->package->price }} {{ $reservation->package->currency }})</p>
        @endif
    </div>

    <!-- Опции -->
    @if($reservation->options->count())
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Дополнительные опции</h2>
        <ul class="list-disc pl-6 space-y-1">
            @foreach($reservation->options as $option)
                <li>{{ $option->title }} ({{ $option->price }} {{ $option->currency }})</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Предпочтения -->
    @if($reservation->preferences->count())
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Индивидуальные предпочтения</h2>
        <ul class="list-disc pl-6 space-y-2">
            @foreach($reservation->preferences as $preference)
                <li>
                    <div>
                        {{ $preference->title }} ({{ $preference->extra_cost }} {{ $preference->currency }})
                        @if($preference->pivot->custom_note)
                            <div class="text-sm text-gray-500">Комментарий: {{ $preference->pivot->custom_note }}</div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Этапы бронирования -->
    <div class="space-y-4">
        <h2 class="text-xl font-semibold mb-2">Этапы</h2>
        @foreach($steps as $step)
            <div class="p-4 border rounded @if($step->is_completed) bg-green-50 @endif">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold">{{ $step->title }}</p>
                        <p class="text-sm text-gray-600">{{ $step->description }}</p>
                    </div>

                    @if(!$step->is_completed)
                        <form method="POST" action="{{ route('cabinet.reservations.step.complete', [$reservation->id, $step->id]) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary">Завершить</button>
                        </form>
                    @else
                        <span class="text-green-600 text-sm font-medium">✔ Завершено</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Отмена бронирования -->
    @if($reservation->status !== 'cancelled')
    <form method="POST" action="{{ route('cabinet.reservations.cancel', $reservation) }}" class="mt-6" onsubmit="return confirm('Вы уверены, что хотите отменить бронирование?')">
        @csrf
        @method('PATCH')
        <button class="bg-red-600 text-white px-4 py-2 rounded">Отменить бронирование</button>
    </form>
    @endif

</div>
@endsection
