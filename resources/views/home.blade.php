@extends('layouts.app')
@section('title', 'Главная')

@section('content')
<div class="parallax">
<style>
nav {
    background: transparent;
    position: absolute;
    z-index: 2;
}
</style>

    <!-- Hero Section -->
<!-- Hero Section -->
<div class="parallax">
    <section class="hero swiper hero-swiper">
        <div class="swiper-wrapper">
            @forelse($homepage->slides ?? [] as $slide)
                <div class="swiper-slide">
                    <div class="hero-background"
                         style="background: url('{{ Str::startsWith($slide['bg'], ['http://', 'https://']) ? $slide['bg'] : asset($slide['bg']) }}') center center no-repeat;
                                position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                                scale: 1.2; background-size: cover; overflow: hidden;">
                    </div>
                    <div class="slider-text hero-text">
                        <span class="slider-main-title fade-in-section">{{ $slide['title'] ?? '' }}</span>
                        @if(!empty($slide['button_url']))
                            <a class="button-slider fade-in-section" href="{{ Str::startsWith($slide['button_url'], ['http://', 'https://']) ? $slide['button_url'] : url($slide['button_url']) }}">
                                <span class="button-slider-text">{{ $slide['button_text'] ?? 'LEARN MORE' }}</span>
                            </a>
                        @endif
                        <div class="slider-text-div fade-in-section">
                            <span class="slider-text">{{ $slide['description'] ?? '' }}</span>
                        </div>
                            <span class="second-slider-title fade-in-section">{{ $slide['subtitle'] ?? '' }}</span>
                        <span class="second-slider-title fade-in-section">{{ $slide['bottom'] ?? '' }}</span>
                    </div>
                </div>
            @empty
                {{-- Дефолтный слайд 1 --}}
                <div class="swiper-slide">
                    <div class="hero-background"
                         style="background: url('https://thumbsnap.com/i/BUr92HgV.jpg?0520') center center no-repeat;
                                position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                                scale: 1.2; background-size: cover; overflow: hidden;">
                    </div>
                    <div class="slider-text hero-text">
                        <span class="slider-main-title fade-in-section">BAKTYGUL BULATKALI</span>
                        <a class="button-slider fade-in-section" href="{{ route('about') }}">
                            <span class="button-slider-text">LEARN MORE</span>
                        </a>
                        <div class="slider-text-div fade-in-section">
                            <span class="slider-text">Fashion influencer with unique own vision in fashion industry advancing freshness and creativity</span>
                        </div>
                        <span class="second-slider-title fade-in-section">Fashion stylist</span>
                    </div>
                </div>

                {{-- Дефолтный слайд 2 --}}
                <div class="swiper-slide">
                    <div class="hero-background"
                         style="background: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/379410672_845717123525682_6733083808991049778_n.jpg?_t=1747850731') center center no-repeat;
                                position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                                scale: 1.2; background-size: cover; overflow: hidden; background-position-y: center;">
                    </div>
                    <div class="slider-text hero-text">
                        <span class="slider-main-title fade-in-section">TOUR ACTIONS</span>
                        <div class="button-slider fade-in-section">
                            <span class="button-slider-text">LEARN MORE</span>
                        </div>
                        <div class="slider-text-div fade-in-section">
                            <span class="slider-text">Seasonal discounts with VIP access to exclusive worldwide fashion events & runway shows</span>
                        </div>
                        <span class="second-slider-title fade-in-section">Fashion stylist</span>
                    </div>
                </div>
            @endforelse
        </div>
    </section>
</div>

{{-- About Section --}}
<section class="about parallax-section">
    <div class="about-background">
    </div>
    <div class="about-content">
        <h2>About Me</h2>
        <p>
            {{ $homepage->about_text ?? 'Fashion stylist, personalized selection of clothing and accessories, boutique shopping assistance, and creation of individual looks tailored to your style and goals.' }}
        </p>
        <a class="button-slider-2 about-button" href="{{ route('about') }}">
            <span class="">DISCOVER</span>
        </a>
    </div>
</section>

</section>
<div class="tour-list">
</div>
<section class="services-grid">
  @php
      $count = $services->count();
  @endphp

  @forelse($services as $i => $service)
      @php
          $mainMedia = $service->mediaFiles->where('type', 'main')->first();
          $bg = $mainMedia && $mainMedia->path ? asset('storage/' . $mainMedia->path) : 'https://your-default-image.jpg';

          // Класс и стили сетки
          if ($count === 1) {
                $style = 'width:100vw;height:100vh;display:block;';
            } elseif ($count === 2) {
                $style = 'width:50vw;height:100vh;display:inline-block;';
            } elseif ($count === 3) {
                $style = 'width:33.333vw;height:100vh;display:inline-block;';
            } elseif ($count === 4) {
                $style = 'width:50vw;height:50vh;display:inline-block;';
            } elseif ($count === 5) {
                // 2 сверху (по 50%) и 3 снизу (по 33.33%)
                $style = $i < 2
                    ? 'width:50vw;height:50vh;display:inline-block;'
                    : 'width:33.333vw;height:50vh;display:inline-block;';
            } elseif ($count === 6) {
                $style = 'width:33.333vw;height:50vh;display:inline-block;';
            } else {
                // Для >6 — первый экран: 6 элементов по 3x2, остальные слайдером (понадобится JS, см. ниже)
                $style = 'width:33.333vw;height:50vh;display:inline-block;';
            }
        @endphp

      <div class="service-box" style="background-image: url('{{ $bg }}'); {{ $style }}">
          <div class="overlay">
              <h3>{{ mb_strtoupper($service->getTranslation('title', app()->getLocale())) }}</h3>
              <p>{{ Str::limit($service->getTranslation('short_description', app()->getLocale()), 200) }}</p>
              <a class="btn" href="{{ url('/service/personal-styling') }}">VIEW MORE</a>
          </div>
      </div>
  @empty
      {{-- Твои дефолтные карточки если нет услуг --}}
      <div class="service-box" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BA%D0%B0/404938529_1586498311881129_6707843715254820543_n.jpg?_t=1747715957'); background-position-y: -54px;">
          <div class="overlay">
              <h3>PERSONAL | STYLING</h3>
              <p>Transform your personal image with exclusive one-on-one styling sessions. From everyday elegance to red-carpet glamour, we curate complete looks that reflect your individuality, lifestyle, and aspirations..</p>
              <a class="btn" href="{{ url('/service/personal-styling') }}">VIEW MORE</a>
          </div>
      </div>
      <div class="service-box" style="background-image: url('https://lh3.google.com/u/0/d/14hGKfnDOTlXUYqXhyl5QZojY5BYtAaoi=w1607-h912-iv1?auditContext=prefetch');">
          <div class="overlay">
              <h3>FASHION | TOURS</h3>
              <p>Discover Paris through a fashion lover’s eyes. Our private tours lead you to legendary designer boutiques, emerging concept stores, couture ateliers, and hidden vintage treasures, all tailored to your style and interests.</p>
              <a class="btn" href="">VIEW MORE</a>
          </div>
      </div>
      <div class="service-box" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BA%D0%B0/image2.png?_t=1747708616'); background-position-y: 0px;">
          <div class="overlay">
              <h3>CONSULTATION</h3>
              <p>a personalized session (in-person or online) where you receive expert guidance on style, wardrobe selection, and image strategy. The service helps you clarify your goals, refine your personal brand, and develop a harmonious, contemporary look tailored to your individuality</p>
              <a class="btn" href="">VIEW MORE</a>
          </div>
      </div>
      <div class="service-box" style="background-image: url('https://lh3.google.com/u/0/d/15JjTL4K_gYqGOljKZlOO8iVlXq1yfo9p=w1557-h912-iv1?auditContext=prefetch');">
          <div class="overlay">
              <h3>CONCIERGE | SERVICES</h3>
              <p>Our bespoke concierge services ensure a seamless Parisian experience, including private transportation, reservations at exclusive venues, personalized itineraries, luxury shopping assistance, and round-the-clock support.</p>
              <a class="btn" href="">VIEW MORE</a>
          </div>
      </div>
      <div class="service-box" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BA%D0%B0/405201231_382002000893665_5876306834808737193_n.jpg?_t=1747845690'); background-position-y: unset;">
          <div class="overlay">
              <h3>VINTAGE WEAR<br>JEWEL</h3>
              <p>Embark on a curated journey to discover exceptional vintage fashion and rare jewelry pieces. We open doors to Paris’s best-kept secrets — prestigious vintage boutiques, private showrooms, and collectors’ hidden gems.</p>
              <a class="btn" href="">VIEW MORE</a>
          </div>
      </div>
      <div class="service-box" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BA%D0%B0/image3.png?_t=1747708616');">
          <div class="overlay">
              <h3>PERSONAL | SHOPPER</h3>
              <p>Personalized selection of clothing and accessories,<br>
              boutique shopping assistance, and creation of individual<br>
              looks tailored to your style and goals.</p>
              <a href="#" class="btn">VIEW MORE</a>
          </div>
      </div>
  @endforelse
