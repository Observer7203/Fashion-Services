@extends('layouts.admin')

@section('content')

<div class="container mx-auto py-8" x-data="tourForm()">
    <h1 class="text-xl mb-6 font-bold">Создание нового тура</h1>

    <form action="{{ route('tours.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-6">
        @csrf
            @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc pl-6 text-red-500">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- Левая секция 3/5 -->
    <div class="md:w-2/3 space-y-6">
        <!-- Основная информация -->
            <h2 class="text-lg mb-4">Основная информация о туре</h2>

            <div class="flex gap-6">
    <!-- RU -->
    <div class="flex-1 bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
        <h3 class="text-lg font-bold mb-4">Русский</h3>
        <label class="block font-medium mb-1">Название (RU)*</label>
        <input type="text" name="title_ru" class="form-input w-full mb-4" required>
        <label class="block font-medium mb-1">Подзаголовок (RU)</label>
        <input type="text" name="subtitle_ru" class="form-input w-full mb-4">
        <label class="block font-medium mb-1">Краткое описание (RU)</label>
        <textarea name="short_description_ru" class="form-textarea w-full mb-4" rows="3"></textarea>
        <label class="block font-medium mb-1">Описание (RU)</label>
        <textarea name="description_ru" class="form-textarea w-full" rows="5"></textarea>
    </div>
    <!-- EN -->
    <div class="flex-1 bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
        <h3 class="text-lg font-bold mb-4">English</h3>
        <label class="block font-medium mb-1">Title (EN)*</label>
        <input type="text" name="title_en" class="form-input w-full mb-4" required>
        <label class="block font-medium mb-1">Subtitle (EN)</label>
        <input type="text" name="subtitle_en" class="form-input w-full mb-4">
        <label class="block font-medium mb-1">Short Description (EN)</label>
        <textarea name="short_description_en" class="form-textarea w-full mb-4" rows="3"></textarea>
        <label class="block font-medium mb-1">Description (EN)</label>
        <textarea name="description_en" class="form-textarea w-full" rows="5"></textarea>
    </div>
</div>

        

        <!-- Итоговая цена 
        <div class="bg-yellow-50 border rounded shadow p-6 text-xl font-bold text-green-700 animate-fade-in">
            Итоговая цена тура: <span x-text="totalPriceFormatted()"></span>
        </div>-->

        <div class="bg-white border rounded shadow p-6 animate-fade-in">
            <h2 class="text-lg font-bold mb-4 flex justify-between items-center" style="padding-left: 16px; padding-right: 16px;">Пакеты
                <button type="button" @click="addPackage()" class="btn btn-success">+ Добавить пакет</button>
            </h2>

            <template x-for="(packageItem, index) in packages" :key="index">
                <div class="bg-white bg-gray-50 border rounded p-6 mb-4">
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

                        <!-- Внутри шаблона пакета -->
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

    <div class="media-section mb-8 bg-white border rounded shadow p-6 animate-fade-in">
            <h2 class="text-lg font-bold mb-4 flex justify-between items-center" style="padding-left: 16px; padding-right: 16px;">Медиа
            </h2>
    <div class="grid grid-cols-5 gap-4 w-full" style="display: flex; flex-wrap: wrap;">
        <!-- Основная картинка -->
        <div class="media-upload-cell flex flex-col items-center">
            <label class="media-upload-inner cursor-pointer w-full flex flex-col items-center justify-center border-2 border-dashed border-[#C8CCD6] rounded-xl aspect-square min-h-[110px] bg-white relative">
                <input type="file" name="main_image" accept="image/*"
                    class="hidden" @change="previewMedia($event, 'mainImage')">
                <template x-if="mainImage.preview">
                    <img :src="mainImage.preview" class="object-cover w-full h-full rounded-xl" style="border-radius: 12px;" />
                </template>
                <template x-if="!mainImage.preview">
                    <div class="flex flex-col items-center justify-center h-full py-6">
                        <span class="mb-1">
                            <!-- SVG Image icon -->
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#A2A8B5" stroke-width="1.2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        </span>
                        <span class="text-xs text-gray-400 font-medium">Основная картинка</span>
                    </div>
                </template>
                <button type="button" @click="removeMedia('mainImage')" x-show="mainImage.preview"
                    class="media-remove absolute top-1 right-1 bg-white rounded-full border border-gray-200 text-red-400 w-6 h-6 flex items-center justify-center text-lg">×</button>
            </label>
        </div>
        <!-- Основное видео -->
        <div class="media-upload-cell flex flex-col items-center">
            <label class="media-upload-inner cursor-pointer w-full flex flex-col items-center justify-center border-2 border-dashed border-[#C8CCD6] rounded-xl aspect-square min-h-[110px] bg-white relative">
                <input type="file" name="main_video" accept="video/*" class="hidden" @change="previewMedia($event, 'mainVideo')">
                <template x-if="mainVideo.preview">
                    <video :src="mainVideo.preview" style="border-radius: 12px;" class="object-cover w-full h-full rounded-xl" controls></video>
                </template>
                <template x-if="!mainVideo.preview">
                    <div class="flex flex-col items-center justify-center h-full py-6">
                        <span class="mb-1">
                            <!-- SVG Video icon -->
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#A2A8B5" stroke-width="1.2"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/></svg>
                        </span>
                        <span class="text-xs text-gray-400 font-medium">Основное видео</span>
                    </div>
                </template>
                <button type="button" @click="removeMedia('mainVideo')" x-show="mainVideo.preview"
                    class="media-remove absolute top-1 right-1 bg-white rounded-full border border-gray-200 text-red-400 w-6 h-6 flex items-center justify-center text-lg">×</button>
            </label>
        </div>
        <!-- Баннер -->
        <div class="media-upload-cell flex flex-col items-center">
            <label class="media-upload-inner cursor-pointer w-full flex flex-col items-center justify-center border-2 border-dashed border-[#C8CCD6] rounded-xl aspect-square min-h-[110px] bg-white relative">
                <input type="file" name="banner" accept="image/*" class="hidden" @change="previewMedia($event, 'bannerImage')">
                <template x-if="bannerImage.preview">
                    <img :src="bannerImage.preview" style="border-radius: 12px;" class="object-cover w-full h-full rounded-xl" />
                </template>
                <template x-if="!bannerImage.preview">
                    <div class="flex flex-col items-center justify-center h-full py-6">
                        <span class="mb-1">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#A2A8B5" stroke-width="1.2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        </span>
                        <span class="text-xs text-gray-400 font-medium">Баннер</span>
                    </div>
                </template>
                <button type="button" @click="removeMedia('bannerImage')" x-show="bannerImage.preview"
                    class="media-remove absolute top-1 right-1 bg-white rounded-full border border-gray-200 text-red-400 w-6 h-6 flex items-center justify-center text-lg">×</button>
            </label>
        </div>
        <!-- Фон хлебных крошек -->
        <div class="media-upload-cell flex flex-col items-center">
            <label class="media-upload-inner cursor-pointer w-full flex flex-col items-center justify-center border-2 border-dashed border-[#C8CCD6] rounded-xl aspect-square min-h-[110px] bg-white relative">
                <input type="file" name="breadcrumbs_bg" accept="image/*" class="hidden" @change="previewMedia($event, 'breadcrumbsBg')">
                <template x-if="breadcrumbsBg.preview">
                    <img :src="breadcrumbsBg.preview" style="border-radius: 12px;" class="object-cover w-full h-full rounded-xl" />
                </template>
                <template x-if="!breadcrumbsBg.preview">
                    <div class="flex flex-col items-center justify-center h-full py-6">
                        <span class="mb-1">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#A2A8B5" stroke-width="1.2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        </span>
                        <span class="text-xs text-gray-400 font-medium">Фон хлебных крошек</span>
                    </div>
                </template>
                <button type="button" @click="removeMedia('breadcrumbsBg')" x-show="breadcrumbsBg.preview"
                    class="media-remove absolute top-1 right-1 bg-white rounded-full border border-gray-200 text-red-400 w-6 h-6 flex items-center justify-center text-lg">×</button>
            </label>
        </div>
        <!-- Галерея -->
        <div class="media-upload-cell flex items-center" style="display: flex; flex-direction: row; gap: 20px; align-items: baseline;">
            <label class="media-upload-inner cursor-pointer w-full flex flex-col items-center justify-center border-2 border-dashed border-[#C8CCD6] rounded-xl aspect-square min-h-[110px] bg-white relative">
                <input type="file" name="media_gallery[]" multiple accept="image/*,video/*" class="hidden" @change="previewGallery($event)">
                <div class="flex flex-col items-center justify-center h-full py-6">
                    <span class="mb-1">
                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#A2A8B5" stroke-width="1.2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    </span>
                    <span class="text-xs text-gray-400 font-medium">Галерея</span>
                </div>
            </label>
        </div>
        <!-- Галерея: картинки по строкам -->
            <div class="w-full mt-2 grid grid-cols-3 gap-2" style="display: flex; flex-wrap: wrap; gap: 20px;">
                <template x-for="(media, idx) in gallery" :key="idx">
                    <div class="relative group gallery-thumb">
                        <template x-if="media.file && media.file.type.startsWith('image')">
                            <img :src="media.preview" class="object-cover w-full h-[72px] rounded-xl" />
                        </template>
                        <template x-if="media.file && media.file.type.startsWith('video')">
                            <video :src="media.preview" class="object-cover w-full h-[72px] rounded-xl" controls></video>
                        </template>
                        <button type="button" @click="removeGallery(idx)"
                                class="media-remove absolute top-1 right-1 bg-white rounded-full border border-gray-200 text-red-400 w-6 h-6 flex items-center justify-center text-lg">×</button>
                    </div>
                </template>
            </div>
    </div>
