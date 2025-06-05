@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-4">Мероприятия</h1>
    <a href="{{ route('events.create') }}" class="btn btn-primary mb-4">Добавить мероприятие</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full border">
        <thead>
            <tr>
                <th class="border p-2">Название</th>
                <th class="border p-2">Дата</th>
                <th class="border p-2">Локация</th>
                <th class="border p-2">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td class="border p-2">{{ $event->title }}</td>
                    <td class="border p-2">{{ is_array($event->dates) ? implode(', ', $event->dates) : $event->dates }}</td>
                    <td class="border p-2">{{ $event->location }}</td>
                    <td class="border p-2">
                        <a href="{{ route('events.edit', $event) }}" class="text-blue-600">Редактировать</a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline-block ml-2">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