</section>



        <section class="tour-video-slide swiper tour-swiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <video autoplay muted loop playsinline class="bg-video">
        <source src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/IMG_5054%20%28online-video-cutter.com%29%20%284%29.mp4?_t=1747722498" type="video/mp4">
      </video>
      <div class="video-overlay"></div>
      <div class="tour-hero-text">
        <span class="tour-main-title">PARIS FASHION WEEK TOUR</span>
        <div class="tour-subtext-block">
          <span class="tour-subtext">Exclusive access to fashion shows, designer boutiques, and iconic Parisian fashion landmarks with a personalized guided experience.</span>
        </div>
        <div class="tour-subtext-block-price">
          <span class="tour-subtext-price">Season: June 24 to Sunday, June 29, 2025</span>
          <span class="tour-subtext-price">Price 3000</span>
        </div>
        <div class="tour-button-slider">
          <a class="tour-button-text" href="{{ url('/tours/pfwt') }}">RESERVE</a>
        </div>
        <span class="tour-second-title">FASHION TOUR</span>
      </div>
    </div>
    <!-- Добавьте дополнительные слайды при необходимости -->
  </div>
</section>


<div class="tour-list-block">
  <div class="tour-list-item">
    <div class="tour-text">
      <h3>STYLING TOUR</h3>
      <p>Personalized styling session with a professional stylist and visits to selected boutiques.</p>
    </div>
        <img class="tour-preview" src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/File_000%20%E2%80%94%20%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F.png?_t=1747735845" alt="Tour" />
    <div class="tour-arrow">→</div>
  </div>
  <div class="tour-list-item">
    <div class="tour-text">
      <h3>VINTAGE TOUR</h3>
      <p>Curated shopping experience with expert guidance to find the perfect vintage looks.</p>
    </div>
            <img class="tour-preview" src="https://lh3.google.com/u/0/d/1MWKMcAlmnffyHIop-E4DtM7qz5ADzios=w1920-h912-iv1?auditContext=prefetch" alt="Tour" />
    <div class="tour-arrow">→</div>
  </div>
  <div class="tour-list-item">
    <div class="tour-text">
      <h3>PARIS FASHION WEEK TOUR – STREET STYLE</h3>
      <p>Discover the best Paris fashion spots and capture iconic street style moments.</p>
    </div>
            <img class="tour-preview" src="https://lh3.google.com/u/0/d/1aP2LEyocJqetINyJK6Npg7XNFnDgkCGR=w1920-h912-iv1?auditContext=prefetch" alt="Tour" />
    <div class="tour-arrow">→</div>
  </div>
  <div class="tour-list-item">
    <div class="tour-text">
      <h3>PARIS FASHION WEEK TOUR – EXPRESS PACKAGE</h3>
      <p>Quick access to key Paris Fashion Week shows and exclusive fashion experiences.</p>
    </div>
            <img class="tour-preview" src="https://lh3.google.com/u/0/d/1aP2LEyocJqetINyJK6Npg7XNFnDgkCGR=w1920-h912-iv1?auditContext=prefetch" alt="Tour" />
    <div class="tour-arrow">→</div>
  </div>
</div>

<section class="event-hero">
  <div class="event-hero-bg">
    <video autoplay muted loop playsinline>
      <source src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/Versace%20Spring-Summer%202023%20Women%E2%80%99s%20_%20Fashion%20Show%20_%20Versace%20(online-video-cutter.com).mp4?_t=1747737591" type="video/mp4">
    </video>
    <div class="overlay"></div>
  </div>
  <div class="event-hero-content">
    <h2>PARIS FASHION WEEK</h2>
    <p class="event-desc">Womenswear fall/winter 2025–2026 showroom session will take place at the palais de tokyo from wednesday march 5th to tuesday march 11th, 2025. a digital version will also be available by invitation with the help of le new black and grand shooting from march 5th, 2025.</p>
    <div class="event-meta">
      <span class="event-price">PRICE 3000 €</span>
      <span class="event-tour">IN TOUR “PARIS FASHION WEEK TOUR”</span>
      <span class="event-date">SEPTEMBER 26, 2026</span>
    </div>
    <div class="event-buttons">
    <a class="button-slider2" href="{{ url('/events/pfw') }}">VIEW MORE</a>
    <a class="button-slider-2 event-button" href="{{ url('/tours/pfwt') }}">VISIT</a>
    </div>
  </div>
</section>
      
      <div class="event-slider-section">
  <div class="swiper event-swiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide event-slide" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/hbz-viktor-rolf-statement-gowns-05-1548271843.jpg?_t=1747738278');">
        <div class="event-slide-text">VIKTOR & ROLF HAUTE COUTURE SPRING/SUMMER 2023</div>
      </div>
      <div class="swiper-slide event-slide" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/maxresdefault%20(6).jpg?_t=1747738278');">
        <div class="event-slide-text">VERSACE HOUSE PARTY | PRE-FALL 2020 CAMPAIGN</div>
      </div>
      <!-- Добавь ещё слайды по необходимости -->
      <div class="swiper-slide event-slide" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/met-gala-2021-1631525584.jpg?_t=1747812117');">
        <div class="event-slide-text">MET GALA 2025</div>
      </div>
      
            <div class="swiper-slide event-slide" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/nedelya-modi-v-milane.png?_t=1747812117');">
        <div class="event-slide-text">MILAN FASHION WEEK</div>
      </div>
      
      
    </div>
  </div>
</div>





    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.services-swiper', {
          slidesPerView: 1,
          loop: true,
          pagination: { el: '.swiper-pagination', clickable: true },
          navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
        });
      });
      </script>
    <!-- Твои подключения JS-слайдеров и кастомные скрипты -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
// JavaScript для параллакса на фоновом изображении
// window.addEventListener('scroll', function() {
   //  const heroBackground = document.querySelector('.hero-background');
   //  let offset = window.pageYOffset * 0.5; // Control the speed of the parallax effect
   //  heroBackground.style.backgroundPositionY = offset + 'px';
// });


// JavaScript for adding fixed class to navbar when scrolling
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 100) {
        navbar.classList.add('fixed'); // Добавляем класс для фиксированного меню
    } else {
        navbar.classList.remove('fixed'); // Убираем класс при прокрутке обратно вверх
    }
});

// JavaScript для параллакса на фоновом изображении About
window.addEventListener('scroll', function () {
    const heroBackground = document.querySelector('.about-background');
    if (heroBackground) {
        // Начальная позиция -500px, прибавляем смещение от скролла
        let offset = -500 + window.pageYOffset * 0.2;
        heroBackground.style.backgroundPositionY = offset + 'px';
    }
});


document.addEventListener('DOMContentLoaded', function () {
  const video = document.querySelector('.bg-video');
  if (video) {
    video.playbackRate = 0.9;
  }
});




  const swiper = new Swiper('.event-swiper', {
    slidesPerView: 2.5,
    spaceBetween: 20,
    grabCursor: true,
    centeredSlides: false,
    loop: false,
    breakpoints: {
      768: {
        slidesPerView: 2.5,
      },
      480: {
        slidesPerView: 1.5,
      },
      0: {
        slidesPerView: 1.2,
      },
    },
  });


// Инициализация слайдера для главного баннера (Hero section)
const heroSwiper = new Swiper('.hero-swiper', {
  loop: true,
  effect: 'fade',
  fadeEffect: {
    crossFade: true
  },
  autoplay: {
    delay: 8000,
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  }
});