</div>

<style>
/* Класс только если нет Tailwind, иначе можно не использовать */
.gallery-thumb {
    border-radius: 12px;
    border: 1.5px dashed #D2D6DC;
    background: #FAFBFC;
    position: relative;
    overflow: hidden;
    width: 106.8px;
    height: 106.8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: border-color 0.18s;
}
.gallery-thumb img, .gallery-thumb video {
    object-fit: cover;
    width: 100%;
    height: 100%;
    border-radius: 12px;
}

.media-section {
    margin-bottom: 36px;
}
.media-upload-cell {
    min-width: 130px;
    min-height: 130px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.media-upload-inner {
    width: 110px;
    height: 110px;
    min-width: 110px;
    min-height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed #C8CCD6;
    background: #fff;
    border-radius: 16px;
    position: relative;
    transition: box-shadow 0.2s;
}
.media-upload-inner:hover {
    box-shadow: 0 2px 12px 0 rgba(80,98,138,0.05), 0 1.5px 4px 0 rgba(80,98,138,0.09);
    border-color: #97B8F2;
}
.media-upload-inner svg {
    margin-bottom: 8px;
    display: block;
}
.media-upload-inner span {
    color: #88909E;
    font-size: 12px;
    font-weight: 500;
    text-align: center;
}
.media-remove {
    position: absolute;
    top: 4px;
    right: 4px;
    cursor: pointer;
    font-size: 20px;
    z-index: 5;
    background: #fff;
    border: 1px solid #eee;
}
@media (max-width: 900px) {
    .media-section .grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
@media (max-width: 640px) {
    .media-section .grid {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}




</style>

<style>
.media-uploader { display: flex; flex-direction: column; align-items: center; }
.media-label { font-size: 0.92rem; margin-bottom: 4px; color: #222; }
.media-slot {
    width: 90px; height: 90px; border: 2px dashed #d4d4d8;
    display: flex; align-items: center; justify-content: center;
    border-radius: 12px; cursor: pointer; background: #fafafa;
    margin-bottom: 6px;
}
.media-add-icon { width: 32px; height: 32px; display: block; background: url('data:image/svg+xml;utf8,<svg fill="gray" height="32" viewBox="0 0 24 24" width="32" xmlns="http://www.w3.org/2000/svg"><path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z"></path></svg>') center center no-repeat; }
.media-preview { width: 90px; height: 90px; object-fit: cover; border-radius: 12px; }
.media-remove-btn { margin-top: 2px; background: #fff; color: #e53e3e; border: none; border-radius: 50%; font-size: 1.2rem; width: 24px; height: 24px; cursor: pointer; position: absolute; right: -10px; top: -10px; }
</style>

        <!-- Дополнительные опции -->
           <!-- Дополнительные опции -->
            <div class="bg-white border rounded shadow p-6 animate-fade-in">
                <h2 class="text-lg font-bold mb-4 flex justify-between items-center" style="padding-left: 16px; padding-right: 16px;">
                    Дополнительные опции
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
        <!-- Индивидуальные предпочтения
        <div class="col-span-1 animate-fade-in">
            <h2 class="text-lg font-bold mb-4 flex justify-between items-center" style="padding-left: 16px; padding-right: 16px;">Индивидуальные предпочтения
                <button type="button" @click="addPreference()" class="btn btn-success">+ Добавить предпочтение</button>
            </h2>

            <template x-for="(pref, index) in preferences" :key="index">
                <div class="bg-white bg-gray-50 border rounded p-6 mb-4 shadow">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-medium">Предпочтение <span x-text="index + 1"></span></h3>
                        <button type="button" @click="removePreference(index)" class="btn btn-sm btn-danger">Удалить</button>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <div>
                            <label class="block text-sm">Название предпочтения</label>
                            <input type="text" :name="'preferences['+index+'][title]'" class="form-input w-full" x-model="pref.title">
                        </div>

                        <div>
                            <label class="block text-sm">Дополнительная стоимость</label>
                            <input type="number" :name="'preferences['+index+'][extra_cost]'" step="0.01" class="form-input w-full" x-model="pref.extra_cost" @input="calculateTotal()">
                        </div>
                    </div>
                </div>
            </template>
        </div>-->
        <!-- Правая секция 2/5 -->
        <div class="md:w-1/3 space-y-6">
            {{-- FAQ --}}
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
            {{-- Сезоны --}}
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
        </div>
        <div class="bg-white border rounded shadow p-6">
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
                <!-- Submit -->
        <div class="col-span-3 flex justify-start">
            <button type="submit" class="btn btn-primary px-6 py-3 mt-6 button-style" style="width: fit-content; height: fit-content;">Сохранить тур</button>
        </div>
    </form>
</div>

<style>
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
document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#season_from", { dateFormat: "Y-m-d" });
    flatpickr("#season_to", { dateFormat: "Y-m-d" });
});
</script>
<script>
function tourForm() {
    return {
        // медиа
        mainImage: { preview: null, file: null },
        mainVideo: { preview: null, file: null },
        bannerImage: { preview: null, file: null },
        breadcrumbsBg: { preview: null, file: null },
        gallery: [], // [{ preview, file }]

        // Preview для одиночных
        previewMedia(event, role) {
            let file = event.target.files[0];
            if (!file) return;
            let reader = new FileReader();
            reader.onload = e => {
                this[role] = { preview: e.target.result, file };
            };
            reader.readAsDataURL(file);
        },
        removeMedia(role) {
            this[role] = { preview: null, file: null };
        },

        // Галерея: загрузить несколько файлов
        previewGallery(event) {
            let files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let reader = new FileReader();
                reader.onload = e => {
                    this.gallery.push({ preview: e.target.result, file });
                };
                reader.readAsDataURL(file);
            }
        },
        removeGallery(idx) {
            this.gallery.splice(idx, 1);
        },

        // Остальное как у тебя (без изменений)
        packages: [{ title_ru: '', title_en: '', price: 0, currency: '€', includes: [{ru: '', en: ''}], places: [{ru: '', en: ''}], events: [{ru: '', en: ''}] }],
        options: [{ title_ru: '', title_en: '', price: 0 }],
        preferences: [{ title: '', extra_cost: 0 }],
        seasons: [],
        locations: [{ru: '', en: ''}],
        frequencies: [{ru: '', en: ''}],
        faqs: [{ru: '', en: ''}],
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
        addPackage() {
            this.packages.push({
                title_ru: '', title_en: '', price: 0, currency: '€',
                includes: [{ru: '', en: ''}],
                places: [{ru: '', en: ''}],
                events: [{ru: '', en: ''}]
            });
            this.calculateTotal();
        },
        addInclude(pkgIndex) { this.packages[pkgIndex].includes.push({ru: '', en: ''}); },
        removeInclude(pkgIndex, includeIndex) { this.packages[pkgIndex].includes.splice(includeIndex, 1); },
        removePackage(index) { this.packages.splice(index, 1); this.calculateTotal(); },
        addOption() { this.options.push({ title_ru: '', title_en: '', price: 0 }); this.calculateTotal(); },
        removeOption(index) { this.options.splice(index, 1); this.calculateTotal(); },
        addPlace(pkgIdx) { this.packages[pkgIdx].places.push({ru: '', en: ''}); },
        removePlace(pkgIdx, placeIdx) { this.packages[pkgIdx].places.splice(placeIdx, 1); },
        addEvent(pkgIdx) { this.packages[pkgIdx].events.push({ru: '', en: ''}); },
        removeEvent(pkgIdx, eventIdx) { this.packages[pkgIdx].events.splice(eventIdx, 1); },
        addLocation() { this.locations.push({ru: '', en: ''}); },
        removeLocation(idx) { this.locations.splice(idx, 1); },
        addFrequency() { this.frequencies.push({ru: '', en: ''}); },
        removeFrequency(idx) { this.frequencies.splice(idx, 1); },
        addFaq() { this.faqs.push({ru: '', en: ''}); },
        removeFaq(index) { this.faqs.splice(index, 1); },
        calculateTotal() {
            let total = 0;
            this.packages.forEach(p => total += parseFloat(p.price) || 0);
            this.options.forEach(o => total += parseFloat(o.price) || 0);
            this.preferences.forEach(p => total += parseFloat(p.extra_cost) || 0);
            this.totalPrice = total;
        },
        totalPrice: 0,
        totalPriceFormatted() {
            return this.totalPrice.toFixed(2) + ' €';
        }
    }
}
</script>
@endsection
