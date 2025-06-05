@extends('layouts.admin')

@section('content')

<div class="container mx-auto py-8" x-data="editTourForm()">
    <h1 class="text-xl mb-6 font-bold">Редактировать тур: {{ $tour->title }}</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 mb-4 rounded shadow">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tours.update', $tour) }}" method="POST" class="flex flex-col md:flex-row gap-6">
        @csrf
        @method('PUT')

        <!-- Левая секция 3/5 -->
        <div class="md:w-2/3 space-y-6">
            <!-- Основная информация -->
            <div class="bg-white border rounded shadow p-6 animate-fade-in">
                <h2 class="text-lg mb-4">Основная информация о туре</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block font-medium">Название *</label>
                        <input type="text" name="title" class="form-input w-full" required value="{{ old('title', $tour->title) }}">
                    </div>
                    <div>
                        <label class="block font-medium">Подзаголовок</label>
                        <input type="text" name="subtitle" class="form-input w-full" value="{{ old('subtitle', $tour->subtitle) }}">
                    </div>
                    <div>
                        <label class="block font-medium">Краткое описание</label>
                        <textarea name="short_description" class="form-textarea w-full" rows="3">{{ old('short_description', $tour->short_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block font-medium">Подробное описание</label>
                        <textarea name="description" class="form-textarea w-full" rows="6">{{ old('description', $tour->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Пакеты -->
            <div class="bg-white border rounded shadow p-6 animate-fade-in">
                <h2 class="text-lg font-bold mb-4 flex justify-between items-center">Пакеты
                    <button type="button" @click="addPackage()" class="btn btn-success">+ Добавить пакет</button>
                </h2>
                <template x-for="(packageItem, index) in packages" :key="index">
                    <div class="bg-white bg-gray-50 border rounded p-6 mb-4 shadow">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-medium">Пакет <span x-text="index + 1"></span></h3>
                            <button type="button" @click="removePackage(index)" class="btn btn-sm btn-danger">Удалить</button>
                        </div>
                        <div class="grid grid-cols-1 gap-3">
                            <div>
                                <label class="block text-sm">Название пакета</label>
                                <input type="text" :name="'packages['+index+'][title]'" class="form-input w-full" x-model="packageItem.title">
                            </div>
                            <div>
                                <label class="block text-sm">Цена</label>
                                <input type="number" :name="'packages['+index+'][price]'" step="0.01" class="form-input w-full" x-model="packageItem.price" @input="calculateTotal()">
                            </div>
                            <div>
                                <label class="block text-sm">Валюта</label>
                                <select :name="'packages['+index+'][currency]'" class="form-select w-full" x-model="packageItem.currency">
                                    <option value="€">€</option>
                                    <option value="$">$</option>
                                    <option value="₸">₸</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-semibold">Что включено</label>
                                <template x-for="(includeItem, idx) in packageItem.includes" :key="idx">
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="text" :name="'packages['+index+'][includes][]'" class="form-input w-full" x-model="packageItem.includes[idx]">
                                        <button type="button" @click="removeInclude(index, idx)" class="text-red-500">✕</button>
                                    </div>
                                </template>
                                <button type="button" @click="addInclude(index)" class="text-blue-600 mt-2">+ Добавить пункт</button>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-semibold">Места</label>
                                <template x-for="(placeItem, idx) in packageItem.places" :key="idx">
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="text" :name="'packages['+index+'][places][]'" class="form-input w-full" x-model="packageItem.places[idx]">
                                        <button type="button" @click="removePlace(index, idx)" class="text-red-500">✕</button>
                                    </div>
                                </template>
                                <button type="button" @click="addPlace(index)" class="text-blue-600 mt-2">+ Добавить место</button>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-semibold">Мероприятия</label>
                                <template x-for="(eventItem, idx) in packageItem.events" :key="idx">
                                    <div class="flex items-center gap-2 mt-1">
                                        <input type="text" :name="'packages['+index+'][events][]'" class="form-input w-full" x-model="packageItem.events[idx]">
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
                    <div class="bg-white bg-gray-50 border rounded p-6 mb-4 shadow">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-medium">Опция <span x-text="index + 1"></span></h3>
                            <button type="button" @click="removeOption(index)" class="btn btn-sm btn-danger">Удалить</button>
                        </div>
                        <div class="grid grid-cols-1 gap-3">
                            <div>
                                <label class="block text-sm">Название опции</label>
                                <input type="text" :name="'options['+index+'][title]'" class="form-input w-full" x-model="option.title">
                            </div>
                            <div>
                                <label class="block text-sm">Цена</label>
                                <input type="number" :name="'options['+index+'][price]'" step="0.01" class="form-input w-full" x-model="option.price" @input="calculateTotal()">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Правая секция 2/5 -->
        <div class="md:w-1/3 space-y-6">
            <div class="bg-white border rounded shadow p-6">
                <h2 class="text-lg font-bold mb-2">FAQ</h2>
                <template x-for="(faq, index) in faqs" :key="index">
                    <div class="mb-2">
                        <input type="text" :name="'faq['+index+']'" x-model="faqs[index]" class="form-input w-full mb-2" placeholder="Вопрос и ответ (в одной строке)">
                        <button type="button" @click="removeFaq(index)" class="text-red-600 text-sm">Удалить</button>
                    </div>
                </template>
                <button type="button" @click="addFaq()" class="text-blue-600 text-sm">+ Добавить FAQ</button>
            </div>
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

        <!-- Submit -->
        <div class="col-span-3 flex justify-start">
            <button type="submit" class="btn btn-primary px-6 py-3 mt-6 button-style" style="width: fit-content; height: fit-content;">Сохранить изменения</button>
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

function editTourForm() {
    return {
            packages: {!! old('packages') 
                ? json_encode(old('packages')) 
                : ($tour->packages ?? collect([]))->map(fn($p) => [
                    'title' => $p->title,
                    'price' => $p->price,
                    'currency' => $p->currency,
                    'includes' => $p->includes ? $p->includes->pluck('content')->toArray() : [],
                    'places' => $p->places ? $p->places->pluck('name')->toArray() : [],
                    'events' => $p->events ? $p->events->pluck('id')->toArray() : [], // лучше id!
                ])->toJson()
            !!},
        options: {!! old('options') 
            ? json_encode(old('options')) 
            : $tour->options->map(fn($o) => ['title' => $o->title, 'price' => $o->price])->toJson() 
        !!},
        faqs: {!! old('faq') 
            ? json_encode(old('faq')) 
            : ($tour->faq ? json_encode(json_decode($tour->faq, true)) : '[]') 
        !!},
        seasons: {!! old('seasons') 
            ? json_encode(old('seasons')) 
            : ($tour->seasons ? $tour->seasons->map(fn($s) => ['start_date' => $s->start, 'end_date' => $s->end])->toJson() : '[]') 
        !!},
        // Методы для динамического управления (копируй из tourForm)
        addPackage() { this.packages.push({ title: '', price: 0, currency: '€', includes: [], places: [], events: [] }); this.calculateTotal(); },
        addInclude(pkgIndex) { this.packages[pkgIndex].includes.push(''); },
        removeInclude(pkgIndex, includeIndex) { this.packages[pkgIndex].includes.splice(includeIndex, 1); },
        removePackage(index) { this.packages.splice(index, 1); this.calculateTotal(); },
        addPlace(pkgIndex) { this.packages[pkgIndex].places.push(''); },
        removePlace(pkgIndex, placeIndex) { this.packages[pkgIndex].places.splice(placeIndex, 1); },
        addEvent(pkgIndex) { this.packages[pkgIndex].events.push(''); },
        removeEvent(pkgIndex, eventIndex) { this.packages[pkgIndex].events.splice(eventIndex, 1); },
        options: {!! old('options') ? json_encode(old('options')) : $tour->options->map(fn($o) => ['title' => $o->title, 'price' => $o->price])->toJson() !!},
        addOption() { this.options.push({ title: '', price: 0 }); this.calculateTotal(); },
        removeOption(index) { this.options.splice(index, 1); this.calculateTotal(); },
        faqs: {!! old('faq') ? json_encode(old('faq')) : ($tour->faq ? json_encode(json_decode($tour->faq, true)) : '[]') !!},
        addFaq() { this.faqs.push(''); },
        removeFaq(index) { this.faqs.splice(index, 1); },
        seasons: {!! old('seasons') ? json_encode(old('seasons')) : ($tour->seasons ? $tour->seasons->map(fn($s) => ['start_date' => $s->start, 'end_date' => $s->end])->toJson() : '[]') !!},
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
        calculateTotal() {
            let total = 0;
            this.packages.forEach(p => total += parseFloat(p.price) || 0);
            this.options.forEach(o => total += parseFloat(o.price) || 0);
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
