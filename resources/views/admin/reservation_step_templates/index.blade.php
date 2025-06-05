@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-xl font-bold mb-4">Шаги для типа: {{ $type->title }}</h1>

    <a href="{{ route('reservation-types.steps.create', $type->id) }}" class="btn btn-primary mb-4">Добавить шаг</a>

    @if($steps->isEmpty())
        <p class="text-gray-600">Нет шагов для этого типа резервации.</p>
    @else
    <table class="table-auto w-full border">
        <thead>
            <tr>
                <th class="p-2 border">№</th>
                <th class="p-2 border">Название</th>
                <th class="p-2 border">Ключ</th>
                <th class="p-2 border">Порядок</th>
                <th class="p-2 border">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($steps as $step)
            <tr>
                <td class="p-2 border">{{ $loop->iteration }}</td>
                <td class="p-2 border">{{ $step->title }}</td>
                <td class="p-2 border">{{ $step->step_key }}</td>
                <td class="p-2 border">{{ $step->order }}</td>
                <td class="p-2 border">
                    <a href="{{ route('reservation-types.steps.edit', [$type->id, $step->id]) }}" class="text-blue-600">Редактировать</a>
                    <form action="{{ route('reservation-types.steps.destroy', [$type->id, $step->id]) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Удалить шаг?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
