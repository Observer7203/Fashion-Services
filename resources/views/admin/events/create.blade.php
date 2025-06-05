@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-4">Добавить мероприятие</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('events.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Название</label>
            <input type="text" name="title" class="w-full border p-2" value="{{ old('title') }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Подзаголовок</label>
            <input type="text" name="subtitle" class="w-full border p-2" value="{{ old('subtitle') }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Краткое описание</label>
            <textarea name="short_description" class="w-full border p-2" rows="2">{{ old('short_description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Полное описание</label>
            <textarea name="description" class="w-full border p-2" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Дата (JSON-массив)</label>
            <textarea name="dates" class="w-full border p-2" rows="2" placeholder='["2025-09-01","2025-09-07"]'>{{ old('dates') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Локация</label>
            <input type="text" name="location" class="w-full border p-2" value="{{ old('location') }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Что включено (JSON)</label>
            <textarea name="included" class="w-full border p-2" rows="2">{{ old('included') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">FAQ (JSON)</label>
            <textarea name="faq" class="w-full border p-2">{{ old('faq') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Историческая значимость</label>
            <textarea name="historical" class="w-full border p-2" rows="3">{{ old('historical') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Формат</label>
            <input type="text" name="format" class="w-full border p-2" value="{{ old('format') }}">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Организаторы (JSON)</label>
            <textarea name="organizers" class="w-full border p-2">{{ old('organizers') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Участники (JSON)</label>
            <textarea name="participants" class="w-full border p-2">{{ old('participants') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Трансляции (ссылки, JSON)</label>
            <textarea name="streams" class="w-full border p-2">{{ old('streams') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">В каких турах включено (JSON)</label>
            <textarea name="tours_included" class="w-full border p-2">{{ old('tours_included') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Сезоны (JSON)</label>
            <textarea name="seasons" class="w-full border p-2">{{ old('seasons') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Медиа (ссылки через запятую)</label>
            <input type="text" name="media[]" class="w-full border p-2" placeholder="https://...">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Частота</label>
            <input type="text" name="frequency" class="w-full border p-2" value="{{ old('frequency') }}">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection
