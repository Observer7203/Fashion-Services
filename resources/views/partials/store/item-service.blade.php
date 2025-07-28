@extends('layouts.app')

@section('title', $product->title ?? 'Услуга')
@php
    $service = $product->service ?? null;
@endphp

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .custom-cart-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 20px; border: 1px solid black; background-color: white; color: black; font-size: 16px; border-radius: 3px; cursor: pointer; transition: all 0.2s; font-family: inherit; line-height: 1; }
    .custom-cart-btn.added, .custom-cart-btn:hover { background-color: black; color: white; }
    .cart-notify { position: fixed; top: 20px; right: 20px; background: #333; color: #fff; padding: 12px 20px; border-radius: 6px; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; z-index: 9999; }
    .cart-notify.show { opacity: 1; }
    .slide-title { color: #000; font-size: 40px; font-weight: 600; margin-bottom: 20px; }
    .subtitle { margin-bottom: 5px; }
    .product-section { padding: 100px 0; }
    .product-container { max-width: 1300px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 60px; align-items: flex-start; }
    .product-gallery { flex: 1 1 50%; max-width: 600px; }
    .product-info { flex: 1 1 40%; max-width: 500px; }
    .main-image img { width: 100%; height: 500px; object-fit: cover; border-radius: 3px; transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1); opacity: 1; }
    .main-image img.fade-out { opacity: 0; }
    .product-thumbs { margin-top: 20px; }
    .product-thumbs .swiper-slide { width: 100px; height: 180px; cursor: pointer; opacity: 0.5; transition: 0.3s; }
    .product-thumbs .swiper-slide-thumb-active { opacity: 1; }
    .product-thumbs img { width: 100%; height: 100%; object-fit: cover; border-radius: 4px; border: 2px solid #ccc; }
    .price { font-size: 24px; margin: 20px 0; font-weight: bold; }
    .product-description p { font-size: 16px; line-height: 1.7; color: #444; margin-bottom: 30px; }
    .qty-and-button { display: flex; align-items: flex-end; gap: 30px; margin-bottom: 30px; flex-wrap: wrap; }
    .cart-button-block { width: 200px; }
    .service-includes { margin-bottom: 18px; }
    .service-includes h5 { font-size: 16px; font-weight: 700; margin-bottom: 7px; }
    .service-includes ul { padding-left: 20px; list-style: disc; }
    .additional-options { margin-bottom: 24px; }
    .additional-options h5 { font-size: 16px; font-weight: 700; color: #232120; margin-bottom: 14px; }
    .additional-option-row { display: flex; align-items: center; justify-content: space-between; font-size: 15px; padding: 0 0 7px 0; color: #363636; font-weight: 500; }
    .additional-option-row label { display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 400; }
    .additional-option-row input[type="checkbox"] { accent-color: #333; width: 18px; height: 18px; margin-right: 8px; }
    .additional-option-price { font-weight: 600; color: #222; min-width: 85px; text-align: right; font-size: 15px; }
    .total-price { font-size: 20px; font-weight: 600; color: #222; margin-top: 20px; margin-bottom: 18px; }
    .product-extra { margin-top: 25px; font-size: 15px; color: #4a4a4a; }
</style>

<section class="white-section product-section change-header-color" data-bgcolor="#ffffff">
    <div class="product-container">
        <!-- Галерея -->
        <div class="product-gallery">
            <div class="main-image mb-0">
                @php
                    $mainImage = (!empty($product->media) && count($product->media) > 0 && !empty($product->media[0]))
                        ? (is_string($product->media[0]) ? $product->media[0] : $product->media[0]->getUrl())
                        : '/images/no-image.png';
                @endphp
                <img id="mainProductImage" src="{{ $mainImage }}" alt="{{ $product->title }}">
            </div>
            @if(!empty($product->media) && count($product->media) > 1)
            <div class="swiper product-thumbs">
                <div class="swiper-wrapper">
                    @foreach($product->media as $media)
                        <div class="swiper-slide">
                            <img src="{{ is_string($media) ? $media : $media->getUrl() }}" alt="Фото {{ $loop->iteration }}" data-full="{{ is_string($media) ? $media : $media->getUrl() }}">
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Инфо услуги -->
        <div class="product-info">
            <h1 class="slide-title mb-4"><span>{{ $product->title ?? 'Название услуги' }}</span></h1>
            @if(!empty($product->subtitle))
                <div class="subtitle mb-4"><span>{{ $product->subtitle }}</span></div>
            @endif
            <div class="price mb-4">{{ number_format($product->price, 0, '', ' ') }}&nbsp;{{ $product->currency ?? '₸' }}</div>
            
            <div class="product-description mb-6">
                @if(!empty($product->description))
                    <p>{!! nl2br(e($product->description)) !!}</p>
                @endif
            </div>

            @if($service->includes && $service->includes->count())
                <div class="service-includes">
                    <h5>Что входит:</h5>
                    <ul>
                        @foreach($service->includes as $include)
                            <li>{{ $include->getTranslation('title', app()->getLocale()) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('bucket.add') }}" id="addToCartForm">
                @csrf
                <input type="hidden" name="type" value="service">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="service_id" value="{{ $service->id ?? '' }}">
                <input type="hidden" name="title" value="{{ $product->title }}">
                <input type="hidden" name="currency" value="{{ $product->currency ?? '₸' }}">
                <input type="hidden" name="qty" id="inputQty" value="1">
                <input type="hidden" name="price" id="basePrice" value="{{ $product->price }}">
                {{-- Динамически будут добавляться опции через JS --}}
                
                <!-- ДОП ОПЦИИ -->
                @if($service && $service->options && $service->options->count())
                    <div class="additional-options">
                        <h5>Дополнительные опции:</h5>
                        @foreach($service->options as $option)
                            <div class="additional-option-row">
                                <label>
                                    <input type="checkbox" class="add-opt" data-price="{{ $option->price }}" data-id="{{ $option->id }}" name="options[]" value="{{ $option->id }}">
                                    {{ $option->getTranslation('title', app()->getLocale()) }}
                                </label>
                                <span class="additional-option-price">
                                    +{{ number_format($option->price, 0, '', ' ') }}&nbsp;{{ $product->currency ?? '₸' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Итоговая цена -->
                <div class="total-price" id="totalPrice">
                    Итого: {{ number_format($product->price, 0, '', ' ') }}&nbsp;{{ $product->currency ?? '₸' }}
                </div>

                <div class="qty-and-button">
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
                    <div id="cartNotify" class="cart-notify">Услуга добавлена в корзину</div>
                </div>
            </form>

            <div class="product-extra">
                <b>Оплата:</b> онлайн, на карту или по реквизитам<br>
                <b>Доступно:</b> {{ $product->available ?? 'Франция, Казахстан, онлайн' }}<br>
                <b>Связь:</b> WhatsApp / Telegram / Email
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Swiper thumbs
    document.addEventListener('DOMContentLoaded', function () {
        if (document.querySelector('.product-thumbs')) {
            const thumbsSwiper = new Swiper('.product-thumbs', {
                slidesPerView: 3,
                spaceBetween: 10,
                breakpoints: { 0: { slidesPerView: 2 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
            });
            document.querySelectorAll('.product-thumbs img').forEach(img => {
                img.addEventListener('click', function () {
                    const newSrc = this.getAttribute('data-full');
                    const mainImg = document.getElementById('mainProductImage');
                    mainImg.classList.add('fade-out');
                    setTimeout(() => { mainImg.src = newSrc; }, 180);
                    mainImg.onload = () => { mainImg.classList.remove('fade-out'); };
                    document.querySelectorAll('.product-thumbs .swiper-slide').forEach(slide => {
                        slide.classList.remove('swiper-slide-thumb-active');
                    });
                    this.closest('.swiper-slide').classList.add('swiper-slide-thumb-active');
                });
            });
        }

        // Пересчет итоговой цены услуги при выборе опций
        let basePrice = Number(document.getElementById('basePrice').value);
        let currency = document.querySelector('input[name="currency"]').value;
        const options = document.querySelectorAll('.add-opt');
        const totalPriceElem = document.getElementById('totalPrice');

        function recalcTotal() {
            let total = basePrice;
            options.forEach(opt => {
                if (opt.checked) total += Number(opt.dataset.price);
            });
            if(totalPriceElem) {
                totalPriceElem.innerHTML = `Итого: ${total.toLocaleString('ru-RU')}&nbsp;${currency}`;
            }
        }
        options.forEach(opt => opt.addEventListener('change', recalcTotal));
        recalcTotal();

        // Кнопка добавить в корзину
        document.getElementById('addToCartForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('addToCartBtn');
            const text = btn.querySelector('.btn-text');
            const notify = document.getElementById('cartNotify');
            btn.classList.add('added');
            text.textContent = 'В Корзине';
            notify.classList.add('show');
            setTimeout(() => {
                notify.classList.remove('show');
                btn.classList.remove('added');
                text.textContent = 'В Корзину';
            }, 1600);
        });
    });
</script>
@endpush

@endsection
