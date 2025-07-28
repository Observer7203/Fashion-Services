@extends('layouts.app')

@section('content')

<!-- Swiper CSS/JS (CDN) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<style>
    .custom-cart-btn {
        display: inline-flex;
        align-items: center; 
        justify-content: center;
        gap: 8px;
        padding: 10px 20px;
        border: 1px solid black;
        background-color: white;
        color: black;
        font-size: 16px;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
        line-height: 1;
    }
    .custom-cart-btn svg { width: 18px; height: 18px; }
    .custom-cart-btn:hover, .custom-cart-btn.added { background-color: black; color: white; }
    .cart-notify { position: fixed; top: 20px; right: 20px; background: #333; color: #fff; padding: 12px 20px; border-radius: 6px; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; z-index: 9999; }
    .cart-notify.show { opacity: 1; }
    .attribute-btn, .color-swatch {
        padding: 10px 16px; font-size: 14px; border: 1px solid #ccc; background: #fff; border-radius: 3px; cursor: pointer; transition: all 0.2s;
    }
    .attribute-btn.active, .color-swatch.active { border-color: black; background-color: black; color: white; }
    .color-swatch { width: 35px; height: 35px; border-radius: 50%; padding: 0; margin-right: 8px; border-width: 2px; }
    .qty-and-button { display: flex; align-items: flex-end; justify-content: space-between; gap: 30px; margin-bottom: 30px; flex-wrap: wrap; }
    .cart-button-block { width: 200px; }
    .slide-title { color: #000; font-size: 40px; font-weight: 600; margin-bottom: 20px; margin-top: 30px; }
    .subtitle { margin-bottom: 5px; }
    .product-gallery { max-width: 600px; margin-top: 30px; }
.main-image img { width: 100%; height: 700px; object-fit: cover; border-radius: 3px; transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1); opacity: 1; }
.main-image img.fade-out { opacity: 0; }
.product-thumbs { margin-top: 20px; }
.product-thumbs .swiper-slide { width: 100px; height: 150px; cursor: pointer; opacity: 0.5; transition: 0.3s; }
.product-thumbs .swiper-slide-thumb-active { opacity: 1; }
.product-thumbs img { width: 100%; height: 100%; object-fit: cover; border-radius: 4px; border: 2px solid #ccc; }
.color-swatch { width: 39px; height: 39px; border-radius: 50%; border: 2px solid #ccc; background: #fff; padding: 0; margin-right: 8px; }
.color-swatch.active, .color-swatch:focus, .color-swatch:hover { border: 2px solid #000; }
.attribute-btn { padding: 10px 16px; font-size: 14px; border: 1px solid #ccc; background: #fff; border-radius: 3px; cursor: pointer; transition: all 0.2s; }
.attribute-btn.active { border-color: black; background-color: black; color: white; }
.qty-and-button { display: flex; align-items: flex-end; justify-content: space-between; gap: 30px; margin-bottom: 30px; flex-wrap: wrap; }
.cart-button-block { width: 200px; }
.custom-cart-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 20px; border: 1px solid black; background-color: white; color: black; font-size: 16px; border-radius: 3px; cursor: pointer; transition: all 0.2s; font-family: inherit; line-height: 1; }
.custom-cart-btn.added, .custom-cart-btn:hover { background-color: black; color: white; }
.cart-notify { position: fixed; top: 20px; right: 20px; background: #333; color: #fff; padding: 12px 20px; border-radius: 6px; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; z-index: 9999; }
.cart-notify.show { opacity: 1; }
.slide-title { color: #000; font-size: 40px; font-weight: 600; margin-bottom: 20px; margin-top: 30px; }
.subtitle { margin-bottom: 5px; }
</style>

<div id="page-content" class="light-content" data-bgcolor="#fff">
    <section class="white-section product-section change-header-color" data-bgcolor="#ffffff">
        <div class="product-container flex flex-col lg:flex-row gap-10 px-6 py-10">
            {{-- Галерея изображений --}}
        <!-- Галерея Swiper -->
        <div class="product-gallery">
            <div class="main-image mb-0">
                <img id="mainProductImage" src="{{ $product->media[0] ?? '/images/placeholder.jpg' }}" alt="Main">
            </div>
            @if(!empty($product->media) && count($product->media) > 1)
            <div class="swiper product-thumbs mt-5">
                <div class="swiper-wrapper">
                    @foreach($product->media as $image)
                        <div class="swiper-slide">
                            <img src="{{ $image }}" alt="Thumb" data-full="{{ $image }}">
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
            {{-- Информация о продукте --}}
            <div class="product-info w-full lg:w-1/2">
                <h1 class="slide-title mb-4"><span>{{ $product->title ?? 'Название товара' }}</span></h1>
                <div class="subtitle mb-4"><span>{{ $product->subtitle ?? '' }}</span></div>
                <div class="text-2xl font-semibold mb-6 price">
                    {{ number_format($product->price, 0, '.', ' ') }} {{ $product->currency ?? '₸' }}
                </div>
                <div class="product-description mb-6 leading-relaxed text-lg">
                    <p>{{ $product->description ?? 'Описание отсутствует.' }}</p>
                </div>
                {{-- Атрибуты: размер и цвет --}}
                <form method="POST" action="{{ route('bucket.add') }}" id="addToCartForm">
                    @csrf
                    <input type="hidden" name="type" value="wear">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="title" value="{{ $product->title }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <input type="hidden" name="currency" value="{{ $product->currency ?? '₸' }}">
                    <input type="hidden" name="qty" id="inputQty" value="1">
                    <input type="hidden" name="size" id="inputSize" value="">
                    <input type="hidden" name="color" id="inputColor" value="">
                    <div class="attribute-buttons-wrapper mb-6">
                        <div class="attribute-group">
                            <label class="attribute-label">Размер:</label>
                            <div class="attribute-options" id="sizeOptions">
                                @php
                                    $sizes = !empty($product->attributes['sizes'])
                                        ? (is_array($product->attributes['sizes'])
                                            ? $product->attributes['sizes']
                                            : explode(',', $product->attributes['sizes']))
                                        : [];
                                @endphp
                                @forelse($sizes as $size)
                                    @if(trim($size))
                                        <button type="button" class="attribute-btn size-btn" data-value="{{ trim($size) }}">{{ trim($size) }}</button>
                                    @endif
                                @empty
                                    <button class="attribute-btn" disabled>Нет размеров</button>
                                @endforelse
                            </div>
                        </div>
                        <div class="attribute-group">
                            <label class="attribute-label">Цвет:</label>
                            <div class="attribute-options" id="colorOptions">
                                @php
                                    $colors = !empty($product->attributes['colors'])
                                        ? (is_array($product->attributes['colors'])
                                            ? $product->attributes['colors']
                                            : explode(',', $product->attributes['colors']))
                                        : [];
                                    $colorMap = [
                                        'чёрный' => '#222','черный' => '#222','белый' => '#fff','красный' => '#d4213c',
                                        'синий' => '#355582','бежевый' => '#e2c49a','зелёный' => '#247a57','зеленый' => '#247a57',
                                    ];
                                @endphp
                                @forelse($colors as $color)
                                    @php
                                        $c = mb_strtolower(trim($color));
                                        $style = isset($colorMap[$c]) ? "background: {$colorMap[$c]};" : '';
                                    @endphp
                                    <button type="button" class="attribute-btn color-swatch color-btn" data-value="{{ trim($color) }}" style="{{ $style }}" title="{{ trim($color) }}"></button>
                                @empty
                                    <button class="attribute-btn color-swatch" disabled>Нет цветов</button>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="qty-and-button">
                        <div class="qty-block">
                            <label for="quantity" class="qty-label">Количество</label>
                            <div class="qty-inner">
                                <input id="quantity" type="number" min="1" max="{{ $product->quantity ?? 10 }}" value="1" class="product-qty-input">
                                <span class="qty-available">В наличии: {{ $product->quantity ?? 10 }} шт</span>
                            </div>
                        </div>
                        <div class="cart-button-block">
                            <button type="submit" id="addToCartBtn" class="custom-cart-btn">
                                <span class="btn-text">В Корзину</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="cart-icon" viewBox="0 0 24 24" fill="none">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 
                                        1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 
                                        1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 
                                        1 5.513 7.5h12.974c.576 0 1.059.435 
                                        1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 
                                        0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 
                                        1-.75 0 .375.375 0 0 1 .75 0Z"
                                        stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                            </button>
                        </div>
                        <div id="cartNotify" class="cart-notify">✔️ Товар добавлен в корзину</div>
                    </div>
                </form>
                <div class="mb-6">
                    <h5 class="mb-1 font-semibold">Характеристики:</h5>
                    <ul class="text-sm list-disc list-inside text-gray-700 leading-relaxed">
                        @if(!empty($product->attributes['chars']))
                            @php $chars = preg_split('/\r\n|\r|\n/', $product->attributes['chars']); @endphp
                            @foreach($chars as $line)
                                @if(trim($line) !== '')<li>{{ $line }}</li>@endif
                            @endforeach
                        @else
                            <li>Нету характеристик</li>
                        @endif
                    </ul>
                </div>
                <div class="product-extra text-sm">
                    <h5 class="mb-1 font-semibold">Доставка</h5>
                    <p>Доставка за ваш счет.<br>Отправка из Парижа.</p>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    // Галерея
    document.addEventListener('DOMContentLoaded', function () {
    // Swiper thumbs
    const thumbsSwiper = new Swiper('.swiper', {
        slidesPerView: 3,
        spaceBetween: 10,
        breakpoints: {
            0: { slidesPerView: 2 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    });

    // Main image change
    document.querySelectorAll('.swiper img').forEach(img => {
        img.addEventListener('click', function () {
            const newSrc = this.getAttribute('data-full');
            const mainImg = document.getElementById('mainProductImage');
            mainImg.classList.add('fade-out');
            setTimeout(() => {
                mainImg.src = newSrc;
            }, 180);
            mainImg.onload = () => {
                mainImg.classList.remove('fade-out');
            };
            document.querySelectorAll('.swiper .swiper-slide').forEach(slide => {
                slide.classList.remove('swiper-slide-thumb-active');
            });
            this.closest('.swiper-slide').classList.add('swiper-slide-thumb-active');
        });
    });

    // Логика выбора размера и цвета и отправки в корзину
    let selectedSize = '', selectedColor = '';
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedSize = btn.dataset.value;
            document.getElementById('inputSize').value = selectedSize;
        });
    });
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedColor = btn.dataset.value;
            document.getElementById('inputColor').value = selectedColor;
        });
    });
    document.getElementById('quantity').addEventListener('change', function() {
        document.getElementById('inputQty').value = this.value;
    });
    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
        // Можно добавить required для размера/цвета
        if (document.getElementById('inputSize').value === '' || document.getElementById('inputColor').value === '') {
            alert('Выберите размер и цвет!');
            e.preventDefault();
            return false;
        }
        // Логирование (для дебага)
        const formData = new FormData(this); let data = {};
        for (let [key, value] of formData.entries()) data[key] = value;
        console.log('В корзину отправляется:', data);
        // UI
        const btn = document.getElementById('addToCartBtn');
        const text = btn.querySelector('.btn-text');
        const notify = document.getElementById('cartNotify');
        btn.classList.add('added'); text.textContent = 'В Корзине';
        notify.classList.add('show');
        setTimeout(() => {
            notify.classList.remove('show');
            btn.classList.remove('added');
            text.textContent = 'В Корзину';
        }, 2000);
    });
});
</script>
@endpush

@endsection

