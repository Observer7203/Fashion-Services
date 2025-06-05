@extends('layouts.admin')

@section('content')
<div class="container py-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Новое поле для формы: {{ $form->name }}</h1>
    <form method="POST" action="{{ route('forms.fields.store', $form) }}">
        @csrf
        <div x-data="{ type: '{{ old('type', 'text') }}' }">
            <div class="flex gap-4 items-center mb-2">
                <input type="text" name="label" value="{{ old('label') }}" placeholder="Название поля" class="form-input" required>
                <select name="type" x-model="type" class="form-select">
                    <option value="text">Текст</option>
                    <option value="multiple_choice">Множественный выбор</option>
                    <option value="checkbox">Чекбокс</option>
                    <option value="number">Число</option>
                    <option value="radio">Радио</option>
                    <option value="file_upload">Файл</option>
                    <option value="rating">Оценка</option>
                    <option value="scale">Шкала</option>
                </select>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input w-20" placeholder="Сортировка">
                <label class="ml-2">
                    <input type="checkbox" name="required" value="1" {{ old('required') ? 'checked' : '' }}> Обяз.
                </label>
            </div>
            <!-- Тип: text -->
            <div x-show="type === 'text'" class="mb-2">
                <input type="text" name="options[placeholder]" value="{{ old('options.placeholder') }}" class="form-input" placeholder="Placeholder">
                <input type="number" name="options[minlength]" value="{{ old('options.minlength') }}" class="form-input" placeholder="Минимальная длина">
                <input type="number" name="options[maxlength]" value="{{ old('options.maxlength') }}" class="form-input" placeholder="Максимальная длина">
            </div>
            <!-- Тип: multiple_choice, radio -->
            <div x-show="type === 'multiple_choice' || type === 'radio'" class="mb-2">
                <textarea name="options[choices]" class="form-input" placeholder="Варианты (по одному на строку)">{{ old('options.choices') }}</textarea>
            </div>
            <!-- Тип: checkbox -->
            <div x-show="type === 'checkbox'" class="mb-2">
                <input type="text" name="options[label]" value="{{ old('options.label') }}" class="form-input" placeholder="Метка">
                <input type="text" name="options[value]" value="{{ old('options.value') }}" class="form-input" placeholder="Значение по умолчанию">
            </div>
            <!-- Тип: number -->
            <div x-show="type === 'number'" class="mb-2">
                <input type="number" name="options[min]" value="{{ old('options.min') }}" class="form-input" placeholder="Минимум">
                <input type="number" name="options[max]" value="{{ old('options.max') }}" class="form-input" placeholder="Максимум">
                <input type="number" name="options[step]" value="{{ old('options.step') }}" class="form-input" placeholder="Шаг">
            </div>
            <!-- Тип: file_upload -->
            <div x-show="type === 'file_upload'" class="mb-2">
                <input type="text" name="options[mimes]" value="{{ old('options.mimes') }}" class="form-input" placeholder="Допустимые типы (через запятую, напр. jpg,png)">
                <input type="number" name="options[max_size]" value="{{ old('options.max_size') }}" class="form-input" placeholder="Макс. размер (КБ)">
            </div>
            <!-- Тип: rating -->
            <div x-show="type === 'rating'" class="mb-2">
                <input type="number" name="options[count]" value="{{ old('options.count', 5) }}" class="form-input" placeholder="Количество звёзд">
                <input type="text" name="options[labels]" value="{{ old('options.labels') }}" class="form-input" placeholder="Подписи (через запятую)">
            </div>
            <!-- Тип: scale -->
            <div x-show="type === 'scale'" class="mb-2">
                <input type="number" name="options[min]" value="{{ old('options.min', 1) }}" class="form-input" placeholder="Минимум">
                <input type="number" name="options[max]" value="{{ old('options.max', 10) }}" class="form-input" placeholder="Максимум">
                <input type="number" name="options[step]" value="{{ old('options.step', 1) }}" class="form-input" placeholder="Шаг">
                <input type="text" name="options[labels]" value="{{ old('options.labels') }}" class="form-input" placeholder="Подписи к шкале (через запятую)">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Сохранить</button>
    </form>
    <a href="{{ route('forms.edit', $form) }}" class="inline-block mt-4 text-blue-600">← Назад к форме</a>
</div>
@endsection
