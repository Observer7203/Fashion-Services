@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-4">Добавить товар</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Название</label>
            <input type="text" name="title" class="w-full border p-2" value="{{ old('title') }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Категория</label>
            <input type="text" name="category" class="w-full border p-2" value="{{ old('category') }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Описание</label>
            <textarea name="description" class="w-full border p-2" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Цена (€)</label>
            <input type="number" step="0.01" name="price" class="w-full border p-2" value="{{ old('price') }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Медиа (ссылки через запятую)</label>
            <input type="text" name="media[]" class="w-full border p-2" placeholder="https://..." multiple>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Характеристики (JSON)</label>
            <textarea name="attributes" class="w-full border p-2" rows="2" placeholder='{"размер":"S","цвет":"бежевый"}'>{{ old('attributes') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection
