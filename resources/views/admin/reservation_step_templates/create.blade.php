@extends('layouts.admin')

@section('content')
<div class="container max-w-xl py-6">
    <h1 class="text-xl font-bold mb-4">Добавить шаг</h1>

    <form action="{{ route('reservation-types.steps.store', $type->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Ключ шага</label>
            <input name="step_key" type="text" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Название шага</label>
            <input name="title" type="text" class="form-input w-full" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Описание</label>
            <textarea name="description" rows="3" class="form-textarea w-full"></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Порядок</label>
            <input name="order" type="number" class="form-input w-full" required value="1" min="1">
        </div>

        <button class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection
