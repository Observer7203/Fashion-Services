<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Raleway:wght@700&family=Mulish:wght@400;700&display=swap" rel="stylesheet">
<nav class="w-full {{ request()->routeIs('home') ? 'mainpage-navbar absolute' : 'bg-white relative' }} z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <div class="flex items-center space-x-10">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img src="{{ request()->routeIs('home')
                    ? asset('images/bbb-logo-white.png')
                    : asset('images/logo-bbb.png') }}"
                    alt="Baktygul"
                    class="h-8 w-auto"
                    style="top: 2px; position: relative; width: 90px; height: auto;">
            </a>
        </div>

        <style>
        .menu-items {
            font-family: 'Mulish', sans-serif;

        }

        .menu-items a {
            color: white !important;
            text-transform: uppercase;
            font-size: 14px;
        }
        </style>

        <div class="flex items-center space-x-6 menu-items">
            <a href="{{ route('home') }}">Главная</a>
            <a href="{{ route('about') }}">Обо мне</a>
            <a href="{{ route('services', ['locale' => app()->getLocale()]) }}">Услуги</a>
            <a href="{{ route('tours_2.index', ['locale' => app()->getLocale()]) }}">Туры</a>
            <a href="{{ route('events') }}">События</a>
            <a href="{{ route('store.index') }}" class="hover:underline">Магазин</a>
            <a href="{{ route('contacts') }}">Контакты</a>
        </div>

        <div class="flex items-center space-x-4">
           <!-- Language Switcher Icon Only -->
            <div class="relative" x-data="{ open: false }" style="display: inline-block;">
                <button @click="open = !open"
                        class="flex items-center justify-center w-9 h-9 rounded-full hover:bg-gray-100 transition"
                        aria-label="Change language"
                        type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-globe-icon lucide-globe">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                        <path d="M2 12h20"/>
                    </svg>
                </button>
                           @php
                $params = request()->route()->parameters();

                // Для страниц услуги гарантируй наличие нужного параметра!
                if (isset($service)) {
                    $params['slug'] = $service->slug ?? $service->id;
                }
                $params['locale'] = 'ru';
            @endphp
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-28 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-30" style="z-index: 3;">
                    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => 'ru'])) }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'ru' ? 'font-bold' : '' }}">Русский</a>
                    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => 'en'])) }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'en' ? 'font-bold' : '' }}">English</a>        
                </div>
            </div>
<!-- Для AlpineJS, если его нет — добавь <script src="//unpkg.com/alpinejs" defer></script> -->
            @auth
            <a style="top: 2px; position: relative; margin-right: 18px;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('home') ? '#ffffff' : '#313131' }}" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg></a>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('home') ? '#ffffff' : '#313131' }}" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-icon lucide-user-round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
                        <!--<span>{{ Auth::user()->name }}</span>-->
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0l-4.24-4.25a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow">
                        <a href="{{ route('cabinet') }}" class="block px-4 py-2 hover:bg-gray-100">Кабинет</a>
                        <a href="{{ route('cabinet.profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Профиль</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Выйти</button>
                        </form>
                    </div>
                </div>
                <a href="" style="margin-right: 20px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15.813px" height="19.719px" viewBox="0 0 15.813 19.719" enable-background="new 0 0 15.813 19.719" xml:space="preserve"><g><path fill="none" stroke="{{ request()->routeIs('home') ? '#ffffff' : '#313131' }}" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M4.231,6.98V4.109c0-2.037,1.652-3.69,3.69-3.69l0,0c2.038,0,3.69,1.653,3.69,3.69V6.98"></path><path fill="none" stroke="{{ request()->routeIs('home') ? '#ffffff' : '#313131' }}" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M12.964,19.281H2.879c-1.466,0-2.606-1.275-2.445-2.732L1.156,4.52h13.531l0.722,12.029C15.571,18.006,14.43,19.281,12.964,19.281z"></path></g></svg></a>
            @else
                <div style="display: flex; align-items: baseline;"><a style="top: 2px; position: relative; margin-right: 18px;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('home') ? '#ffffff' : '#313131' }}" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg></a>
                <a href="{{ route('login') }}" style="top: 3px; position: relative; margin-right: 20px;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ request()->routeIs('home') ? '#ffffff' : '#313131' }}" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-icon lucide-user-round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg></a>
                <a href="" style="margin-right: 20px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15.813px" height="19.719px" viewBox="0 0 15.813 19.719" enable-background="new 0 0 15.813 19.719" xml:space="preserve"><g><path fill="none" stroke="{{ request()->routeIs('home') ? '#ffffff' : '#313131' }}" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M4.231,6.98V4.109c0-2.037,1.652-3.69,3.69-3.69l0,0c2.038,0,3.69,1.653,3.69,3.69V6.98"></path><path fill="none" stroke="{{ request()->routeIs('home') ? '#ffffff' : '#313131' }}" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M12.964,19.281H2.879c-1.466,0-2.606-1.275-2.445-2.732L1.156,4.52h13.531l0.722,12.029C15.571,18.006,14.43,19.281,12.964,19.281z"></path></g></svg></a>
                </div>
            @endauth
        </div>
    </div>
    <style>
    .menu-items a {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease;
        color: {{ request()->routeIs('home') ? 'white' : '#313131' }};
    }
    .mainpage-navbar {
        background: transparent !important;
        position: absolute;
        color: white;
    }
    .navbar-scrolled {
        background: #fff !important;
        color: #313131 !important;
        transition: background 0.3s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.09);
    }
        .mainpage-navbar .menu-items a {
            color: white !important;
        }
        .mainpage-navbar .menu-items a:hover {
            color: #d1a654 !important;
        }
        /* Остальные страницы: белый фон, темный текст */
        .bg-white .menu-items a {
            color: #313131 !important;
        }
        .bg-white .menu-items a:hover {
            color: #d1a654 !important;
        }

    .mainpage-navbar .menu-items a,
    .mainpage-navbar .menu-items a:visited {
        color: white;
    }
    .navbar-scrolled .menu-items a,
    .navbar-scrolled .menu-items a:visited {
        color: #313131 !important;
    }
    </style>
</nav>