// Инициализация слайдера для туров
const tourSwiper = new Swiper('.tour-swiper', {
  loop: true,
  effect: 'fade', // Плавный переход
  fadeEffect: {
    crossFade: true
  },
  autoplay: {
    delay: 3000, // Время для каждого слайда
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  }
});

    </script>

  <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>
/* Reset styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* General body styling */
body {
    font-family: 'Arial', sans-serif; /* Шрифт, как в PDF */
}

/* Navbar Styling */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    background-color: transparent;
    position: absolute;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 10;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.navbar.fixed {
    top: 0; /* При фиксации меню остается вверху */
    background-color: rgba(0, 0, 0, 0.8); /* Добавляем фон при фиксации */
}

.navbar .logo h1 {
    font-size: 2rem;
    font-weight: bold;
}

.navbar .nav-links {
    display: flex;
    gap: 30px;
    justify-content: center;
}

.navbar .nav-links li {
    list-style: none;
}

.navbar .nav-links li a {
    text-decoration: none;
    font-size: 1rem;
    color: white;
    font-family: Raleway;
}

.navbar .nav-links li a:hover {
    color: #d1a654;
}

/* Parallax Container */
.parallax {
    overflow: hidden;
}

/* Parallax sections */
.parallax > section {
    position: relative;
    height: 100vh; /* Make each section take full viewport height */
}

/* Hero Section */
.hero {
    position: relative;
  overflow: hidden
}

/* Hero Background (Parallax Background) */
.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    scale: 1.2;
    inset: 0;
  transform: scale(1);
  animation: zoomIn 25s ease forwards;
    z-index: 0;
    background-size: cover;
    background-attachment: fixed;
    overflow: hidden;
}

@keyframes zoomIn {
    0% {
        transform: scale(1);
    }
    100% {
        transform: scale(1.2);
    }
}

.hero-background::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.2); /* степень затемнения */
    z-index: 1;
}

/* Чтобы контент был над затемнением */
.hero-background > * {
    position: relative;
    z-index: 2;
}

/* Hero Text (Left-aligned) */
.hero-text {
    position: relative;
    color: white;
    text-align: left; /* Выравнивание текста слева */
    width: 50%; /* Ограничиваем ширину текста */
    margin-left: 15%; /* Отступ слева */
    margin-top: 7%; /* Отступ сверху, чтобы текст не был на краю экрана */
}

.hero-text h1 {
    font-size: 3rem;
    margin-bottom: 20px; /* Расстояние между заголовком и текстом */
    line-height: 1.2;
}

.hero-text p {
    font-size: 1.5rem;
    line-height: 1.8;
    margin-bottom: 40px;
}

/* Section Styling */
section {
    padding: 50px 10%;
    text-align: center;
}

h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
}

h3 {
    font-size: 2rem;
    margin-bottom: 10px;
}

p {
    font-size: 1.2rem;
    line-height: 1.5;
}

/* Services section styling */
.services .service {
    margin-bottom: 20px;
}

/* Contact section styling */
.contact {
    background: #f4f4f4;
}

/* Responsive design */
@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 2.5rem;
    }
    .hero-text p {
        font-size: 1.2rem;
    }
}


.slider-text {
  width: 100%;
  height: 441px;
  background: url("../images/v483_284.png");
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
  opacity: 1;
  overflow: hidden;
}
.slider-main-title {
  width: 563px;
  color: rgba(255,255,255,1);
  position: absolute;
  top: 60px;
  left: 0px;
  font-family: Inter;
  font-weight: Bold;
  font-size: 77px;
  line-height: 1.2;
  opacity: 1;
  text-align: left;
}
.button-slider {
    background: rgba(255, 255, 255, 1);
    opacity: 1;
      padding: 18px 40px;
    position: absolute;
    top: 383px;
    left: 0px;
    justify-content: center;
    align-items: center;
    display: flex;
    overflow: hidden;
    text-decoration: none;
    color: black;
}

