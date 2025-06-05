@extends('layouts.admin')

@section('content')
<div class="container max-w-xl py-6">
    <h1 class="text-xl font-bold mb-4">Создать тип бронирования</h1>

    <form action="{{ route('reservation-types.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Название</label>
            <input name="title" type="text" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Slug (ключ)</label>
            <input name="slug" type="text" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Описание</label>
            <textarea name="description" rows="3" class="form-textarea w-full"></textarea>
        </div>

        <button class="btn btn-primary">Создать</button>
    </form>
</div>
@endsection
