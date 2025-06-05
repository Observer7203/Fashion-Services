@extends('layouts.admin')

@section('content')
<div class="container max-w-3xl py-6">
    <h1 class="text-2xl font-bold mb-4">Редактировать блок</h1>

    <form method="POST" action="{{ route('admin.blocks.update', $block) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium mb-1">Заголовок</label>
            <input type="text" name="title" value="{{ old('title', $block->title) }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Контент</label>
            <textarea name="content" rows="5" class="w-full border rounded p-2">{{ old('content', $block->content) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Медиа (массив ссылок)</label>
            <textarea name="media" rows="3" class="w-full border rounded p-2">{{ old('media', json_encode($block->media)) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Тип</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="image" @selected($block->type === 'image')>Image</option>
                <option value="video" @selected($block->type === 'video')>Video</option>
                <option value="slider" @selected($block->type === 'slider')>Slider</option>
                <option value="custom" @selected($block->type === 'custom')>Custom</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Порядок</label>
            <input type="number" name="order" value="{{ old('order', $block->order) }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Статус</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="draft" @selected($block->status === 'draft')>Черновик</option>
                <option value="published" @selected($block->status === 'published')>Опубликовано</option>
            </select>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Сохранить</button>
    </form>
</div>
@endsection