.button-slider2 {
    background: rgba(255, 255, 255, 1);
    opacity: 1;
    padding: 18px 40px;
    justify-content: center;
      font-size: 14px;
    align-items: center;
    display: flex;
    overflow: hidden;
    text-decoration: none;
    color: black;
}
.button-slider-text {
    /* width: 105px; */
    color: rgba(0, 0, 0, 1);
    position: relative;
    font-family: Raleway;
    font-weight: SemiBold;
    font-size: 13px;
    opacity: 1;
}
.v483_148 {
  width: 100px;
  height: 100px;
  background: url("../images/v483_148.png");
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
  opacity: 1;
  position: absolute;
  top: 23px;
  left: 56px;
  overflow: hidden;
}
.slider-text-div {
  width: 100%;
  height: 70px;
  background: url("../images/v483_149.png");
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
  opacity: 1;
  position: absolute;
  top: 263px;
  left: 0px;
  overflow: hidden;
}
.slider-text {
  width: 457px;
  color: rgba(255,255,255,1);
  font-family: Raleway;
  font-weight: Regular;
  font-size: 18px;
  opacity: 1;
  text-align: left;
}
.second-slider-title {
  width: 167px;
  color: rgba(255,255,255,1);
  position: absolute;
  top: 0px;
  left: 0px;
  font-family: Inter;
  font-weight: Italic;
  font-size: 24px;
  opacity: 1;
  text-align: left;
}

.parallax-section {
    position: relative;
    height: 100vh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 0 10%;
    color: white;
}

.about-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('https://thumbsnap.com/i/qAsZZaWT.jpg') center center no-repeat;
    background-size: 1750px;
    background-position-y: -500px;
    background-position-x: -200px;
    background-attachment: fixed;
    z-index: 0;
}

.about-background::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.3);
    z-index: 1;
}

.about-content {
    position: relative;
    z-index: 2;
    max-width: 600px;
    text-align: right;
}

.about-content h2 {
    font-size: 3rem;
    font-family: Inter;
    margin-bottom: 20px;
}

.about-content p {
    font-size: 1.2rem;
    line-height: 1.6;
    font-family: Raleway;
    margin-bottom: 40px;
}

.about-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 18px 40px;
    font-size: 14px;
    border: 1px, solid;
    top: 30px;
    position: relative;
      color: white;
    text-decoration: none;
}

.event-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 18px 40px;
    font-size: 14px;
    border: 1px, solid;
    position: relative;
      color: white;
    text-decoration: none;
}

.about-button span {
    color: white;
}

.about-button .button-slider-text {
    color: black;
    font-family: Raleway;
    font-weight: 600;
    font-size: 14px;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    flex-wrap: wrap;
    width: 100%;
    min-height: 100vh;
    padding: 0;
}

.service-box {
    position: relative;
    background-size: cover;
    background-position: center;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.service-box::before {
    content: "";
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.2);
    transition: background-color 0.4s ease;
    z-index: 1;
}

.service-box:hover::before {
    background-color: rgba(0, 0, 0, 0.4);
}

.overlay {
    position: absolute;
    z-index: 2;
    bottom: 20px;
    left: 20px;
    right: 20px;
    color: white;
    font-family: Raleway, sans-serif;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
    text-align: left;
}

.service-box:hover .overlay {
    opacity: 1;
    transform: translateY(0);
}

.overlay h3 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
}

.overlay p {
    font-size: 14px;
    margin-bottom: 15px;
    line-height: 1.4;
}

.overlay .btn {
    display: inline-block;
    padding: 8px 16px;
    color: white;
    font-size: 12px;
    text-decoration: none;
    font-weight: bold;
    border: 1px, solid;
    transition: background-color 0.3s ease;
}

.overlay .btn:hover {
    background-color: #ccc;
}

/* ✅ Адаптация под мобильные экраны */
@media (max-width: 1024px) {
    .services-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .services-grid {
        grid-template-columns: 1fr;
    }

    .overlay {
        left: 15px;
        right: 15px;
        bottom: 15px;
    }

    .overlay h3 {
        font-size: 16px;
    }

    .overlay p {
        font-size: 13px;
    }

    .overlay .btn {
        font-size: 12px;
    }
}


span.slider-text {
    line-height: 1.6;
}

/* Видео-бокс вместо фоновой картинки */
.video-box {
    position: relative;
    overflow: hidden;
    height: 100%;
}

.video-box .bg-video {
    position: absolute;
    top: 50%;
    left: 50%;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    transform: translate(-50%, -50%);
    object-fit: cover;
    z-index: 0;
    pointer-events: none;
}

