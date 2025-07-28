@extends('layouts.admin')

@section('content')
<div class="container py-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Редактировать товар</h1>

    <pre style="background:#f3f3f3;padding:10px;border:1px solid #ccc;">
        {{ print_r($product->attributes, true) }}
    </pre>

    <pre>{{ print_r($product->title, true) }}</pre>

    
    <form method="POST" action="{{ route('products.update', $product) }}" id="product-form">
        @csrf
        @method('PUT')

        <!-- Тип товара -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Тип *</label>
            <select name="type" id="product-type" class="form-select w-full" required>
                <option value="">Выберите тип</option>
                <option value="jewelry" {{ old('type', $product->type)=='jewelry'?'selected':'' }}>Украшение</option>
                <option value="wear" {{ old('type', $product->type)=='wear'?'selected':'' }}>Винтажная одежда</option>
                <option value="service" {{ old('type', $product->type)=='service'?'selected':'' }}>Услуга</option>
                <option value="tour" {{ old('type', $product->type)=='tour'?'selected':'' }}>Тур</option>
            </select>
        </div>

        <!-- Связи -->
        <div class="mb-4" id="service-block" style="display:none;">
            <label class="block mb-1 font-semibold">Услуга</label>
            <select name="service_id" class="form-select w-full">
                <option value="">—</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id', $product->service_id) == $service->id ? 'selected' : '' }}>
                        {{ $service->title ?? $service->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4" id="tour-block" style="display:none;">
            <label class="block mb-1 font-semibold">Тур</label>
            <select name="tour_id" class="form-select w-full">
                <option value="">—</option>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}" {{ old('tour_id', $product->tour_id) == $tour->id ? 'selected' : '' }}>
                        {{ $tour->title ?? $tour->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Категория и подкатегория -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Категория (RU)</label>
            <input type="text" name="category[ru]" value="{{ old('category.ru', $product->category['ru'] ?? '') }}" class="form-input w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Категория (EN)</label>
            <input type="text" name="category[en]" value="{{ old('category.en', $product->category['en'] ?? '') }}" class="form-input w-full">
        </div>

        <!-- Название, описание, краткое описание -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-semibold">Название (RU) *</label>
            <input type="text" name="title[ru]" class="form-input w-full" value="{{ old('title.ru', $product->getTranslation('title', 'ru')) }}">
        </div>
        <div>
            <label class="block mb-1 font-semibold">Название (EN)</label>
            <input type="text" name="title[en]" class="form-input w-full" value="{{ old('title.en', $product->getTranslation('title', 'en')) }}">
        </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-semibold">Краткое описание (RU)</label>
            <textarea name="short_description[ru]" class="form-input w-full">{{ old('short_description.ru', $product->getTranslation('short_description', 'ru')) }}</textarea>
        </div>
        <div>
            <label class="block mb-1 font-semibold">Краткое описание (EN)</label>
            <textarea name="short_description[en]" class="form-input w-full">{{ old('short_description.en', $product->getTranslation('short_description', 'en')) }}</textarea>
        </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">    
        <div>
            <label class="block mb-1 font-semibold">Описание (RU)</label>
            <textarea name="description[ru]" class="form-input w-full">{{ old('description.ru', $product->getTranslation('description', 'ru')) }}</textarea>
        </div>
        <div>
            <label class="block mb-1 font-semibold">Описание (EN)</label>
            <textarea name="description[en]" class="form-input w-full">{{ old('description.en', $product->getTranslation('description', 'en')) }}</textarea>
        </div>
        </div>
        

        <!-- Цена и количество -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Цена *</label>
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Количество</label>
            <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" class="form-input w-full">
        </div>

        <!-- Галерея -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Галерея (Drag & Drop: изображения/видео)</label>
            <input type="hidden" name="media" id="media" value='@json(old("media", $product->media ?? []))'>
            <div id="media-dropzone" class="dropzone"></div>
            <div class="text-gray-500 text-xs mt-1">Перетащите изображения или видео в это поле</div>
        </div>
        
        <!-- Атрибуты для одежды -->
        <div class="mb-4" id="wear-attrs" style="display:none;">
            <label class="block mb-1 font-semibold">Размеры (через запятую)</label>
            <input type="text" name="attributes[sizes]" value="{{ old('attributes.sizes', data_get($product->attributes, 'sizes', '')) }}" class="form-input w-full">

            <label class="block mb-1 font-semibold mt-2">Пол</label>
            <select name="attributes[gender]" class="form-select w-full">
                <option value="">—</option>
                <option value="male" {{ old('attributes.gender', data_get($product->attributes, 'gender')) == 'male' ? 'selected' : '' }}>Мужской</option>
                <option value="female" {{ old('attributes.gender', data_get($product->attributes, 'gender')) == 'female' ? 'selected' : '' }}>Женский</option>
                <option value="unisex" {{ old('attributes.gender', data_get($product->attributes, 'gender')) == 'unisex' ? 'selected' : '' }}>Unisex</option>
            </select>

            <label class="block mb-1 font-semibold mt-2">Цвета (через запятую)</label>
            <input type="text" name="attributes[colors]" value="{{ old('attributes.colors', data_get($product->attributes, 'colors', '')) }}" class="form-input w-full">
        </div>

        <!-- Характеристики для украшений и одежды -->
        <div class="mb-4" id="chars-block" style="display:none;">
            <label class="block mb-1 font-semibold">Характеристики (каждая с новой строки)</label>
            <textarea name="attributes[chars]" class="form-input w-full" rows="3">{{ old('attributes.chars', $product->attributes['chars'] ?? '') }}</textarea>
        </div>

        <!-- Статус -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Статус</label>
            <select name="status" class="form-select w-full">
                <option value="active" {{ old('status', $product->status)=='active'?'selected':'' }}>Активен</option>
                <option value="draft" {{ old('status', $product->status)=='draft'?'selected':'' }}>Черновик</option>
                <option value="hidden" {{ old('status', $product->status)=='hidden'?'selected':'' }}>Скрыт</option>
            </select>
        </div>

        <button class="btn btn-primary">Сохранить</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Переключатели полей ---
        const typeSelect = document.getElementById('product-type');
        const wearAttrs = document.getElementById('wear-attrs');
        const charsBlock = document.getElementById('chars-block');
        const serviceBlock = document.getElementById('service-block');
        const tourBlock = document.getElementById('tour-block');
        function showFields() {
            const type = typeSelect.value;
            wearAttrs.style.display = type === 'wear' ? '' : 'none';
            charsBlock.style.display = (type === 'jewelry' || type === 'wear') ? '' : 'none';
            serviceBlock.style.display = type === 'service' ? '' : 'none';
            tourBlock.style.display = type === 'tour' ? '' : 'none';
        }
        typeSelect.addEventListener('change', showFields);
        showFields();
    
        // --- Dropzone ---
        Dropzone.autoDiscover = false;
        if (Dropzone.instances.length) Dropzone.instances.forEach(dz => dz.destroy());
    
        const dzElement = document.getElementById('media-dropzone');
        if (!dzElement || !window.Dropzone) return;
    
        let initialMedia = [];
        try {
            initialMedia = JSON.parse(document.getElementById('media').value || '[]');
        } catch (e) {
            console.error('Ошибка парсинга initialMedia:', e);
        }
    
        console.log('initialMedia:', initialMedia);
        let uploadedFiles = [...initialMedia];
    
        const dz = new Dropzone(dzElement, {
            url: '/admin/media/upload',
            paramName: "file",
            maxFilesize: 25,
            acceptedFiles: "image/*,video/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Перетащите файлы сюда или кликните",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            init: function () {
                initialMedia.forEach(url => {
                    const fullUrl = url.startsWith('/') ? window.location.origin + url : url;
                    const ext = fullUrl.split('.').pop().toLowerCase();
                    const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'].includes(ext);
                    const mockFile = {
                        name: fullUrl.split('/').pop(),
                        size: 12345,
                        dataURL: fullUrl,
                        url: fullUrl
                    };
                    this.emit("addedfile", mockFile);
                    if (isImage) {
                        this.emit("thumbnail", mockFile, fullUrl);
                    }
                    this.emit("complete", mockFile);
                });
            },
            success: function (file, response) {
                uploadedFiles.push(response.url);
                document.getElementById('media').value = JSON.stringify(uploadedFiles);
            },
            removedfile: function(file) {
                let fullUrl = file.xhr ? JSON.parse(file.xhr.response).url : (file.dataURL || file.url);
                let url = new URL(fullUrl, window.location.origin).pathname;

                console.log('Удаляемый файл:', url);

                if (!url) return;
                console.log('Удаляемый URL:', url, typeof url);
                fetch('/admin/media/delete', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ url: url })
                })
                .then(res => res.json())
                .then(data => console.log('Ответ от сервера:', data))
                .catch(err => console.error('Ошибка удаления:', err));

                uploadedFiles = uploadedFiles.filter(f => f !== url);
                document.getElementById('media').value = JSON.stringify(uploadedFiles);

                if (file.previewElement) file.previewElement.remove();
            }
        });
    });
    </script>
    
    
@endsection
