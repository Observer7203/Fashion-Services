@extends('layouts.admin')

@section('content')

@php
    \Log::info('PACKAGES JSON:', [
        'old' => old('packages'),
        'db' => !empty($tour->packages) ? $tour->packages->map(function($p) {
            return [
                'title_ru' => $p->getTranslation('title', 'ru'),
                'title_en' => $p->getTranslation('title', 'en'),
                'price'    => $p->price,
                'currency' => $p->currency,
                'includes' => $p->includes->map(fn($i) => [
                    'ru' => $i->getTranslation('content', 'ru'),
                    'en' => $i->getTranslation('content', 'en'),
                ]),
                'places' => $p->places->map(fn($pl) => [
                    'ru' => $pl->getTranslation('name', 'ru'),
                    'en' => $pl->getTranslation('name', 'en'),
                ]),
            ];
        }) : 'empty'
    ]);
@endphp

@php
    $packages = $tour->packages ?? collect();

    \Log::info('PACKAGES JSON:', [
        'packages_count' => $packages->count(),
        'includes_first' => optional($packages->first()?->includes)?->pluck('id'),
    ]);
@endphp


<div class="container mx-auto py-8" x-data="editTourForm()" x-init="console.log('PACKAGES ===>', packages)">
    <h1 class="text-xl mb-6 font-bold">Редактировать тур: {{ $tour->title_ru }}</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 mb-4 rounded shadow">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tours.update', $tour) }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-6">
        @csrf
        @method('PUT')

        <!-- Левая секция 3/5 -->
        <div class="md:w-2/3 space-y-6">

            <!-- Основная информация -->
            <h2 class="text-lg mb-4">Основная информация о туре</h2>
            <div class="flex gap-6">
                <!-- RU -->
            <div class="flex-1 bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold mb-4">Русский</h3>
                <label class="block font-medium mb-1">Название (RU)*</label>
                <input type="text" name="title_ru" class="form-input w-full mb-4" required value="{{ old('title_ru', $tour->getTranslation('title', 'ru')) }}">
                <label class="block font-medium mb-1">Подзаголовок (RU)</label>
                <input type="text" name="subtitle_ru" class="form-input w-full mb-4" value="{{ old('subtitle_ru', $tour->getTranslation('subtitle', 'ru')) }}">
                <label class="block font-medium mb-1">Краткое описание (RU)</label>
                <textarea name="short_description_ru" class="form-textarea w-full mb-4" rows="3">{{ old('short_description_ru', $tour->getTranslation('short_description', 'ru')) }}</textarea>
                <label class="block font-medium mb-1">Описание (RU)</label>
                <textarea name="description_ru" class="form-textarea w-full" rows="5">{{ old('description_ru', $tour->getTranslation('description', 'ru')) }}</textarea>
            </div>

            <!-- EN -->
            <div class="flex-1 bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold mb-4">English</h3>
                <label class="block font-medium mb-1">Title (EN)*</label>
                <input type="text" name="title_en" class="form-input w-full mb-4" required value="{{ old('title_en', $tour->getTranslation('title', 'en')) }}">
                <label class="block font-medium mb-1">Subtitle (EN)</label>
                <input type="text" name="subtitle_en" class="form-input w-full mb-4" value="{{ old('subtitle_en', $tour->getTranslation('subtitle', 'en')) }}">
                <label class="block font-medium mb-1">Short Description (EN)</label>
                <textarea name="short_description_en" class="form-textarea w-full mb-4" rows="3">{{ old('short_description_en', $tour->getTranslation('short_description', 'en')) }}</textarea>
                <label class="block font-medium mb-1">Description (EN)</label>
                <textarea name="description_en" class="form-textarea w-full" rows="5">{{ old('description_en', $tour->getTranslation('description', 'en')) }}</textarea>
            </div>
            </div>

            <!-- МЕДИА -->
            <div class="media-section mb-8 bg-white border rounded shadow p-6 animate-fade-in">
                <h2 class="text-lg font-bold mb-4 flex justify-between items-center">Медиа</h2>
                <div class="grid grid-cols-5 gap-4 w-full" style="display: flex; flex-wrap: wrap;">
                    <!-- Основная картинка -->
                    <div class="media-upload-cell flex flex-col items-center">
                        <label class="media-upload-inner cursor-pointer w-full flex flex-col items-center justify-center border-2 border-dashed border-[#C8CCD6] rounded-xl aspect-square min-h-[110px] bg-white relative">
                            <input type="file" name="main_image" accept="image/*" name="main_image" class="hidden" @change="previewMedia($event, 'mainImage')">
                            <template x-if="mainImage.preview">
                                <img :src="mainImage.preview" class="object-cover w-full h-full rounded-xl" style="border-radius: 12px;" />
                            </template>
                            <template x-if="!mainImage.preview && '{{ $tour->mainImageUrl }}'">
                                <img src="{{ $tour->mainImageUrl }}" class="object-cover w-full h-full rounded-xl" />
                            </template>
                            <span class="text-xs text-gray-400 font-medium" x-show="!mainImage.preview && '{{ $tour->mainImageUrl }}' == ''">Основная картинка</span>
                            <button type="button" @click="removeMedia('mainImage')" x-show="mainImage.preview" class="media-remove absolute top-1 right-1 bg-white rounded-full border border-gray-200 text-red-400 w-6 h-6 flex items-center justify-center text-lg">×</button>
                        </label>
                    </div>
                    <!-- Основное видео -->
                    <div class="media-upload-cell flex flex-col items-center">
                        <label class="media-upload-inner cursor-pointer w-full flex flex-col items-center justify-center border-2 border-dashed border-[#C8CCD6] rounded-xl aspect-square min-h-[110px] bg-white relative">
                            <input type="file" name="main_video" accept="video/*" name="main_video" class="hidden" @change="previewMedia($event, 'mainVideo')">
                            <template x-if="mainVideo.preview">
                                <video :src="mainVideo.preview" style="border-radius: 12px;"  class="object-cover w-full h-full rounded-xl" controls></video>
                            </template>
                            <template x-if="!mainVideo.preview && '{{ $tour->mainVideoUrl }}'">
                                <video src="{{ $tour->mainVideoUrl }}" class="object-cover w-full h-full rounded-xl" controls></video>
                            </template>
                            <span class="text-xs text-gray-400 font-medium" x-show="!mainVideo.preview && '{{ $tour->mainVideoUrl }}' == ''">Основное видео</span>
                            <button type="button" @click="removeMedia('mainVideo')" x-show="mainVideo.preview" class="media-remove absolute top-1 right-1 bg-white rounded-full border border-gray-200 text-red-400 w-6 h-6 flex items-center justify-center text-lg">×</button>
                        </label>
                    </div>
                    <!-- Баннер -->
                    <div class="media-upload-cell flex flex-col items-center">
                        <label class="media-upload-inner cursor-pointer w-full flex flex-col items-center justify-center border-2 border-dashed border-[#C8CCD6] rounded-xl aspect-square min-h-[110px] bg-white relative">
                            <input type="file" name="banner" accept="image/*" name="banner_image" class="hidden" @change="previewMedia($event, 'bannerImage')">
                            <template x-if="bannerImage.preview">
                                <img :src="bannerImage.preview" style="border-radius: 12px;"  class="object-cover w-full h-full rounded-xl" />
                            </template>
                            <template x-if="!bannerImage.preview && '{{ $tour->bannerImageUrl }}'">
                                <img src="{{ $tour->bannerImageUrl }}" class="object-cover w-full h-full rounded-xl" />
                            </template>
                            <span class="text-xs text-gray-400 font-medium" x-show="!bannerImage.preview && '{{ $tour->bannerImageUrl }}' == ''">Баннер</span>
                            <button type="button" @click="removeMedia('bannerImage')" x-show="bannerImage.preview" class="media-remove absolute top-1 right-1 bg-white rounded-full border border-gray-200 text-red-400 w-6 h-6 flex items-center justify-center text-lg">×</button>
                        </label>
                    </div>
                    <!-- Фон хлебных крошек -->
                    <div class="media-upload-cell flex flex-col items-center">
                        <label class="media-upload-inner cursor-pointer w-full flex flex-col items-center justify-center border-2 border-dashed border-[#C8CCD6] rounded-xl aspect-square min-h-[110px] bg-white relative">
                            <input type="file" name="breadcrumbs_bg" accept="image/*" name="breadcrumbs_bg" class="hidden" @change="previewMedia($event, 'breadcrumbsBg')">
                            <template x-if="breadcrumbsBg.preview">
                                <img :src="breadcrumbsBg.preview"  style="border-radius: 12px;"  class="object-cover w-full h-full rounded-xl" />
                            </template>
                            <template x-if="!breadcrumbsBg.preview && '{{ $tour->breadcrumbsBgUrl }}'">
                                <img src="{{ $tour->breadcrumbsBgUrl }}" class="object-cover w-full h-full rounded-xl" />
                            </template>
                            <span class="text-xs text-gray-400 font-medium" x-show="!breadcrumbsBg.preview && '{{ $tour->breadcrumbsBgUrl }}' == ''">Фон хлебных крошек</span>
                            <button type="button" @click="removeMedia('breadcrumbsBg')" x-show="breadcrumbsBg.preview" class="media-remove absolute top-1 right-1 bg-white rounded-full border border-gray-200 text-red-400 w-6 h-6 flex items-center justify-center text-lg">×</button>
                        </label>
                    </div>
                    <!-- Галерея -->
                    <div class="media-upload-cell flex items-center" style="display: flex; flex-direction: row; gap: 20px; align-items: baseline;">
                        <label class="media-upload-inner cursor-pointer w-full flex flex-col items-center justify-center border-2 border-dashed border-[#C8CCD6] rounded-xl aspect-square min-h-[110px] bg-white relative">
                            <input type="file" name="media_gallery[]" multiple accept="image/*,video/*" name="gallery[]" class="hidden" @change="previewGallery($event)">
                            <div class="flex flex-col items-center justify-center h-full py-6">
                                <span class="mb-1">
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#A2A8B5" stroke-width="1.2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                </span>
                                <span class="text-xs text-gray-400 font-medium">Галерея</span>
                            </div>
                        </label>
                    </div>
                    <!-- Галерея: превью -->
                    <div class="w-full mt-2 grid grid-cols-3 gap-2" style="display: flex; flex-wrap: wrap; gap: 20px;">
                        <template x-for="(media, idx) in gallery" :key="idx">
                            <div class="relative group gallery-thumb">
                                <template x-if="media.type && media.type.startsWith('image')">
                                    <img :src="media.preview" class="object-cover w-full h-[72px] rounded-xl" />
                                </template>
                                <template x-if="media.type && media.type.startsWith('video')">
                                    <video :src="media.preview" class="object-cover w-full h-[72px] rounded-xl" controls></video>
                                </template>
                                <button type="button" @click="removeGallery(idx)" class="media-remove absolute top-1 right-1 bg-white rounded-full border border-gray-200 text-red-400 w-6 h-6 flex items-center justify-center text-lg">×</button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Пакеты -->
            <div class="bg-white border rounded shadow p-6 animate-fade-in">
                <h2 class="text-lg font-bold mb-4 flex justify-between items-center">Пакеты
                    <button type="button" @click="addPackage()" class="btn btn-success">+ Добавить пакет</button>
                </h2>
                <template x-for="(packageItem, index) in packages" :key="index">
                    <div class="bg-white bg-gray-50 border rounded p-6 mb-4" x-show="packages.length > 0">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="block text-sm font-semibold mb-2">Пакет <span x-text="index + 1"></span></h3>
                            <button type="button" @click="removePackage(index)" class="btn btn-sm btn-danger">Удалить</button>
                        </div>
                        <div class="grid grid-cols-1 gap-3">
                            <label class="block text-sm font-semibold mb-2">Название пакета</label>
                            <div class="flex items-center gap-2 mt-1">
                                <input type="text" :name="'packages['+index+'][title_ru]'" class="form-input w-full" x-model="packageItem.title_ru" placeholder="RU">
                                <input type="text" :name="'packages['+index+'][title_en]'" class="form-input w-full" x-model="packageItem.title_en" placeholder="EN">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Цена</label>
                                <input type="number" :name="'packages['+index+'][price]'" step="0.01" class="form-input w-full" x-model="packageItem.price" @input="calculateTotal()">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Валюта</label>
                                <select :name="'packages['+index+'][currency]'" class="form-select w-full" x-model="packageItem.currency">
                                    <option value="€">€</option>
                                    <option value="$">$</option>
                                    <option value="₸">₸</option>
                                </select>
                            </div>
                            <!-- Включено -->
                            <div class="mt-4">
                                <label class="block text-sm font-semibold">Что включено</label>
                                <template x-for="(includeItem, idx) in packageItem.includes" :key="idx">
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="text" :name="'packages['+index+'][includes]['+idx+'][ru]'" class="form-input w-full" x-model="packageItem.includes[idx].ru" placeholder="RU">
                                        <input type="text" :name="'packages['+index+'][includes]['+idx+'][en]'" class="form-input w-full" x-model="packageItem.includes[idx].en" placeholder="EN">
                                        <button type="button" @click="removeInclude(index, idx)" class="text-red-500">✕</button>
                                    </div>
                                </template>
                                <button type="button" @click="addInclude(index)" class="text-blue-600 mt-2">+ Добавить пункт</button>
                            </div>
                            <!-- Места -->
                            <div class="mt-4">
                                <label class="block text-sm font-semibold">Места</label>
                                <template x-for="(placeItem, idx) in packageItem.places" :key="idx">
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="text" :name="'packages['+index+'][places]['+idx+'][ru]'" class="form-input w-full" x-model="packageItem.places[idx].ru" placeholder="RU">
                                        <input type="text" :name="'packages['+index+'][places]['+idx+'][en]'" class="form-input w-full" x-model="packageItem.places[idx].en" placeholder="EN">
                                        <button type="button" @click="removePlace(index, idx)" class="text-red-500">✕</button>
                                    </div>
                                </template>
                                <button type="button" @click="addPlace(index)" class="text-blue-600 mt-2">+ Добавить место</button>
                            </div>
                            <!-- Мероприятия -->
                            <div class="mt-4">
                                <label class="block text-sm font-semibold">Мероприятия</label>
                                <template x-for="(eventItem, idx) in packageItem.events" :key="idx">
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="text" :name="'packages['+index+'][events]['+idx+'][ru]'" class="form-input w-full" x-model="packageItem.events[idx].ru" placeholder="RU">
                                        <input type="text" :name="'packages['+index+'][events]['+idx+'][en]'" class="form-input w-full" x-model="packageItem.events[idx].en" placeholder="EN">
                                        <button type="button" @click="removeEvent(index, idx)" class="text-red-500">✕</button>
                                    </div>
                                </template>
                                <button type="button" @click="addEvent(index)" class="text-blue-600 mt-2">+ Добавить мероприятие</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Дополнительные опции -->
            <div class="bg-white border rounded shadow p-6 animate-fade-in">
                <h2 class="text-lg font-bold mb-4 flex justify-between items-center">Дополнительные опции
                    <button type="button" @click="addOption()" class="btn btn-success">+ Добавить опцию</button>
                </h2>
                <template x-for="(option, index) in options" :key="index">
                    <div class="bg-white bg-gray-50 border rounded p-6 mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-medium">Опция <span x-text="index + 1"></span></h3>
                            <button type="button" @click="removeOption(index)" class="btn btn-sm btn-danger">Удалить</button>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Название опции (RU)</label>
                                <input type="text" :name="'options['+index+'][title_ru]'" class="form-input w-full" x-model="option.title_ru">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Option Title (EN)</label>
                                <input type="text" :name="'options['+index+'][title_en]'" class="form-input w-full" x-model="option.title_en">
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="block text-sm font-semibold mb-2">Цена</label>
                            <input type="number" :name="'options['+index+'][price]'" step="0.01" class="form-input w-full" x-model="option.price" @input="calculateTotal()">
                        </div>
                    </div>
                </template>
            </div>


        <!-- Правая секция 2/5 -->
        <div class="md:w-1/3 space-y-6">
            <!-- FAQ -->
            <div class="bg-white border rounded shadow p-6">
                <h2 class="text-lg font-bold mb-2">FAQ</h2>
                <template x-for="(faq, index) in faqs" :key="index">
                    <div class="mb-2 flex gap-2">
                        <input type="text" :name="'faq_ru['+index+']'" x-model="faqs[index].ru" class="form-input w-full mb-2" placeholder="Вопрос и ответ RU">
                        <input type="text" :name="'faq_en['+index+']'" x-model="faqs[index].en" class="form-input w-full mb-2" placeholder="FAQ EN">
                        <button type="button" @click="removeFaq(index)" class="text-red-600 text-sm">Удалить</button>
                    </div>
                </template>
                <button type="button" @click="addFaq()" class="text-blue-600 text-sm">+ Добавить FAQ</button>
            </div>
            <!-- Сезоны -->
            <div class="bg-white border rounded shadow p-6">
                <h2 class="text-lg font-bold mb-4">Сезоны</h2>
                <div class="flex gap-4 mb-4">
                    <input type="text" id="season_from" class="form-input w-full" placeholder="С">
                    <input type="text" id="season_to" class="form-input w-full" placeholder="По">
                    <button type="button" class="btn btn-primary" @click="addSeason()">Добавить период</button>
                </div>
                <template x-for="(range, index) in seasons" :key="index">
                    <div class="flex justify-between items-center bg-gray-50 border p-2 mb-2 rounded">
                        <input type="hidden" :name="'seasons[' + index + '][start]'" :value="range.start_date">
                        <input type="hidden" :name="'seasons[' + index + '][end]'" :value="range.end_date">
                        <span x-text="range.start_date + ' → ' + range.end_date"></span>
                        <button type="button" class="text-red-600" @click="seasons.splice(index, 1)">✕</button>
                    </div>
                </template>
            </div>
            <!-- Локации -->
            <div class="bg-white border rounded shadow p-6" style="padding: 1.5rem;">
                <h4 class="text-lg font-bold mb-4">Локации</h4>
                <template x-for="(loc, idx) in locations" :key="idx">
                    <div class="flex items-center gap-2 mb-1">
                        <input type="text" :name="'locations['+idx+'][ru]'" x-model="locations[idx].ru" class="form-input w-full" placeholder="Локация RU">
                        <input type="text" :name="'locations['+idx+'][en]'" x-model="locations[idx].en" class="form-input w-full" placeholder="Location EN">
                        <button type="button" @click="removeLocation(idx)" class="text-red-500">✕</button>
                    </div>
                </template>
                <button type="button" @click="addLocation()" class="text-blue-600 mt-2">+ Добавить локацию</button>
            </div>
            <!-- Периодичность -->
            <div class="bg-white border rounded shadow p-6">
                <h4 class="text-lg font-bold mb-4">Периодичность (Frequency)</h4>
                <template x-for="(freq, idx) in frequencies" :key="idx">
                    <div class="flex items-center gap-2 mb-1">
                        <input type="text" :name="'frequencies['+idx+'][ru]'" x-model="frequencies[idx].ru" class="form-input w-full" placeholder="Периодичность RU">
                        <input type="text" :name="'frequencies['+idx+'][en]'" x-model="frequencies[idx].en" class="form-input w-full" placeholder="Frequency EN">
                        <button type="button" @click="removeFrequency(idx)" class="text-red-500">✕</button>
                    </div>
                </template>
                <button type="button" @click="addFrequency()" class="text-blue-600 mt-2">+ Добавить периодичность</button>
            </div>
        </div>

        <!-- Submit -->
        <div class="col-span-3 flex justify-start">
            <button type="submit" class="btn btn-primary px-6 py-3 mt-6 button-style" style="width: fit-content; height: fit-content;">Сохранить изменения</button>
        </div>
    </form>
