@extends('layouts.app')

@section('content')
<div class="container max-w-3xl py-6" x-data="reservationForm()">
    <h1 class="text-xl font-bold mb-4">Создание бронирования</h1>

    <form method="POST" action="{{ route('reservations.store') }}">
        @csrf

        <!-- Тип бронирования -->
        <div class="mb-4">
            <label class="block text-sm font-medium">Тип бронирования</label>
            <select name="type_id" class="form-select w-full" x-model="selectedType" @change="fetchItems()" required>
                <option value="">— выберите —</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Выбор тура или услуги -->
        <template x-if="items.length > 0">
            <div class="mb-4">
                <label class="block text-sm font-medium">Выберите тур / услугу</label>
                <select name="tour_id" class="form-select w-full" x-model="selectedItem">
                    <option value="">— выберите —</option>
                    <template x-for="item in items" :key="item.id">
                        <option :value="item.id" x-text="item.title"></option>
                    </template>
                </select>
            </div>
        </template>

        <!-- Пакеты -->
        <template x-if="packages.length > 0">
            <div class="mb-4">
                <label class="block text-sm font-medium">Выберите пакет</label>
                <select name="tour_package_id" class="form-select w-full" x-model="selectedPackage" required>
                    <option value="">— выберите —</option>
                    <template x-for="pkg in packages" :key="pkg.id">
                        <option :value="pkg.id" x-text="pkg.title + ' — ' + pkg.price + ' ' + pkg.currency"></option>
                    </template>
                </select>
            </div>
        </template>

        <!-- Опции -->
        <template x-if="options.length > 0">
            <div class="mb-4">
                <label class="block text-sm font-medium">Дополнительные опции</label>
                <template x-for="opt in options" :key="opt.id">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" :value="opt.id" name="options[]" :id="'option-' + opt.id">
                        <label :for="'option-' + opt.id" x-text="opt.title + ' (+ ' + opt.price + ' ' + opt.currency + ')'"></label>
                    </div>
                </template>
            </div>
        </template>

        <!-- Предпочтения -->
        <template x-if="preferences.length > 0">
            <div class="mb-4">
                <label class="block text-sm font-medium">Индивидуальные предпочтения</label>
                <template x-for="pref in preferences" :key="pref.id">
                    <div class="flex flex-col gap-2 mb-2">
                        <label>
                            <input type="checkbox" :value="pref.id" name="preferences[]" :id="'pref-' + pref.id">
                            <span x-text="pref.title + ' (+ ' + pref.extra_cost + ' ' + pref.currency + ')'"></span>
                        </label>
                        <textarea :name="'preferences_notes[' + pref.id + ']'" class="w-full border rounded p-2" placeholder="Комментарии к предпочтению (по желанию)"></textarea>
                    </div>
                </template>
            </div>
        </template>

        <button type="submit" class="btn btn-primary mt-4">Забронировать</button>
    </form>
</div>

<script>
    function reservationForm() {
        return {
            selectedType: '',
            items: [],
            selectedItem: '',
            packages: [],
            selectedPackage: '',
            options: [],
            preferences: [],

            fetchItems() {
                if (!this.selectedType) return;

                fetch(`/api/reservation-type/${this.selectedType}/items`)
                    .then(response => response.json())
                    .then(data => {
                        this.items = data.items;
                        this.packages = data.packages;
                        this.options = data.options;
                        this.preferences = data.preferences;
                    });
            }
        };
    }
</script>
@endsection
