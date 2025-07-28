@extends('layouts.app')

@section('title', __('Tours') . ' | Baktygul Bulatkali')

@section('content')

<link href="https://fonts.googleapis.com/css?family=Raleway:700,800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Inter:400,500&display=swap" rel="stylesheet">
<style>
.about-banner {
    position: relative;
    width: 100%;
    height: 460px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
}
.about-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.34);
    z-index: 1;
    border-radius: 0 0 8px 8px;
}
.about-banner__content {
    position: relative;
    z-index: 2;
    width: 100%;
    text-align: center;
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: self-start;
    gap: 12px;
}
.breadcrumbs {
    font-family: 'Mulish', 'Raleway', Arial, sans-serif;
    font-size: 1rem;
    color: #fff;
    display: flex;
    justify-content: center;
    margin-bottom: 16px;
}
.breadcrumbs ul {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0;
    margin: 0;
}
.breadcrumbs a {
    color: #fff;
    text-decoration: none;
    opacity: 0.8;
}
.breadcrumbs a:hover {
    color: #C8956D;
    opacity: 1;
}
.breadcrumbs .separator {
    color: #e4e4e4;
    font-weight: 400;
}
.breadcrumbs .current {
    color: #fff;
    font-weight: 700;
    pointer-events: none;
    opacity: 1;
}
.about-main-title {
    font-family: 'Raleway', 'Mulish', Arial, sans-serif;
    font-size: 3.4rem;
    font-weight: 800;
    letter-spacing: 0.05em;
    margin: 0 0 12px 0;
    text-shadow: 0 2px 24px rgba(0,0,0,0.18);
}
.about-banner__subtitle {
    font-family: 'Mulish', 'Inter', Arial, sans-serif;
    font-size: 1.17rem;
    color: #fff;
    opacity: 0.93;
    margin-bottom: 8px;
    font-weight: 400;
    text-shadow: 0 1px 8px rgba(0,0,0,0.13);
}
.container {
    max-width: 1200px;
    margin: auto 10%;
    padding: 2rem;
}
.tours-hero__lead {
    font-size: 16px;
    color: #aaaaaa;
    margin: 56px 0;
    text-align: justify;
    line-height: 1.5;
    font-family: 'Inter';
}
.tours-list {
    display: flex;
    flex-direction: column;
    gap: 90px;
}
.tour-block {
    display: flex;
    gap: 54px;
    margin-bottom: 50px;
}
.tour-block__img {
    flex: 1.3;
    min-width: 320px;
}
.tour-block__img img {
    display: block;
    width: 100%;
    height: 450px;
    object-fit: cover;
    box-shadow: 0 10px 34px rgba(0,0,0,0.05);
}
.tour-block__content {
    flex: 1.7;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-top: 12px;
}
.tour-block__cat {
    color: #bbb;
    font-size: 16px;
    margin-bottom: 10px;
    font-family: 'Raleway', Arial, sans-serif;
    letter-spacing: 1.5px;
}
.tour-block__title {
    font-size: 38px;
    font-weight: 800;
    margin-bottom: 6px;
    font-family: 'Raleway', Arial, sans-serif;
    color: #232323;
}
.tour-block__subtitle {
    color: #333;
    font-size: 20px;
    margin-bottom: 10px;
}
.tour-block__line {
    width: 100px;
    height: 3px;
    background: #232323;
    margin: 12px 0 18px 0;
}
.tour-block__desc {
    font-size: 17px;
    color: #aaaaaa;
    margin-bottom: 26px;
    line-height: 1.6;
    font-family: 'Inter';
}
.tour-block__actions {
    display: flex;
    gap: 14px;
}
.btn {
    padding: 12px 32px;
    background: #181818;
    color: #fff;
    border: none;
    font-size: 15px;
    letter-spacing: 1px;
    cursor: pointer;
    text-transform: lowercase;
    transition: background 0.18s;
    box-shadow: 0 2px 12px #bdbdbd37;
    font-family: 'Inter';
}
.btn-black {
    background: #222;
    color: #fff;
}
.btn-outline {
    background: #fff;
    color: #232323;
    border: 2px solid #232323;
}
.btn-outline:hover {
    background: #232323;
    color: #fff;
}
.tour-block--reverse {
    flex-direction: row-reverse;
}
.fade-in-section {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.7s cubic-bezier(.22,.68,.42,1.01), transform 0.7s cubic-bezier(.22,.68,.42,1.01);
    will-change: opacity, transform;
}
.fade-in-section.visible {
    opacity: 1;
    transform: none;
}
@media (max-width: 900px) {
    .tour-block, .tour-block--reverse {
        flex-direction: column;
        gap: 26px;
        align-items: stretch;
    }
    .tour-block__img, .tour-block__content {
        width: 100%;
        min-width: 0;
        padding: 0;
    }
    .tour-block__title { font-size: 28px; }
}
@media (max-width: 540px) {
    .tours-hero__lead { font-size: 16px; }
    .tour-block__title { font-size: 22px; }
    .btn { padding: 10px 22px; font-size: 14px; }
}
</style>


