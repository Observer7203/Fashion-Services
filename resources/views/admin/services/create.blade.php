@extends('layouts.admin')

@section('content')

<div class="container mx-auto w-full max-w-7xl py-8">
    <h1 class="text-xl mb-6 font-bold">Создание новой услуги</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 mb-4 rounded shadow">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('services.store') }}" method="POST"  enctype="multipart/form-data" class="space-y-6" x-data="serviceForm()">
        @csrf

        <!-- Две отдельные языковые колонки -->
        <div style="max-width:1600px;margin:0 auto;padding:40px 0; gap: 20px; display: grid;">
    <h1 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 28px;">Создание новой услуги</h1>
    <form action="{{ route('services.store') }}" method="POST">
        @csrf

        <div style="display:flex;gap:20px;">
            <!-- RU -->
            <div style="flex:1;background:#fff;border:1px solid #eee;border-radius:12px;padding:32px;">
                <h3 style="font-size: 1.1rem;font-weight:bold;margin-bottom:18px;">Русский</h3>
                <label>Заголовок RU *</label>
                <input type="text" name="title_ru" value="{{ old('title_ru') }}" required style="width:100%;margin-bottom:16px;">
                <label>Подзаголовок RU</label>
                <input type="text" name="subtitle_ru" value="{{ old('subtitle_ru') }}" style="width:100%;margin-bottom:16px;">
                <label>Краткое описание RU</label>
                <textarea name="short_description_ru" style="width:100%;margin-bottom:16px;">{{ old('short_description_ru') }}</textarea>
                <label>Описание RU</label>
                <textarea name="description_ru" rows="4" style="width:100%;">{{ old('description_ru') }}</textarea>
            </div>
            <!-- EN -->
            <div style="flex:1;background:#fff;border:1px solid #eee;border-radius:12px;padding:32px;">
                <h3 style="font-size: 1.1rem;font-weight:bold;margin-bottom:18px;">English</h3>
                <label>Title EN *</label>
                <input type="text" name="title_en" value="{{ old('title_en') }}" required style="width:100%;margin-bottom:16px;">
                <label>Subtitle EN</label>
                <input type="text" name="subtitle_en" value="{{ old('subtitle_en') }}" style="width:100%;margin-bottom:16px;">
                <label>Short Description EN</label>
                <textarea name="short_description_en" style="width:100%;margin-bottom:16px;">{{ old('short_description_en') }}</textarea>
                <label>Description EN</label>
                <textarea name="description_en" rows="4" style="width:100%;">{{ old('description_en') }}</textarea>
            </div>
        </div>

        <!-- Цена и валюта -->
        <div class="bg-white border rounded shadow p-6 animate-fade-in flex flex-col md:flex-row gap-6">
            <div class="w-full">
                <label class="block font-medium">Цена</label>
                <input type="number" step="0.01" name="price" class="form-input w-full" value="{{ old('price') }}" required>
            </div>
            <div class="w-full">
                <label class="block font-medium">Валюта</label>
                <select name="currency" class="form-select w-full" required>
                    <option value="€" {{ old('currency') == '€' ? 'selected' : '' }}>Евро (€)</option>
                    <option value="$" {{ old('currency') == '$' ? 'selected' : '' }}>Доллар ($)</option>
                    <option value="₸" {{ old('currency') == '₸' ? 'selected' : '' }}>Тенге (₸)</option>
                </select>
            </div>
        </div>

               <!-- Медиа блок (Bagisto style, исправлено) -->
