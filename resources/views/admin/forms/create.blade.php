@extends('layouts.admin')

@section('content')
    <div class="container py-6 max-w-xl">
        <h1 class="text-2xl font-bold mb-4">Создать новую форму</h1>

        <form method="POST" action="{{ route('forms.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-medium">Название формы</label>
                <input type="text" name="name" class="form-input w-full" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Описание (необязательно)</label>
                <textarea name="description" class="form-textarea w-full" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
