@extends('layouts.admin')

@section('content')

<div class="container mx-auto py-8" x-data="tourForm()">
    <h1 class="text-xl mb-6 font-bold">Создание нового тура</h1>

    <form action="{{ route('tours.store') }}" method="POST" class="flex flex-col md:flex-row gap-6">
        @csrf
        <!-- Левая секция 3/5 -->
    <div class="md:w-2/3 space-y-6">
        <!-- Основная информация -->
        <div class="bg-white border rounded shadow p-6 animate-fade-in">
            <h2 class="text-lg mb-4">Основная информация о туре</h2>

            <div class="space-y-4">
                <div>
                    <label class="block font-medium">Название *</label>
                    <input type="text" name="title" class="form-input w-full" required>
                </div>

                <div>
                    <label class="block font-medium">Подзаголовок</label>
                    <input type="text" name="subtitle" class="form-input w-full">
                </div>

                <div>
                    <label class="block font-medium">Краткое описание</label>
                    <textarea name="short_description" class="form-textarea w-full" rows="3"></textarea>
                </div>

                <div>
                    <label class="block font-medium">Подробное описание</label>
                    <textarea name="description" class="form-textarea w-full" rows="6"></textarea>
                </div>
            </div>
        </div>

        <!-- Итоговая цена 
        <div class="bg-yellow-50 border rounded shadow p-6 text-xl font-bold text-green-700 animate-fade-in">
            Итоговая цена тура: <span x-text="totalPriceFormatted()"></span>
        </div>-->

        <!-- Пакеты -->
            <div class="bg-white border rounded shadow p-6 animate-fade-in">
            <h2 class="text-lg font-bold mb-4 flex justify-between items-center" style="padding-left: 16px; padding-right: 16px;">Пакеты
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

                        <!-- Внутри шаблона пакета -->
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

                                                <!-- Места -->
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

                        <!-- Мероприятия -->
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
            <h2 class="text-lg font-bold mb-4 flex justify-between items-center" style="padding-left: 16px; padding-right: 16px;">Дополнительные опции
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
                        <div class="mb-2">
                            <input type="text" :name="'faq['+index+']'" x-model="faqs[index]" class="form-input w-full mb-2" placeholder="Вопрос и ответ (в одной строке)">
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
            packages: [{ title: '', price: 0, currency: '€', includes: [] }],
            options: [{ title: '', price: 0 }],
            preferences: [{ title: '', extra_cost: 0 }],
            seasons: [],
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
                        removeSeason(index) {
                this.seasons.splice(index, 1);
            },
            addPackage() { this.packages.push({ title: '', price: 0, currency: '€',includes: [], places: [], events: [] }); this.calculateTotal(); },
            addInclude(pkgIndex) { this.packages[pkgIndex].includes.push(''); },
            removeInclude(pkgIndex, includeIndex) { this.packages[pkgIndex].includes.splice(includeIndex, 1); },
            removePackage(index) { this.packages.splice(index, 1); this.calculateTotal(); },
            addOption() { this.options.push({ title: '', price: 0 }); this.calculateTotal(); },
            removeOption(index) { this.options.splice(index, 1); this.calculateTotal(); },
            /*addPreference() { this.preferences.push({ title: '', extra_cost: 0 }); this.calculateTotal(); },
            removePreference(index) { this.preferences.splice(index, 1); this.calculateTotal(); },*/
            addPlace(pkgIndex) { this.packages[pkgIndex].places.push(''); },
            removePlace(pkgIndex, placeIndex) { this.packages[pkgIndex].places.splice(placeIndex, 1); },
            addEvent(pkgIndex) { this.packages[pkgIndex].events.push(''); },
            removeEvent(pkgIndex, eventIndex) { this.packages[pkgIndex].events.splice(eventIndex, 1); },
            faqs: [''],
            addFaq() { this.faqs.push(''); },
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