<section class="about-banner fade-in-section" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/379410672_845717123525682_6733083808991049778_n.jpg?_t=1747850731');">
  <div class="about-banner__content container">
    <h1 class="about-main-title fade-in-section">TOURS</h1>
    <nav class="breadcrumbs fade-in-section" aria-label="Breadcrumb">
      <ul>
        <li><a href="/">Home</a></li>
        <li class="separator">/</li>
        <li class="current">Tours</li>
      </ul>
    </nav>
  </div>
</section>

<section class="tours-hero">
    <div class="container">
        <p class="tours-hero__lead fade-in-section">
            Step into the world of high fashion with our exclusive fashion tours across Paris, the French countryside, and Europe. Created for fashion enthusiasts, stylists, VIP clients, designers, and creatives, our experiences combine luxury, culture, and style in unforgettable journeys.
        </p>
    </div>
</section>

<section class="tours-list">
    <div class="container">
        @forelse($tours as $i => $tour)
            @php
                $locale = app()->getLocale();
                $title = mb_strtoupper($tour->getTranslation('title', $locale));
                $subtitle = $tour->getTranslation('subtitle', $locale);
                $desc = $tour->getTranslation('short_description', $locale);
                $mainImage = $tour->media->firstWhere('role', 'main_image');
                $imageUrl = $mainImage ? $mainImage->url : 'https://via.placeholder.com/800x450?text=No+Image';
            @endphp

            <div class="tour-block {{ $i % 2 == 1 ? 'tour-block--reverse' : '' }} fade-in-section">
                <div class="tour-block__img fade-in-section">
                    <img src="{{ $imageUrl }}" alt="{{ $title }}">
                </div>
                <div class="tour-block__content fade-in-section">
                    <div class="tour-block__cat">Fashion Tours</div>
                    <h2 class="tour-block__title">{{ $title }}</h2>
                    <div class="tour-block__subtitle">{{ $subtitle }}</div>
                    <div class="tour-block__line"></div>
                    <div class="tour-block__desc">{{ $desc }}</div>
                    <div class="tour-block__actions">
                        <a class="btn btn-black" href="{{ route('tours_2.show', ['locale' => $locale, 'slug' => $tour->slug ?: $tour->id]) }}">
                            {{ __('Discover') }}
                        </a>
                        <a href="#" class="btn btn-outline">{{ __('Reserve') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center">No tours found.</p>
        @endforelse
    </div>
</section>

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
            }, idx * 130);
            observer.unobserve(entry.target);
        });
    }, appearOptions);

    faders.forEach((fader, idx) => {
        appearOnScroll.observe(fader);
    });
});
</script>

<style>
/* вставлю в следующем сообщении */
</style>

@endsection

