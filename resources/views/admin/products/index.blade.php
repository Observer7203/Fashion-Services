@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-6">Все товары</h1>

    <a href="{{ route('products.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Добавить товар</a>

    @if($products->isEmpty())
        <p class="text-gray-600">Товаров нет.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Название</th>
                        <th class="p-2 border">Тип</th>
                        <th class="p-2 border">Цена</th>
                        <th class="p-2 border">Статус</th>
                        <th class="p-2 border">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="p-2 border">{{ $product->id }}</td>
                            <td class="p-2 border">{{ $product->getTranslation('title', app()->getLocale()) }}</td>
                            <td class="p-2 border">{{ $product->type }}</td>
                            <td class="p-2 border">{{ number_format($product->price, 2, '.', ' ') }}&nbsp;₸</td>
                            <td class="p-2 border">{{ $product->status }}</td>
                            <td class="p-2 border">
                                <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline">Редактировать</a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline ml-3" onclick="return confirm('Удалить этот товар?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