.tour-video-slide {
  position: relative;
  width: 100%;
  height: 100vh;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.bg-video {
  position: absolute;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 0;
  pointer-events: none;
}

.video-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.45); /* Тёмный фильтр */
  z-index: 1;
}

.tour-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  padding: 30px 60px;
  color: white;
  animation: fadeInUp 1s ease forwards;
  opacity: 0;
  transform: translateY(20px);
  text-align: left; 
      left: -210px;
}


.tour-video-slide.active .tour-content {
  opacity: 1;
  transform: translateY(0);
}

.tour-content h2 {
  font-family: Inter, sans-serif;
  font-size: 48px;
  margin-bottom: 20px;
}

.tour-content p {
  font-family: Raleway, sans-serif;
  font-size: 18px;
  line-height: 1.6;
  margin-bottom: 30px;
}

.tour-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 198px;
    height: 58px;
    border: 1px, solid;
    top: 30px;
    position: relative;
    color: white;
     text-decoration: none;
}

.tour-list {
  background-color: black;
  color: white;
  padding: 1px;
  text-align: center;
  font-family: Raleway;
}

.tour-list ul {
  display: flex;
  justify-content: center;
  gap: 20px;
  list-style: none;
  flex-wrap: wrap;
}

.tour-list li {
  font-size: 16px;
  text-transform: uppercase;
  font-weight: 500;
}

@keyframes fadeInUp {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}


.tour-list-block {
  background: #f8f6f3;
  padding: 0;
  display: flex;
  flex-direction: column;
  font-family: Raleway, sans-serif;
}

.tour-list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 30px;
    transition: all 0.3s ease;
    cursor: pointer;
    text-align: left;
    border: 0.5px solid #ddd;
}

.tour-list-item:hover {
  background: #0e1d34; /* цвет из палитры сайта */
  color: white;
  border: 1px, solid, #0e1d34;
} 

.tour-list-item:hover .tour-text h3,
.tour-list-item:hover .tour-text p {
  color: white;
}

.tour-text h3 {
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 10px;
  color: #111;
}

.tour-text p {
  font-size: 15px;
  line-height: 1.6;
  color: #444;
}

.tour-arrow {
  font-size: 24px;
  font-weight: bold;
  transition: transform 0.3s ease;
  color: #111;
}

.tour-list-item:hover .tour-arrow {
  color: white;
  transform: translateX(5px);
}

/* адаптив */
@media (max-width: 768px) {
  .tour-list-item {
    flex-direction: column;
    align-items: flex-start;
  }

  .tour-arrow {
    align-self: flex-end;
    margin-top: 10px;
  }
}

.tour-hero-text {  
position: relative;   
color: white;   
text-align: left;  
width: 100%;   
height: inherit; 
margin-left: 15%;
z-index: 2;   
margin-top: 20%;
}

.tour-main-title {
    width: 800px;
    color: white;
    font-family: Inter;
    font-weight: bold;
    font-size: 3rem;
    text-align: left;
    display: block;
    position: absolute;
    top: 115px;
    left: 0;
}

.tour-button-slider {
background: white;
position: relative; 
width: fit-content;
top: 383px;
padding: 18px 40px;
left: 0;
display: flex;
justify-content: center;
align-items: center;
}

.tour-button-text {
    color: black;
    font-family: Raleway;
    font-size: 14px;
}

.tour-subtext-block {
    width: 100%;
    height: 70px;
    position: absolute;
    top: 215px;
    left: 0;
}

.tour-subtext {
    width: 600px;
    color: white;
    font-family: Raleway;
    font-weight: 400;
    font-size: 18px;
    text-align: left;
    line-height: 1.6;
    display: block;
}


.tour-subtext-block-price {
    width: 710px;
    height: 70px;
    position: absolute;
    display: flex;
    top: 275px;
    left: 0;
}

.tour-subtext-price {
    font-family: Inter;
    width: 457px;
    color: white;
    font-family: Raleway;
    font-weight: 400;
    font-size: 18px;
    text-align: left;
    line-height: 1.6;
    display: block;
}

