@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-7xl py-8" x-data="tourList()">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Список туров</h1>
    </div>

    <div class="mb-4 flex items-center gap-4 justify-between">
        <div style="display: flex;">
        <div style="display: flex; align-items: center;">
        <button type="button" @click="confirmMassDelete()" class="btn btn-sm btn-danger button-delete" style="font-weight: 400;" :disabled="selected.length === 0">
            Удалить <span x-text="selected.length"></span>
        </button>
        </div>
        <div class="flex items-center justify-between" style="margin-left: 10px;">
            <form method="GET" action="{{ route('tours.index') }}" class="flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск" class="form-input border p-2 rounded w-64 block w-full rounded border bg-white py-1 leading-6 text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 ltr:pl-3 ltr:pr-10 rtl:pl-10 rtl:pr-3" style="border: 1px solid #c3c2c2;">
                <button type="submit" class="btn btn-sm btn-primary" style="position: relative; left: -43px;"><svg xmlns="http://www.w3.org/2000/svg" style="color: gray;" class="lucide lucide-search w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg></button>
            </form>
        </div>
        </div>
        <a href="{{ route('tours.create') }}" class="btn btn-sm btn-primary button-style" style="font-weight: 400;">+ Создать тур</a>
    </div>

    <div class="bg-white border rounded shadow-sm overflow-hidden" style="font-family: 'Rubik'; font-weight: 300;">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3"><input type="checkbox" @click="toggleAll" :checked="isAllSelected" class="form-checkbox"></th>
                    <th class="p-3">
                        <a href="{{ route('tours.index', ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            ID @if(request('sort') === 'id') 
                                <span>{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </a>
                    </th>
                    <th class="p-3">Название</th>
                    <th class="p-3">Дата создания</th>
                    <th class="p-3">Статус</th>
                    <th class="p-3 text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tours as $tour)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3"><input type="checkbox" :value="{{ $tour->id }}" x-model="selected" class="form-checkbox"></td>
                        <td class="p-3">{{ $tour->id }}</td>
                        <td class="p-3">{{ $tour->title }}</td>
                        <td class="p-3">{{ $tour->created_at->format('d.m.Y') }}</td>
                        <td class="p-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                :class="{{ $tour->is_active ? "'bg-green-100 text-green-800'" : "'bg-red-100 text-red-800'" }}">
                                {{ $tour->is_active ? 'Активный' : 'Неактивный' }}
                            </span>
                        </td>
                        <td class="p-3 text-right flex justify-end gap-2">
                        <form action="{{ route('tours.toggleStatus', $tour) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" title="Изменить статус" class="relative inline-flex items-center h-6 rounded-full w-11 bg-gray-200 focus:outline-none">
                                <span class="sr-only">Toggle</span>
                                <span class="inline-block h-4 w-4 transform bg-white rounded-full shadow transition ease-in-out duration-200 {{ $tour->is_active ? 'translate-x-6 bg-green-500' : 'translate-x-1 bg-red-500' }}"></span>
                            </button>
                        </form>
                            <a href="{{ route('tours.edit', $tour) }}" title="Редактировать" style="align-items: center; display: flex;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings text-blue-600 hover:text-blue-700"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <form action="{{ route('tours.destroy', $tour) }}" method="POST" onsubmit="return confirm('Удалить тур?')"  style="align-items: center; display: flex;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Удалить">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 text-red-600 hover:text-red-700"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500">Нет туров.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@if ($tours->hasPages())
    <div class="flex items-center justify-between mt-6 px-4 py-3 bg-white text-sm text-gray-700">
        <div>
            Показано с {{ $tours->firstItem() }} по {{ $tours->lastItem() }} из {{ $tours->total() }}
        </div>

        <div class="flex items-center gap-1">
            {{-- Previous Page --}}
            @if ($tours->onFirstPage())
                <span class="px-3 py-1 rounded text-gray-400 cursor-not-allowed"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left-icon lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg></span>
            @else
                <a href="{{ $tours->previousPageUrl() }}" class="px-3 py-1 rounded text-blue-600 hover:bg-gray-100"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left-icon lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg></a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($tours->getUrlRange(1, $tours->lastPage()) as $page => $url)
                @if ($page == $tours->currentPage())
                    <span class="px-3 py-1 rounded border-blue-500 bg-blue-50 text-blue-600 font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1 rounded text-gray-700 hover:bg-gray-100">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page --}}
            @if ($tours->hasMorePages())
                <a href="{{ $tours->nextPageUrl() }}" class="px-3 py-1 rounded text-blue-600 hover:bg-gray-100"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right-icon lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></a>
            @else
                <span class="px-3 py-1 rounded text-gray-400 cursor-not-allowed"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right-icon lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
            @endif
        </div>
    </div>
@endif

<style>
.button-delete:hover {
    background-color: rgba(239, 246, 255, 0.38);
}
.button-delete {
    display: flex;
    cursor: pointer;
    align-items: center;
    column-gap: 0.25rem;
    --tw-border-opacity: 1;
    --tw-bg-opacity: 1;
    background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1));
    font-weight: 600;
    --tw-text-opacity: 1;
    color: rgb(220 38 38 / var(--tw-bg-opacity, 1));
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 0.15s;
    place-content: center;
    white-space: nowrap;
    border-radius: 0.2rem;
    border-width: 1.55px;
    border-color: rgb(220 38 38 / var(--tw-bg-opacity, 1));
    padding: 0.3rem 0.7rem;
    font-family: 'Rubik';
    font-size: 14px;
}

.button-style:hover {
    background-color: rgba(239, 246, 255, 0.38);
}
.button-style {
    display: flex;
    cursor: pointer;
    align-items: center;
    column-gap: 0.25rem;
    --tw-border-opacity: 1;
    --tw-bg-opacity: 1;
    background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1));
    font-weight: 600;
    --tw-text-opacity: 1;
    color: rgb(37 99 235 / var(--tw-text-opacity, 1));
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 0.15s;
    place-content: center;
    white-space: nowrap;
    border-radius: 0.2rem;
    border-width: 1.55px;
    border-color: rgb(37 99 235 / var(--tw-border-opacity, 1));
    padding: 0.3rem 0.7rem;
    font-family: 'Rubik';
    font-size: 14px;
}

th.p-3 {
    font-weight: 600;
    font-family: 'Raleway';
}
input.form-checkbox {
    border: 1px solid #bbb4b4;
    border-radius: 2px;
}

input::placeholder {
    color:  #c3c2c2;
    font-weight: 300;
    font-family: 'Rubik';
    font-size: 14px;
}
</style>
</div>

<script>
    function tourList() {
        return {
            selected: [],
            toggleAll(event) {
                this.selected = event.target.checked ? @json($tours->pluck('id')) : [];
            },
            get isAllSelected() {
                return this.selected.length === {{ $tours->count() }};
            },
            confirmMassDelete() {
                if (confirm('Вы уверены, что хотите удалить выбранные туры?')) {
                    alert('Массовое удаление не настроено — реализуйте через API или форму.');
                }
            }
        };
    }
</script>
@endsection