</div>

{{-- Стили --}}
<style>
.form-input, .form-textarea, .form-select, .form-multiselect { border-color: #cccdcf; border-radius: 4px; }
.animate-fade-in {
    animation: fadeIn 0.5s ease-in-out;
}
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
.button-style:hover { background-color: rgba(239, 246, 255, 0.38); }
.button-style {
    display: flex; cursor: pointer; align-items: center; column-gap: 0.25rem;
    --tw-border-opacity: 1; --tw-bg-opacity: 1; background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1));
    font-weight: 600; --tw-text-opacity: 1; color: rgb(37 99 235 / var(--tw-text-opacity, 1));
    transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 0.15s;
    place-content: center; white-space: nowrap; border-radius: 0.375rem; border-width: 1px;
    border-color: rgb(37 99 235 / var(--tw-border-opacity, 1)); padding: 0.375rem 0.75rem;
}
.gallery-thumb { border-radius: 12px; border: 1.5px dashed #D2D6DC; background: #FAFBFC;
    position: relative; overflow: hidden; width: 106.8px; height: 106.8px; display: flex; align-items: center; justify-content: center; transition: border-color 0.18s; }
.gallery-thumb img, .gallery-thumb video { object-fit: cover; width: 100%; height: 100%; border-radius: 12px; }
.media-section { margin-bottom: 36px; }
.media-upload-cell { min-width: 130px; min-height: 130px; display: flex; flex-direction: column; align-items: center; }
.media-upload-inner { width: 110px; height: 110px; min-width: 110px; min-height: 110px; display: flex; align-items: center; justify-content: center; border: 2px dashed #C8CCD6; background: #fff; border-radius: 16px; position: relative; transition: box-shadow 0.2s; }
.media-upload-inner:hover { box-shadow: 0 2px 12px 0 rgba(80,98,138,0.05), 0 1.5px 4px 0 rgba(80,98,138,0.09); border-color: #97B8F2; }
.media-upload-inner svg { margin-bottom: 8px; display: block; }
.media-upload-inner span { color: #88909E; font-size: 12px; font-weight: 500; text-align: center; }
.media-remove { position: absolute; top: 4px; right: 4px; cursor: pointer; font-size: 20px; z-index: 5; background: #fff; border: 1px solid #eee; }
@media (max-width: 900px) { .media-section .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 640px) { .media-section .grid { grid-template-columns: repeat(1, minmax(0, 1fr)); } }
</style>

{{-- Скрипты --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#season_from", { dateFormat: "Y-m-d" });
    flatpickr("#season_to", { dateFormat: "Y-m-d" });
});

function editTourForm() {
    return {
        // --- МЕДИА ---
        mainImage: { preview: '{{ $tour->mainImageUrl }}', file: null },
        mainVideo: { preview: '{{ $tour->mainVideoUrl }}', file: null },
        bannerImage: { preview: '{{ $tour->bannerImageUrl }}', file: null },
        breadcrumbsBg: { preview: '{{ $tour->breadcrumbsBgUrl }}', file: null },
        gallery: [
            @if(isset($tour->gallery) && $tour->gallery->count())
                @foreach($tour->gallery as $media)
                    {
                        preview: "{{ $media->url }}",
                        file: null,
                        type: "{{ $media->type }}"
                    },
                @endforeach
            @endif
        ],

        // --- ПАКЕТЫ ---
        packages: {!! old('packages')
            ? json_encode(old('packages'))
            : (!empty($tour->packages) ? $tour->packages->map(function($p) {
                return [
                    'title_ru' => $p->getTranslation('title', 'ru'),
                    'title_en' => $p->getTranslation('title', 'en'),
                    'price' => $p->price ?? 0,
                    'currency' => $p->currency ?? '€',
                    'includes' => $p->includes->map(fn($i) => [
                        'ru' => $i->getTranslation('content', 'ru') ?? '',
                        'en' => $i->getTranslation('content', 'en') ?? ''
                    ])->toArray(),
                    'places' => $p->places->map(fn($pl) => [
                        'ru' => $pl->getTranslation('name', 'ru') ?? '',
                        'en' => $pl->getTranslation('name', 'en') ?? ''
                    ])->toArray(),
                    'events' => []
                ];
            })->values()->toJson() : '[]')
        !!},

        // --- ОПЦИИ ---
        options: {!! old('options')
            ? json_encode(old('options'))
            : (optional($tour->options)->count()
                ? $tour->options->map(function($o) {
                    return [
                        'title_en' => $o->getTranslation('title', 'en') ?? '',
                        'title_ru' => $o->getTranslation('title', 'ru') ?? '',
                        'price' => $o->price ?? 0,
                    ];
                })->toJson()
                : '[]'
            )
        !!},

            // --- FAQ ---
            faqs: {!! old('faq_ru')
                ? collect(old('faq_ru'))->map(function($v, $i) {
                    return ['ru' => $v, 'en' => old('faq_en')[$i] ?? ''];
                })->toJson()
                : (
                    $tour->hasTranslation('faq')
                        ? collect(array_map(null,
                                $tour->getTranslation('faq', 'ru') ?? [],
                                $tour->getTranslation('faq', 'en') ?? []
                            ))
                            ->map(fn($pair) => ['ru' => $pair[0] ?? '', 'en' => $pair[1] ?? ''])
                            ->toJson()
                        : '[]'
                )
            !!},



        

        // --- СЕЗОНЫ ---
        seasons: {!! old('seasons')
            ? json_encode(old('seasons'))
            : (optional($tour->seasons)->count()
                ? $tour->seasons->map(fn($s) => [
                    'start_date' => $s->start_date,
                    'end_date' => $s->end_date
                ])->toJson()
                : '[]')
        !!},

       // --- ЛОКАЦИИ ---
            locations: {!! json_encode(
                is_array(old('locations')) ? old('locations') :
                ( $tour->hasTranslation('locations')
                    ? collect(array_map(null,
                        $tour->getTranslation('locations', 'ru') ?? [],
                        $tour->getTranslation('locations', 'en') ?? [])
                    )->map(fn($pair) => ['ru' => $pair[0] ?? '', 'en' => $pair[1] ?? ''])
                    ->toArray()
                    : [])
            ) !!},


        // Если есть старые данные, используем их, иначе создаем пустой массив      


        // --- ПЕРИОДИЧНОСТЬ ---
            frequencies: {!! json_encode(
                is_array(old('frequencies')) ? old('frequencies') :
                ( $tour->hasTranslation('frequencies')
                    ? collect(array_map(null,
                        $tour->getTranslation('frequencies', 'ru') ?? [],
                        $tour->getTranslation('frequencies', 'en') ?? [])
                    )->map(fn($pair) => ['ru' => $pair[0] ?? '', 'en' => $pair[1] ?? ''])
                    ->toArray()
                    : [])
            ) !!},





        // --- Методы ---
        previewMedia(event, role) {
            let file = event.target.files[0];
            if (!file) return;
            let reader = new FileReader();
            reader.onload = e => { this[role] = { preview: e.target.result, file }; };
            reader.readAsDataURL(file);
        },
        removeMedia(role) { this[role] = { preview: null, file: null }; },
        previewGallery(event) {
            let files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let reader = new FileReader();
                reader.onload = e => { this.gallery.push({ preview: e.target.result, file }); };
                reader.readAsDataURL(file);
            }
        },
        removeGallery(idx) { this.gallery.splice(idx, 1); },

        addPackage() {
            this.packages.push({
                title_ru: '', title_en: '', price: 0, currency: '€',
                includes: [{ru:'',en:''}], places: [{ru:'',en:''}], events: [{ru:'',en:''}]
            });
            this.calculateTotal();
        },
        addInclude(pkgIdx) { this.packages[pkgIdx].includes.push({ru:'',en:''}); },
        removeInclude(pkgIdx, includeIdx) { this.packages[pkgIdx].includes.splice(includeIdx, 1); },
        addPlace(pkgIdx) { this.packages[pkgIdx].places.push({ru:'',en:''}); },
        removePlace(pkgIdx, placeIdx) { this.packages[pkgIdx].places.splice(placeIdx, 1); },
        addEvent(pkgIdx) { this.packages[pkgIdx].events.push({ru:'',en:''}); },
        removeEvent(pkgIdx, eventIdx) { this.packages[pkgIdx].events.splice(eventIdx, 1); },
        removePackage(idx) { this.packages.splice(idx, 1); this.calculateTotal(); },

        addOption() { this.options.push({ title_en: '', title_ru: '', price: 0 }); this.calculateTotal(); },
        removeOption(index) { this.options.splice(index, 1); this.calculateTotal(); },

        addFaq() { this.faqs.push({ru:'',en:''}); },
        removeFaq(index) { this.faqs.splice(index, 1); },

        addLocation() { this.locations.push({ru:'',en:''}); },
        removeLocation(idx) { this.locations.splice(idx, 1); },

        addFrequency() { this.frequencies.push({ru:'',en:''}); },
        removeFrequency(idx) { this.frequencies.splice(idx, 1); },

        addSeason() {
            const from = document.getElementById('season_from').value;
            const to = document.getElementById('season_to').value;
            if (from && to) {
                this.seasons.push({ start_date: from, end_date: to });
                document.getElementById('season_from').value = '';
                document.getElementById('season_to').value = '';
            } else {
                alert('Пожалуйста, выберите обе даты');
            }
        },
        removeSeason(index) { this.seasons.splice(index, 1); },

        calculateTotal() {
            let total = 0;
            this.packages.forEach(p => total += parseFloat(p.price) || 0);
            this.options.forEach(o => total += parseFloat(o.price) || 0);
            this.totalPrice = total;
        },
        totalPrice: 0,
        totalPriceFormatted() { return this.totalPrice.toFixed(2) + ' €'; },

        // --- Гарантия отображения пакета ---
        init() {
            if (!this.packages || this.packages.length === 0) {
                this.addPackage();
            }
        }
        
    }
}
</script>
@endsection
