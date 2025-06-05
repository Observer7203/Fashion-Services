@extends('layouts.admin')

@section('content')
<div class="container max-w-3xl py-6">
    <h1 class="text-2xl font-bold mb-4">Редактировать страницу</h1>

    <form method="POST" action="{{ route('admin.pages.update', $page) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block mb-1 font-medium">Название</label>
            <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label for="content" class="block mb-1 font-medium">Контент</label>
            <textarea name="content" id="content" rows="10" class="w-full border rounded p-2">{{ old('content', $page->content) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="meta[title]" class="block mb-1 font-medium">SEO Title</label>
            <input type="text" name="meta[title]" value="{{ old('meta.title', $page->meta['title'] ?? '') }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label for="meta[description]" class="block mb-1 font-medium">SEO Description</label>
            <textarea name="meta[description]" rows="3" class="w-full border rounded p-2">{{ old('meta.description', $page->meta['description'] ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="meta[og_image]" class="block mb-1 font-medium">OG Image (URL)</label>
            <input type="text" name="meta[og_image]" value="{{ old('meta.og_image', $page->meta['og_image'] ?? '') }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label for="status" class="block mb-1 font-medium">Статус</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="draft" @selected($page->status === 'draft')>Черновик</option>
                <option value="published" @selected($page->status === 'published')>Опубликовано</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Сохранить</button>
    </form>
</div>
@endsection
