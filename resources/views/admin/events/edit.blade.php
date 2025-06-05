@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-4">Редактировать мероприятие</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('events.update', $event) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold">Название</label>
            <input type="text" name="title" class="w-full border p-2" value="{{ old('title', $event->title) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Подзаголовок</label>
            <input type="text" name="subtitle" class="w-full border p-2" value="{{ old('subtitle', $event->subtitle) }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Краткое описание</label>
            <textarea name="short_description" class="w-full border p-2">{{ old('short_description', $event->short_description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Полное описание</label>
            <textarea name="description" class="w-full border p-2">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Дата (JSON)</label>
            <textarea name="dates" class="w-full border p-2">{{ old('dates', json_encode($event->dates)) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Локация</label>
            <input type="text" name="location" class="w-full border p-2" value="{{ old('location', $event->location) }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Что включено (JSON)</label>
            <textarea name="included" class="w-full border p-2">{{ old('included', json_encode($event->included)) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">FAQ (JSON)</label>
            <textarea name="faq" class="w-full border p-2">{{ old('faq', json_encode($event->faq)) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Историческая значимость</label>
            <textarea name="historical" class="w-full border p-2">{{ old('historical', $event->historical) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Формат</label>
            <input type="text" name="format" class="w-full border p-2" value="{{ old('format', $event->format) }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Организаторы (JSON)</label>
            <textarea name="organizers" class="w-full border p-2">{{ old('organizers', json_encode($event->organizers)) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Участники (JSON)</label>
            <textarea name="participants" class="w-full border p-2">{{ old('participants', json_encode($event->participants)) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Трансляции (JSON)</label>
            <textarea name="streams" class="w-full border p-2">{{ old('streams', json_encode($event->streams)) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Туры, в которых включено (JSON)</label>
            <textarea name="tours_included" class="w-full border p-2">{{ old('tours_included', json_encode($event->tours_included)) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Сезоны (JSON)</label>
            <textarea name="seasons" class="w-full border p-2">{{ old('seasons', json_encode($event->seasons)) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Медиа (ссылки через запятую)</label>
            <input type="text" name="media[]" class="w-full border p-2"
                   value="{{ is_array($event->media) ? implode(',', $event->media) : '' }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Частота</label>
            <input type="text" name="frequency" class="w-full border p-2" value="{{ old('frequency', $event->frequency) }}">
        </div>

        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
</div>
@endsection
