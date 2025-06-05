@extends('layouts.admin')

@section('content')
<div class="container max-w-xl py-6">
    <h1 class="text-xl font-bold mb-4">Редактировать тип бронирования</h1>

    <form action="{{ route('reservation-types.update', $reservationType) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Название</label>
            <input name="title" type="text" class="form-input w-full" value="{{ $reservationType->title }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Slug (ключ)</label>
            <input name="slug" type="text" class="form-input w-full" value="{{ $reservationType->slug }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Описание</label>
            <textarea name="description" rows="3" class="form-textarea w-full">{{ $reservationType->description }}</textarea>
        </div>

        <button class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection
