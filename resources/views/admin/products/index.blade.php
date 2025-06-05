@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-4">Товары</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-4">Добавить товар</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full border">
        <thead>
            <tr>
                <th class="border p-2">Название</th>
                <th class="border p-2">Категория</th>
                <th class="border p-2">Цена (€)</th>
                <th class="border p-2">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="border p-2">{{ $product->title }}</td>
                    <td class="border p-2">{{ $product->category }}</td>
                    <td class="border p-2">{{ $product->price }}</td>
                    <td class="border p-2">
                        <a href="{{ route('products.edit', $product) }}" class="text-blue-600">Редактировать</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block ml-2">
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