.tour-second-title {
    width: 200px;
    color: white;
    position: absolute;
    top: 40px;
    left: 0;
    font-family: Inter;
    font-size: 24px;
    text-align: left;
}


.tour-list-item {
    padding-left: 13.5%;
    padding-right: 7%;
}



.tour-list-item {
  position: relative;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: white;
  border: 1px solid #ddd;
  transition: all 0.3s ease;
  overflow: hidden;
  cursor: pointer;
}

.tour-list-item:hover {
  background: #0e1d34;
  color: white;
}

.tour-list-item:hover .tour-text h3,
.tour-list-item:hover .tour-text p,
.tour-list-item:hover .tour-arrow {
  color: white;
}

.tour-preview {
  position: absolute;
  top: 0;
  right: 18%;
  height: 100%;
  width: 200px;
  object-fit: cover;
  opacity: 0;
  transition: opacity 0.3s ease;
  z-index: 0;
}

.tour-list-item:hover .tour-preview {
  opacity: 1;
}

.event-hero {
  position: relative;
  height: 100vh;
  color: white;
  display: flex;
  align-items: center;
  padding: 0 10%;
  overflow: hidden;
}

.event-hero-bg {
  position: absolute;
  inset: 0;
  z-index: 0;
}

.event-hero-bg video {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.event-hero-bg .overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
}

.event-hero-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  text-align: left;
      margin-top: 50px;
  margin-left: 5%;
}

.event-hero h2 {
  font-size: 48px;
  font-family: Inter, sans-serif;
  margin-bottom: 40px;
}

.event-desc {
    font-family: Raleway;
    margin-bottom: 20px;
    font-weight: 400;
    font-size: 18px;
    text-align: left;
    line-height: 1.6;
}

.event-meta {
  font-size: 15px;
  margin-bottom: 60px;
  display: flex;
  gap: 20px;
  font-family: 'Inter';
   font-weight: 300;
}

.event-meta span {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
}

.event-buttons {
  display: flex;
  gap: 18px;
  height: 50px;
  font-family: 'Raleway';
}

.event-btn {
  background: white;
  color: black;
  padding: 12px 24px;
  text-decoration: none;
      font-size: 13px;
}

.event-btn.secondary {
  background: transparent;
  border: 1px solid white;
  color: white;
}

.event-hero-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.3);
    z-index: 1;
}



.event-slide {
  flex: 0 0 calc(40% - 10px); /* 2.5 карточки на экране */
  height: 300px;
  background-size: cover;
  background-position: center;
  position: relative;
  scroll-snap-align: start;
  transition: transform 0.3s ease;
  margin-right: 0px !important;
}


.event-slide-text {
  background: none; /* ❌ Убираем затемнение */
  color: white;
  font-family: Raleway;
  font-size: 14px;
  padding: 15px;
  width: 100%;
  text-align: left;
  position: absolute;
  bottom: 0;
  left: 0;
  text-shadow: 0 0 5px rgba(0, 0, 0, 0.6); /* ✅ Немного тени для читаемости */
}


/* Плавное появление фона */
.hero-background, .tour-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  opacity: 0;
  animation: fadeInBackground 1s forwards;
}

@keyframes fadeInBackground {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Текст */
.hero-text, .tour-hero-text {
  position: relative;
  z-index: 2;
  color: white;
  opacity: 0;
  animation: fadeInText 1s ease-out forwards;
}

@keyframes fadeInText {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}



/* Для кнопок */
.button-slider, .tour-button-slider {
  background: rgba(255, 255, 255, 1);
  opacity: 1;
  padding: 18px 40px;
  position: absolute;
  left: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  text-decoration: none;
  color: black;
}

/* Стили для видео */
.bg-video {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 0;
}

/* Прозрачный наложенный слой для видео */
.video-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.45); /* затемнение */
  z-index: 1;
}

/* Плавное появление текста туров */
.tour-hero-text {
  position: absolute;
  z-index: 2;
  animation: fadeInText 1.5s ease-out forwards;
}

:root {
  --tone-base:  #0e1d34; /* глубокий синий, основной тон */
  --tone-mid:   #313131; /* тёмно-серый для текста/иконок */
  --tone-dark:  #222222; /* почти чёрный, самые тёмные тени */
}
    </style>
@endsection