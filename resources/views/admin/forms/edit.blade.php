@extends('layouts.admin')

@section('content')
    <div class="container py-6 max-w-3xl">
        <h1 class="text-2xl font-bold mb-4">Редактировать форму: {{ $form->name }}</h1>

        <form method="POST" action="{{ route('forms.update', $form) }}">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block font-medium">Название формы</label>
                <input type="text" name="name" value="{{ $form->name }}" class="form-input w-full" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Описание</label>
                <textarea name="description" class="form-textarea w-full" rows="3">{{ $form->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>

        <hr class="my-6">

        <h2 class="text-xl font-bold mb-2">Поля формы</h2>
        <form method="POST" action="{{ route('forms.fields.store', $form) }}" class="mb-6 flex gap-3 flex-wrap">
            @csrf
            <input type="text" name="label" class="form-input w-40" placeholder="Название поля" required>
            <select name="type" class="form-select w-32" required>
                <option value="text">Текст</option>
                <option value="multiple_choice">Множественный выбор</option>
                <option value="checkbox">Чекбокс</option>
                <option value="number">Число</option>
                <option value="radio">Радио</option>
                <option value="file_upload">Файл</option>
                <option value="rating">Оценка</option>
                <option value="scale">Шкала</option>
            </select>
            <input type="text" name="options[]" class="form-input w-56" placeholder="Опции (через запятую)">
            <label><input type="checkbox" name="required" value="1"> Обяз.</label>
            <input type="number" name="sort_order" class="form-input w-20" placeholder="Сортировка" value="0">
            <button type="submit" class="btn btn-success">+ Добавить</button>
        </form>

        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th class="border p-2">Название</th>
                    <th class="border p-2">Тип</th>
                    <th class="border p-2">Опции</th>
                    <th class="border p-2">Обязательное</th>
                    <th class="border p-2">Сортировка</th>
                    <th class="border p-2">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($form->fields as $field)
                    <tr>
                        <form method="POST" action="{{ route('forms.fields.update', [$form, $field]) }}">
                            @csrf @method('PUT')
                            <td class="border p-2"><input type="text" name="label" value="{{ $field->label }}" class="form-input w-full"></td>
                            <td class="border p-2">
                                <select name="type" class="form-select w-full">
                                    @foreach(['text','multiple_choice','checkbox','number','radio','file_upload','rating','scale'] as $type)
                                        <option value="{{ $type }}" @selected($field->type == $type)>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border p-2"><input type="text" name="options[]" value="{{ is_array($field->options) ? implode(',', $field->options) : '' }}" class="form-input w-full"></td>
                            <td class="border p-2">
                                <input type="checkbox" name="required" value="1" {{ $field->required ? 'checked' : '' }}>
                            </td>
                            <td class="border p-2">
                                <input type="number" name="sort_order" value="{{ $field->sort_order }}" class="form-input w-full">
                            </td>
                            <td class="border p-2 flex gap-1">
                                <button type="submit" class="btn btn-xs btn-primary">Сохранить</button>
                        </form>
                        <form action="{{ route('forms.fields.destroy', [$form, $field]) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger">Удалить</button>
                        </form>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
