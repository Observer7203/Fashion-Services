<!DOCTYPE html>
<html lang="{{ isset($siteLang) ? $siteLang : app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Админка')</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { font-family: 'Raleway', sans-serif; }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("alpine:init", () => {
            lucide.createIcons();
        });
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("tourForm", () => ({
                ...,
                init() {
                    flatpickr(this.$refs.seasonPicker, {
                        mode: "range",
                        dateFormat: "Y-m-d"
                    });
                }
            }));
        });
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Exo+2:ital,wght@0,100..900;1,100..900&family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=League+Spartan:wght@100..900&family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&family=Sanchez:ital@0;1&display=swap" rel="stylesheet">
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside x-data="{ open: true }" class="bg-white border-r shadow-lg flex flex-col transition-all duration-300 ease-in-out"
        :class="open ? 'w-64' : 'w-16'">
        <div class="flex items-center justify-center p-4 border-b">
            <div class="flex items-center space-x-2">
    <img src="{{ asset('images/logo-bbb.png') }}" alt="Baktygul" class="h-8 w-auto" style="top: 2px; position: relative;" x-show="open">
                <span class="text-xl" x-show="open"style="margin-right: 10px; font-family:'Rubik'; font-weight: 400;">Админ панель</span>
            </div>
            <button @click="open = !open"
                :class="open ? 'bg-white border border-[#bbb4b4] rounded-[3px] shadow' : ''"
                :style="open ? 'left: 33px; position: relative; border-radius: 3px; color: #b0b0b0;' : ''"
                class="text-gray-500 hover:text-black-400 relative">
                <svg 
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    :style="open ? 'color: #b0b0b0;' : 'color: black;'">
                    <path :d="open 
                        ? 'M15 19l-7-7 7-7'        // Стрелка влево
                        : 'M4 6h16M4 12h16M4 18h16'" />  <!-- Бургер-меню -->
                </svg>
            </button>
        </div>
       <nav class="flex-1 space-y-1 p-4">
    @php
        $mainMenu = [
            ['route' => 'admin.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Дашборд'],
            ['route' => 'services.index', 'icon' => 'briefcase', 'label' => 'Услуги'],
            ['route' => 'tours.index', 'icon' => 'map', 'label' => 'Туры'],
            ['route' => 'products.index', 'icon' => 'shopping-bag', 'label' => 'Магазин'],
            ['route' => 'events.index', 'icon' => 'calendar-days', 'label' => 'События'],
            ['route' => 'reservations.index', 'icon' => 'clipboard-list', 'label' => 'Бронирования'],
        ];

        $bookingMenu = [
            ['route' => 'reservation-types.index', 'icon' => 'list', 'label' => 'Типы брони'],
            ['route' => 'reservation-types.index', 'icon' => 'list-check', 'label' => 'Шаблоны шагов'],
        ];

        $formsMenu = [
            ['route' => 'forms.index', 'icon' => 'file-text', 'label' => 'Список форм'],
            ['route' => 'form_responses.index', 'icon' => 'inbox', 'label' => 'Ответы форм'],
        ];

        $otherMenu = [
            ['route' => 'pages.index', 'icon' => 'file-text', 'label' => 'Страницы'],
            ['route' => 'blocks.index', 'icon' => 'layers', 'label' => 'Блоки'],
        ];
    @endphp

    {{-- Основные разделы --}}
    @foreach($mainMenu as $item)
        @php $isActive = request()->routeIs($item['route'].'*'); @endphp
        <a href="{{ route($item['route']) }}"
           class="flex items-center space-x-2 py-2 rounded text-sm transition-all duration-300
                  {{ $isActive ? 'text-black font-semibold' : 'text-gray-600' }} hover:text-black"
           :class="open ? 'justify-start px-3' : 'justify-center px-0'">
            <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5" style="stroke-width: 1.2; color: black;"></i>
            <span x-show="open">{{ $item['label'] }}</span>
        </a>
    @endforeach

    {{-- Бронирование (подразделы) --}}
    <div x-data="{ openSub: false }" class="mb-1">
        <a href="#" @click.prevent="openSub = !openSub"
           class="flex items-center py-2 px-3 rounded transition-all font-semibold text-black">
            <i data-lucide="layers" class="w-5 h-5"></i>
            <span x-show="open" class="ml-2">Бронирование</span>
            <svg x-show="open" :class="openSub ? 'rotate-90' : ''" class="w-4 h-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 5l7 7-7 7" /></svg>
        </a>
        <div x-show="openSub" class="ml-7 mt-2 space-y-1" x-cloak>
            @foreach($bookingMenu as $sub)
                <a href="{{ route($sub['route']) }}"
                   class="flex items-center py-1 px-2 rounded text-sm text-gray-700 hover:text-black">
                    <i data-lucide="{{ $sub['icon'] }}" class="w-4 h-4"></i>
                    <span x-show="open" class="ml-2">{{ $sub['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Формы (подразделы) --}}
    <div x-data="{ openSubForms: false }" class="mb-1">
        <a href="#" @click.prevent="openSubForms = !openSubForms"
           class="flex items-center py-2 px-3 rounded transition-all font-semibold text-black">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span x-show="open" class="ml-2">Формы</span>
            <svg x-show="open" :class="openSubForms ? 'rotate-90' : ''" class="w-4 h-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 5l7 7-7 7" /></svg>
        </a>
        <div x-show="openSubForms" class="ml-7 mt-2 space-y-1" x-cloak>
            @foreach($formsMenu as $sub)
                <a href="{{ route($sub['route']) }}"
                   class="flex items-center py-1 px-2 rounded text-sm text-gray-700 hover:text-black">
                    <i data-lucide="{{ $sub['icon'] }}" class="w-4 h-4"></i>
                    <span x-show="open" class="ml-2">{{ $sub['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Прочее --}}
    @foreach($otherMenu as $item)
        @php $isActive = request()->routeIs($item['route'].'*'); @endphp
        <a href="{{ route($item['route']) }}"
           class="flex items-center space-x-2 py-2 rounded text-sm transition-all duration-300
                  {{ $isActive ? 'text-black font-semibold' : 'text-gray-600' }} hover:text-black"
           :class="open ? 'justify-start px-3' : 'justify-center px-0'">
            <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5" style="stroke-width: 1.2; color: black;"></i>
            <span x-show="open">{{ $item['label'] }}</span>
        </a>
    @endforeach
</nav>
<div class="p-4 border-t">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-red-600 text-sm hover:underline w-full flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-5" style="stroke-width: 1.5;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/>
            </svg>
            <span x-show="open">Выйти</span>
            <span x-show="!open" class="sr-only">Выйти</span>
        </button>
    </form>
</div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-6" style="padding: 30px;">
@php $currentLang = session('locale', config('app.locale')); @endphp

<div style="position: fixed; top: 22px; right: 40px; z-index: 100;" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open"
            class="border border-gray-200 rounded px-3 py-2 flex items-center text-sm font-semibold">
        <svg ...></svg>
        <span>{{ strtoupper($currentLang) }}</span>
    </button>

    <div x-show="open" x-transition x-cloak
         class="absolute right-0 top-10 bg-white border rounded shadow min-w-[80px]">
        @foreach(['ru', 'en'] as $lang)
            <button @click="
                fetch('{{ route('setlang') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ lang: '{{ $lang }}' })
                }).then(() => window.location.reload());
            "
            class="w-full text-left px-4 py-2 hover:bg-gray-100 {{ $currentLang === $lang ? 'bg-gray-50' : '' }}">
                {{ strtoupper($lang) }}
            </button>
        @endforeach
    </div>
</div>

        @yield('content')
    </main>
    <style>
    span {
    font-weight: 600;
    }
    .menu-items:hover span {
    transform: translateX(10px);
    }
    .menu-items span {
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    </style>
</body>
</html>
