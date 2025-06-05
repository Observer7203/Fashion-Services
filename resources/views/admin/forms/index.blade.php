@extends('layouts.admin')

@section('content')
    <div class="container py-6">
        <h1 class="text-2xl font-bold mb-4">Формы заявок и анкет</h1>
        <a href="{{ route('forms.create') }}" class="btn btn-primary mb-4">+ Новая форма</a>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 mb-4">{{ session('success') }}</div>
        @endif

        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Название</th>
                    <th class="border p-2">Поля</th>
                    <th class="border p-2">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($forms as $form)
                    <tr>
                        <td class="border p-2">{{ $form->id }}</td>
                        <td class="border p-2">{{ $form->name }}</td>
                        <td class="border p-2">{{ $form->fields_count }}</td>
                        <td class="border p-2">
                            <a href="{{ route('forms.edit', $form) }}" class="text-blue-600">Редактировать</a>
                            <form action="{{ route('forms.destroy', $form) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Удалить форму?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $forms->links() }}
    </div>
@endsection
