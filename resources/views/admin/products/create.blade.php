@extends('layouts.admin')

@section('content')
<div class="container py-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Добавить товар</h1>

    <form method="POST" action="{{ route('products.store') }}" id="product-form">
        @csrf

        <!-- Тип товара -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Тип *</label>
            <select name="type" id="product-type" class="form-select w-full" required>
                <option value="">Выберите тип</option>
                <option value="jewelry" {{ old('type')=='jewelry'?'selected':'' }}>Украшение</option>
                <option value="wear" {{ old('type')=='wear'?'selected':'' }}>Винтажная одежда</option>
                <option value="service" {{ old('type')=='service'?'selected':'' }}>Услуга</option>
                <option value="tour" {{ old('type')=='tour'?'selected':'' }}>Тур</option>
            </select>
        </div>

        <!-- Связи: услуга/тур -->
        <div class="mb-4" id="service-block" style="display:none;">
            <label class="block mb-1 font-semibold">Услуга</label>
            <select name="service_id" class="form-select w-full">
                <option value="">—</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->title ?? $service->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4" id="tour-block" style="display:none;">
            <label class="block mb-1 font-semibold">Тур</label>
            <select name="tour_id" class="form-select w-full">
                <option value="">—</option>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}" {{ old('tour_id') == $tour->id ? 'selected' : '' }}>{{ $tour->title ?? $tour->name }}</option>
                @endforeach
            </select>
        </div>

       <!-- Название -->
<div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block mb-1 font-semibold">Название (RU)</label>
        <input type="text" name="title[ru]" value="{{ old('title.ru', $product->title['ru'] ?? '') }}" class="form-input w-full" required>
    </div>
    <div>
        <label class="block mb-1 font-semibold">Название (EN)</label>
        <input type="text" name="title[en]" value="{{ old('title.en', $product->title['en'] ?? '') }}" class="form-input w-full" required>
    </div>
</div>



<!-- Краткое описание -->
<div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block mb-1 font-semibold">Краткое описание (RU)</label>
        <input type="text" name="short_description[ru]" value="{{ old('short_description.ru', $product->short_description['ru'] ?? '') }}" class="form-input w-full">
    </div>
    <div>
        <label class="block mb-1 font-semibold">Краткое описание (EN)</label>
        <input type="text" name="short_description[en]" value="{{ old('short_description.en', $product->short_description['en'] ?? '') }}" class="form-input w-full">
    </div>
</div>



<!-- Описание -->
<div class="mb-4">
    <label class="block mb-1 font-semibold">Описание (RU)</label>
    <textarea name="description[ru]" class="form-input w-full" rows="4">{{ old('description.ru', $product->description['ru'] ?? '') }}</textarea>
</div>
<div class="mb-4">
    <label class="block mb-1 font-semibold">Описание (EN)</label>
    <textarea name="description[en]" class="form-input w-full" rows="4">{{ old('description.en', $product->description['en'] ?? '') }}</textarea>
</div>


        <!-- Цена и количество -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Цена *</label>
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Количество</label>
            <input type="number" min="0" name="stock" value="{{ old('stock', 0) }}" class="form-input w-full">
        </div>

        <!-- Галерея (просто ссылки через запятую, можно доработать как file-upload позже) -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Галерея (drag & drop, фото/видео)</label>
            <div id="dropzone-area" class="dropzone"></div>
            <input type="hidden" name="media" id="media">
        </div>
        

        <!-- Атрибуты для одежды -->
        <div class="mb-4" id="wear-attrs" style="display:none;">
            <label class="block mb-1 font-semibold">Размеры (через запятую)</label>
            <input type="text" name="attributes[sizes]" value="{{ old('attributes.sizes') }}" class="form-input w-full">
            <label class="block mb-1 font-semibold mt-2">Пол</label>
            <select name="attributes[gender]" class="form-select w-full">
                <option value="">—</option>
                <option value="male" {{ old('attributes.gender')=='male'?'selected':'' }}>Мужской</option>
                <option value="female" {{ old('attributes.gender')=='female'?'selected':'' }}>Женский</option>
                <option value="unisex" {{ old('attributes.gender')=='unisex'?'selected':'' }}>Unisex</option>
            </select>
            <label class="block mb-1 font-semibold mt-2">Цвета (через запятую)</label>
            <input type="text" name="attributes[colors]" value="{{ old('attributes.colors') }}" class="form-input w-full">
        </div>

        <!-- Характеристики для украшений и одежды -->
        <div class="mb-4" id="chars-block" style="display:none;">
            <label class="block mb-1 font-semibold">Характеристики (каждая с новой строки)</label>
            <textarea name="attributes[chars]" class="form-input w-full" rows="3">{{ old('attributes.chars') }}</textarea>
        </div>

        <!-- Статус -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Статус</label>
            <select name="status" class="form-select w-full">
                <option value="active" {{ old('status')=='active'?'selected':'' }}>Активен</option>
                <option value="draft" {{ old('status')=='draft'?'selected':'' }}>Черновик</option>
                <option value="hidden" {{ old('status')=='hidden'?'selected':'' }}>Скрыт</option>
            </select>
        </div>

        <button type="submit" id="submit-button" class="btn btn-primary">Сохранить</button>                      
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
<script>
    Dropzone.autoDiscover = false;
    
    let uploadedFiles = [];
    
    const dz = new Dropzone("#dropzone-area", {
        url: '/admin/media/upload',
        paramName: "file",
        maxFilesize: 25,
        acceptedFiles: "image/*,video/*",
        addRemoveLinks: true,
        dictDefaultMessage: "Перетащите файлы сюда или кликните",
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    
                success: function (file, response) {
            uploadedFiles.push(response.url);
            console.log('File uploaded:', response.url); // 👈 Должно отображаться
            syncMediaField();
        },  
    
        removedfile: function (file) {
            const url = file.xhr ? JSON.parse(file.xhr.response).url : file.name;
            uploadedFiles = uploadedFiles.filter(f => f !== url);
            syncMediaField();
            file.previewElement.remove();
        }
    });
    
    // 👇 Функция, которая вручную вставляет JSON в скрытое поле
    function syncMediaField() {
        const mediaField = document.getElementById('media');
        if (mediaField) {
            mediaField.value = JSON.stringify(uploadedFiles);
        }
    }
    
    // ⛔ Блокируем submit, если файлы ещё загружаются
    document.getElementById('product-form').addEventListener('submit', function (e) {
        const uploading = dz.getUploadingFiles().length;
    
        syncMediaField(); // 💥 ВСТАВИТЬ ПЕРЕД ОТПРАВКОЙ ФОРМЫ
    
        if (uploading > 0) {
            e.preventDefault();
            document.getElementById('submit-button').disabled = true;
    
            dz.on("queuecomplete", function () {
                syncMediaField(); // 💥 ЕЩЁ РАЗ ПЕРЕД ПОВТОРНЫМ SUBMIT
                document.getElementById('submit-button').disabled = false;
                document.getElementById('product-form').submit();
            });
    
            console.log("⏳ Ждём загрузки всех файлов...");
        }
    });
    </script>
        
@endsection
