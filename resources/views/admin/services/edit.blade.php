@extends('layouts.admin')

@section('content')
<div class="container mx-auto w-full max-w-7xl py-8">
    <h1 class="text-xl mb-6 font-bold">Редактировать услугу</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 mb-4 rounded shadow">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('services.update', $service) }}" class="space-y-6" x-data="serviceEditForm()">
        @csrf
        @method('PUT')

        <!-- Две отдельные языковые колонки -->
        <div style="max-width:1600px;margin:0 auto;padding:40px 0; gap: 20px; display: grid;">
            <div style="display:flex;gap:20px;">
                <!-- RU -->
                <div style="flex:1;background:#fff;border:1px solid #eee;border-radius:12px;padding:32px;">
                    <h3 style="font-size: 1.1rem;font-weight:bold;margin-bottom:18px;">Русский</h3>
                    <label>Заголовок RU *</label>
                    <input type="text" name="title_ru" value="{{ old('title_ru', $service->getTranslation('title', 'ru')) }}" required style="width:100%;margin-bottom:16px;">
                    <label>Подзаголовок RU</label>
                    <input type="text" name="subtitle_ru" value="{{ old('subtitle_ru', $service->getTranslation('subtitle', 'ru')) }}" style="width:100%;margin-bottom:16px;">
                    <label>Краткое описание RU</label>
                    <textarea name="short_description_ru" style="width:100%;margin-bottom:16px;">{{ old('short_description_ru', $service->getTranslation('short_description', 'ru')) }}</textarea>
                    <label>Описание RU</label>
                    <textarea name="description_ru" rows="4" style="width:100%;">{{ old('description_ru', $service->getTranslation('description', 'ru')) }}</textarea>
                </div>
                <!-- EN -->
                <div style="flex:1;background:#fff;border:1px solid #eee;border-radius:12px;padding:32px;">
                    <h3 style="font-size: 1.1rem;font-weight:bold;margin-bottom:18px;">English</h3>
                    <label>Title EN *</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $service->getTranslation('title', 'en')) }}" required style="width:100%;margin-bottom:16px;">
                    <label>Subtitle EN</label>
                    <input type="text" name="subtitle_en" value="{{ old('subtitle_en', $service->getTranslation('subtitle', 'en')) }}" style="width:100%;margin-bottom:16px;">
                    <label>Short Description EN</label>
                    <textarea name="short_description_en" style="width:100%;margin-bottom:16px;">{{ old('short_description_en', $service->getTranslation('short_description', 'en')) }}</textarea>
                    <label>Description EN</label>
                    <textarea name="description_en" rows="4" style="width:100%;">{{ old('description_en', $service->getTranslation('description', 'en')) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Цена и валюта (на всю ширину) -->
        <div class="bg-white border rounded shadow p-6 animate-fade-in flex flex-col md:flex-row gap-6">
            <div class="w-full">
                <label class="block font-medium">Цена</label>
                <input type="number" step="0.01" name="price" class="form-input w-full" value="{{ old('price', $service->price) }}" required>
            </div>
            <div class="w-full">
                <label class="block font-medium">Валюта</label>
                <select name="currency" class="form-select w-full" required>
                    <option value="€" {{ old('currency', $service->currency) == '€' ? 'selected' : '' }}>Евро (€)</option>
                    <option value="$" {{ old('currency', $service->currency) == '$' ? 'selected' : '' }}>Доллар ($)</option>
                    <option value="₸" {{ old('currency', $service->currency) == '₸' ? 'selected' : '' }}>Тенге (₸)</option>
                </select>
            </div>
        </div>

        <!-- Медиа -->
        <div class="bg-white border rounded shadow p-6 animate-fade-in">
            <h2 class="text-lg font-semibold mb-4">Медиа</h2>
            <textarea name="media[]" class="form-textarea w-full" rows="2" placeholder="Вставьте ссылки через Enter">{{ is_array($service->media) ? implode("\n", $service->media) : '' }}</textarea>
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
                    <option value="{{ $type->id }}" {{ old('reservation_type_id', $service->reservation_type_id) == $type->id ? 'selected' : '' }}>
                        {{ $type->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-start">
            <button type="submit" class="btn px-6 py-3 mt-6 button-style" style="width: fit-content; height: fit-content;">Обновить услугу</button>
        </div>
    </form>
</div>

<script>
function serviceEditForm() {
    return {
        options: {!! old('options')
            ? json_encode(old('options'))
            : $service->options->map(fn($o) => [
                'title_en' => is_array($o->title) ? ($o->title['en'] ?? '') : $o->getTranslation('title', 'en'),
                'title_ru' => is_array($o->title) ? ($o->title['ru'] ?? '') : $o->getTranslation('title', 'ru'),
                'price' => $o->price,
            ])->values() !!},
        includes: {!! old('includes')
            ? json_encode(old('includes'))
            : $service->includes->map(fn($i) => [
                'title_en' => is_array($i->title) ? ($i->title['en'] ?? '') : (is_string($i->title) ? $i->title : ''),
                'title_ru' => is_array($i->title) ? ($i->title['ru'] ?? '') : (is_string($i->title) ? $i->title : ''),
            ])->values() !!},
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
@endsection
