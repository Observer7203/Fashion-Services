<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: 'textarea#content',
                height: 400,
                menubar: false
            });
        </script>
        <script src="//unpkg.com/alpinejs" defer></script>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Exo+2:ital,wght@0,100..900;1,100..900&family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=League+Spartan:wght@100..900&family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&family=Sanchez:ital@0;1&display=swap" rel="stylesheet">
   <script>
document.addEventListener('DOMContentLoaded', function() {
    const faders = document.querySelectorAll('.fade-in-section');
    const appearOptions = {
        threshold: 0.18,
        rootMargin: '0px 0px -60px 0px'
    };
    let appearOnScroll = new IntersectionObserver(function(entries, observer) {
        entries.forEach((entry, idx) => {
            if (!entry.isIntersecting) return;
            setTimeout(() => {
                entry.target.classList.add('visible');
            }, idx * 130); // задержка для волны
            observer.unobserve(entry.target);
        });
    }, appearOptions);

    faders.forEach((fader, idx) => {
        appearOnScroll.observe(fader);
    });
});
</script>

    <style>

    .fade-in-section {
    opacity: 0;
    transform: translateY(40px); /* чуть сдвигается вниз */
    transition: opacity 0.7s cubic-bezier(.22,.68,.42,1.01), transform 0.7s cubic-bezier(.22,.68,.42,1.01);
    will-change: opacity, transform;
}
.fade-in-section.visible {
    opacity: 1;
    transform: none;
}
    </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-white-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="min-h-screen">
                @yield('content')
            </main>


            @include('partials.footer')
        </div>
        @stack('scripts')
    </body>
</html>
