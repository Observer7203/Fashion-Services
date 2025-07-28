@extends('layouts.admin')

@section('content')


<div class="container mx-auto max-w-7xl py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">{{ __('admin.services_list') }}</h1>
        <a href="{{ route('services.create') }}" class="btn btn-sm btn-primary button-style" style="font-weight: 400;">
            {{ __('admin.create_service') }}
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border rounded shadow-sm overflow-hidden" style="font-family: 'Rubik'; font-weight: 300;">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3">{{ __('admin.id') }}</th>
                    <th class="p-3">{{ __('admin.title') }}</th>
                    <th class="p-3">{{ __('admin.price') }}</th>
                    <th class="p-3">{{ __('admin.currency') }}</th>
                    <th class="p-3">{{ __('admin.created_at') }}</th>
                    <th class="p-3 text-right">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $service->id }}</td>
                        <td class="p-3">
                            {{-- Для переводимых полей используем getTranslation --}}
                            {{ $service->getTranslation('title', app()->getLocale()) }}
                        </td>
                        <td class="p-3">{{ $service->price }}</td>
                        <td class="p-3">{{ $service->currency ?? '€' }}</td>
                        <td class="p-3">{{ $service->created_at?->format('d.m.Y') }}</td>
                        <td class="p-3 text-right flex justify-end gap-2">
                            <a href="{{ route('services.edit', $service) }}" title="{{ __('admin.edit') }}" style="align-items: center; display: flex;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings text-blue-600 hover:text-blue-700"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST" onsubmit="return confirm('{{ __('admin.delete') }}?')" style="align-items: center; display: flex;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="{{ __('admin.delete') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 text-red-600 hover:text-red-700"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">{{ __('admin.no_services') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($services->hasPages())
        <div class="flex items-center justify-between mt-6 px-4 py-3 bg-white text-sm text-gray-700">
            <div>
                {{ __('admin.showing_from_to', [
                    'from' => $services->firstItem(),
                    'to' => $services->lastItem(),
                    'total' => $services->total()
                ]) }}
            </div>
            <div class="flex items-center gap-1">
                {{-- Pagination --}}
                @if ($services->onFirstPage())
                    <span class="px-3 py-1 rounded text-gray-400 cursor-not-allowed">←</span>
                @else
                    <a href="{{ $services->previousPageUrl() }}" class="px-3 py-1 rounded text-blue-600 hover:bg-gray-100">←</a>
                @endif
                @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                    @if ($page == $services->currentPage())
                        <span class="px-3 py-1 rounded border-blue-500 bg-blue-50 text-blue-600 font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 rounded text-gray-700 hover:bg-gray-100">{{ $page }}</a>
                    @endif
                @endforeach
                @if ($services->hasMorePages())
                    <a href="{{ $services->nextPageUrl() }}" class="px-3 py-1 rounded text-blue-600 hover:bg-gray-100">→</a>
                @else
                    <span class="px-3 py-1 rounded text-gray-400 cursor-not-allowed">→</span>
                @endif
            </div>
        </div>
    @endif

    <style>
    .button-style:hover {
        background-color: rgba(239, 246, 255, 0.38);
    }
    .button-style {
        display: flex;
        cursor: pointer;
        align-items: center;
        column-gap: 0.25rem;
        background-color: rgb(255 255 255 / 1);
        font-weight: 600;
        color: rgb(37 99 235 / 1);
        transition: all 0.15s cubic-bezier(0.4,0,0.2,1);
        border-radius: 0.2rem;
        border-width: 1.55px;
        border-color: rgb(37 99 235 / 1);
        padding: 0.3rem 0.7rem;
        font-family: 'Rubik';
        font-size: 14px;
        left: -110px;
        top: -3px;
        position: relative;
    }
    th.p-3 { font-weight: 600; font-family: 'Raleway'; }
    input.form-checkbox { border: 1px solid #bbb4b4; border-radius: 2px; }
    input::placeholder {
        color:  #c3c2c2;
        font-weight: 300;
        font-family: 'Rubik';
        font-size: 14px;
    }
    </style>
</div>
@endsection
