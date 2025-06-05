@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-4">Блоки сайта</h1>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="py-3 px-4 border-b">Ключ</th>
                <th class="py-3 px-4 border-b">Тип</th>
                <th class="py-3 px-4 border-b">Статус</th>
                <th class="py-3 px-4 border-b">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blocks as $block)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $block->key }}</td>
                    <td class="py-2 px-4 border-b">{{ ucfirst($block->type) }}</td>
                    <td class="py-2 px-4 border-b">{{ ucfirst($block->status) }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('admin.blocks.edit', $block) }}" class="text-blue-600 hover:underline">Редактировать</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
