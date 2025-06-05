@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-xl font-bold mb-4">Типы резервации</h1>

    <a href="{{ route('reservation-types.create') }}" class="btn btn-primary mb-4">Добавить тип</a>

    <table class="table-auto w-full border">
        <thead>
            <tr>
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Название</th>
                <th class="p-2 border">Ключ</th>
                <th class="p-2 border">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($types as $type)
            <tr>
                <td class="p-2 border">{{ $type->id }}</td>
                <td class="p-2 border">{{ $type->title }}</td>
                <td class="p-2 border">{{ $type->slug }}</td>
                <td class="p-2 border">
                    <a href="{{ route('reservation-types.edit', $type) }}" class="text-blue-600">Редактировать</a> |
                    <a href="{{ route('reservation-types.steps.index', $type) }}" class="text-indigo-600">Шаги</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