<div class="bg-white border rounded shadow p-6 animate-fade-in">
    <h2 class="text-lg font-semibold mb-4">Images</h2>
    <div class="flex flex-wrap gap-4">
        <!-- Add Image Cards -->
        @foreach(['main'=>'Main', 'detail1'=>'Image 1', 'detail2'=>'Image 2', 'detail3'=>'Image 3', 'detail4'=>'Image 4', 'banner'=>'Banner'] as $type=>$label)
            <div class="flex flex-col items-center border border-dashed border-[#A2A8B5] rounded-lg bg-[#F8FAFB] p-4 w-[140px] h-[120px] relative rounded border border-dashed">
                <input type="file" name="media[{{ $type }}]" accept="image/*"
                    class="absolute inset-0 opacity-0 cursor-pointer z-10"
                    onchange="showPreview(this, '{{ $type }}-preview')" />
                <div id="{{ $type }}-preview" class="flex items-center justify-center h-full w-full">
                    <div class="flex flex-col items-center justify-center w-full h-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A2A8B5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-icon lucide-image"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        <span class="block text-xs text-gray-600 mt-1">Add {{ $label }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="text-lg font-semibold my-4">Videos</h2>
    <div class="flex flex-wrap gap-4">
        <div class="flex flex-col items-center border-2 border-dashed border-[#A2A8B5] rounded-lg bg-[#F8FAFB] p-4 w-[140px] h-[120px] relative rounded border border-dashed">
            <input type="file" name="media[video]" accept="video/mp4,video/webm,video/mkv"
                class="absolute inset-0 opacity-0 cursor-pointer z-10"
                onchange="showVideoPreview(this, 'video-preview')" />
            <div id="video-preview" class="flex items-center justify-center h-full w-full">
                <div class="flex flex-col items-center justify-center w-full h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A2A8B5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-youtube-icon lucide-youtube"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/></svg>
                    <span class="block text-xs text-gray-600 mt-1">Add Video</span>
                </div>
            </div>
        </div>
    </div>
</div>




        <!-- Дополнительные опции -->
        <div class="bg-white border rounded shadow p-6 animate-fade-in">
            <h2 class="text-lg font-bold mb-4 flex justify-between items-center">Дополнительные опции
                <button type="button" @click="addOption()" class="btn btn-success">+ Добавить опцию</button>
            </h2>
            <template x-for="(option, index) in options" :key="index">
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 8px;">
                <input
                    type="text"
                    :name="'options['+index+'][title_en]'"
                    x-model="option.title_en"
                    class="form-input"
                    placeholder="Title EN"
                    required
                    style="flex:1;"
                >
                <input
                    type="text"
                    :name="'options['+index+'][title_ru]'"
                    x-model="option.title_ru"
                    class="form-input"
                    placeholder="Заголовок RU"
                    required
                    style="flex:1;"
                >
                <input
                    type="number"
                    :name="'options['+index+'][price]'"
                    x-model="option.price"
                    class="form-input"
                    placeholder="Цена"
                    step="0.01"
                    style="width: 120px;"
                    required
                >
                <button type="button" @click="removeOption(index)" style="color:#e3342f;font-size:22px;background:transparent;border:none;">&times;</button>
            </div>
        </template>
        </div>

        <!-- Что включено -->
        <div class="bg-white border rounded shadow p-6 animate-fade-in">
            <h2 class="text-lg font-bold mb-4 flex justify-between items-center">Что включено
                <button type="button" @click="addInclude()" class="btn btn-success">+ Добавить</button>
            </h2>
            <template x-for="(inc, index) in includes" :key="index">
                <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 8px;">
                    <input type="text" :name="'includes['+index+'][title_en]'" x-model="inc.title_en" class="form-input" placeholder="Include EN" required style="flex:1;">
                    <input type="text" :name="'includes['+index+'][title_ru]'" x-model="inc.title_ru" class="form-input" placeholder="Включено RU" required style="flex:1;">
                    <button type="button" @click="removeInclude(index)" style="color:#e3342f;font-size:22px;background:transparent;border:none;">&times;</button>
                </div>
            </template>
        </div>

        <!-- Тип резервации -->
        <div class="bg-white border rounded shadow p-6">
            <h2 class="text-lg font-bold mb-2">Тип резервации</h2>
            <select name="reservation_type_id" class="form-select w-full">
                <option value="">Без типа</option>
                @foreach(\App\Models\ReservationType::all() as $type)
                    <option value="{{ $type->id }}" {{ old('reservation_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Submit -->
        <div class="flex justify-start">
            <button type="submit" class="btn px-6 py-3 mt-6 button-style" style="width: fit-content; height: fit-content;">Сохранить услугу</button>
        </div>
    </form>
</div>

<style>
.form-input, .form-textarea, .form-select {
    border-color: #cccdcf;
    border-radius: 4px;
    padding: 0.5rem 1rem;
}
.btn.btn-success {
    color: black;
    border-radius: 4px;
    padding: 0.4rem 1.2rem;
    font-weight: 600;
    font-size: 1rem;
}

.form-input[type="file"] {
    border: 1.5px dashed #d5d6dc;
    background: #f6faff;
    border-radius: 8px;
    padding: 1.3rem 0.6rem;
    cursor: pointer;
    width: 200px;
}
.form-input[type="file"]:hover {
    border-color: #377dfc;
}

input[type="file"]::-webkit-file-upload-button { display: none; }
input[type="file"]::file-selector-button { display: none; }

.images-row {
  display: flex;
  flex-wrap: wrap;
  gap: 32px;          /* Отступы между карточками */
}

.image-block {
  border: 1px solid #d3d3d3;
  border-radius: 12px;
  padding: 24px 16px;
  width: 170px;       /* Можно ширину подогнать под дизайн */
  background: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: box-shadow 0.2s;
  box-shadow: 0 3px 14px 0 rgba(0,0,0,0.06);
}
.image-block:hover {
  box-shadow: 0 8px 24px 0 rgba(0,0,0,0.14);
  border-color: #aaa;
}




.form-input, .form-textarea, .form-select, .form-multiselect {
    border-color: #cccdcf;
    border-radius: 4px;
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
    border-radius: 0.375rem;
    border-width: 1px;
    border-color: rgb(37 99 235 / var(--tw-border-opacity, 1));
    padding: 0.375rem 0.75rem;
}

</style>

<script>
function serviceForm() {
    return {
        options: [],
        includes: [],
        addOption() {
            this.options.push({title_en: '', title_ru: '', price: ''});
        },
        removeOption(index) {
            this.options.splice(index, 1);
        },
        addInclude() {
            this.includes.push({title_en: '', title_ru: ''});
        },
        removeInclude(index) {
            this.includes.splice(index, 1);
        },
    }
}
</script>
<script>
    function showPreview(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width:110px;max-height:110px;border-radius:8px;border:1px solid #eee;">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function showVideoPreview(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.innerHTML = `<video src="${e.target.result}" controls style="max-width:110px;max-height:110px;border-radius:8px;border:1px solid #eee;"></video>`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
    <script>
        function showPreview(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width:70px;max-height:70px;border-radius:7px;box-shadow:0 2px 8px #ccc;">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function showVideoPreview(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = `<video src="${e.target.result}" controls style="max-width:80px;max-height:80px;border-radius:7px;box-shadow:0 2px 8px #ccc;"></video>`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script>
        
@endsection
