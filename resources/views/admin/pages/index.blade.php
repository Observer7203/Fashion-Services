@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-4">Страницы сайта</h1>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="py-3 px-4 border-b text-left">Название</th>
                <th class="py-3 px-4 border-b text-left">Статус</th>
                <th class="py-3 px-4 border-b text-left">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $page->title }}</td>
                    <td class="py-2 px-4 border-b">{{ ucfirst($page->status) }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="text-blue-600 hover:underline">Редактировать</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
