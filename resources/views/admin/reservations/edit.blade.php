@extends('layouts.admin')

@section('content')
<div class="container py-6 max-w-3xl">
    <h1 class="text-xl font-bold mb-4">Редактировать бронирование</h1>

    <form action="{{ route('reservations.update', $reservation) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium">Статус</label>
            <select name="status" class="w-full border rounded p-2">
                @foreach(['pending', 'in_progress', 'completed'] as $status)
                    <option value="{{ $status }}" @selected($reservation->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Заметки администратора</label>
            <textarea name="admin_notes" rows="4" class="w-full border rounded p-2">{{ $reservation->admin_notes }}</textarea>
        </div>

        <hr class="my-6">

        <!-- Информация о пакете -->
        @if($reservation->package)
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Выбранный пакет</h2>
                <p><strong>{{ $reservation->package->title }}</strong> — {{ $reservation->package->price }} {{ $reservation->package->currency }}</p>
                <ul class="list-disc pl-6 mt-2">
                    @foreach($reservation->package->items as $item)
                        <li>{{ $item->content }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Опции -->
        @if($reservation->options->count())
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Дополнительные опции</h2>
                <ul class="list-disc pl-6 space-y-1">
                    @foreach($reservation->options as $option)
                        <li>{{ $option->title }} — {{ $option->price }} {{ $option->currency }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Предпочтения -->
        @if($reservation->preferences->count())
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Индивидуальные предпочтения</h2>
                <ul class="list-disc pl-6 space-y-2">
                    @foreach($reservation->preferences as $pref)
                        <li>
                            {{ $pref->title }} — {{ $pref->extra_cost }} {{ $pref->currency }}
                            @if($pref->pivot->custom_note)
                                <div class="text-sm text-gray-500">Комментарий: {{ $pref->pivot->custom_note }}</div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <hr class="my-6">

        <!-- Шаги бронирования -->
        <h2 class="text-lg font-semibold mb-2">Шаги бронирования</h2>
        @foreach($steps as $step)
            <div class="border p-4 rounded mb-2 @if($step->is_completed) bg-green-50 @endif">
                <div class="flex justify-between items-center">
                    <div>
                        <strong>{{ $step->title }}</strong>
                        <p class="text-sm text-gray-600">{{ $step->description }}</p>
                    </div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="steps[{{ $step->id }}][is_completed]" {{ $step->is_completed ? 'checked' : '' }}>
                        <span>Завершено</span>
                    </label>
                </div>
            </div>
        @endforeach

        <button type="submit" class="mt-6 bg-blue-600 text-white px-6 py-2 rounded">Сохранить</button>
    </form>
</div>
@endsection
