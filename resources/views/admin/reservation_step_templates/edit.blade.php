@extends('layouts.admin')

@section('content')
<div class="container max-w-xl py-6">
    <h1 class="text-xl font-bold mb-4">Редактировать шаг</h1>

    <form action="{{ route('reservation-types.steps.update', [$type->id, $stepTemplate->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Ключ шага</label>
            <input name="step_key" type="text" class="form-input w-full" value="{{ $stepTemplate->step_key }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Название шага</label>
            <input name="title" type="text" class="form-input w-full" value="{{ $stepTemplate->title }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Описание</label>
            <textarea name="description" rows="3" class="form-textarea w-full">{{ $stepTemplate->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Порядок</label>
            <input name="order" type="number" class="form-input w-full" value="{{ $stepTemplate->order }}" required>
        </div>

        <button class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection
