@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
@php
    $tour = $product->tour ?? null;
@endphp
<section class="white-section product-section change-header-color" data-bgcolor="#ffffff">
    <div class="product-container flex flex-col lg:flex-row gap-10 px-6 py-10">
        <!-- Галерея -->
        <div class="product-gallery">
            <div class="main-image">
                <img id="mainProductImage"
                     src="{{ $tour->media[0]['url'] ?? '/images/no-image.png' }}"
                     alt="{{ $tour->title }}">
            </div>
            @if(!empty($tour->media) && count($tour->media) > 1)
            <div class="swiper product-thumbs">
                <div class="swiper-wrapper">
                    @foreach($tour->media as $media)
                        <div class="swiper-slide">
                            <img src="{{ $media['url'] }}" data-full="{{ $media['url'] }}">
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <!-- Правая часть -->
        <div class="product-info w-full lg:w-1/2">
            <h1 class="slide-title mb-4"><span>{{ $tour->title }}</span></h1>
            <div class="subtitle mb-4"><span>{{ $tour->subtitle }}</span></div>
            <div class="product-description mb-4"><p>{{ $tour->description }}</p></div>
            
            <form id="tourBookForm" method="POST" action="{{ route('bucket.add') }}">
                @csrf
                <input type="hidden" name="type" value="tour">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                <input type="hidden" name="title" value="{{ $tour->title }}">
                <input type="hidden" name="currency" value="{{ $tour->currency ?? '₸' }}">
                <input type="hidden" name="price" id="hiddenTourPrice" value="{{ $tour->packages[0]->price ?? 0 }}">
                <input type="hidden" name="qty" id="hiddenPersonsQty" value="1">
                <input type="hidden" name="package_id" id="hiddenPackageId" value="{{ $tour->packages[0]->id ?? '' }}">
                <input type="hidden" name="options[]" id="hiddenTourOptions">

                <!-- Пакеты тура -->
                <div class="attribute-group" style="margin-bottom:18px">
                    <label class="attribute-label">Пакет тура:</label>
                    <div class="attribute-options" id="packageOptions">
                        @foreach($tour->packages as $idx => $package)
                        <button
                            type="button"
                            class="attribute-btn{{ $idx == 0 ? ' active' : '' }}"
                            data-id="{{ $package->id }}"
                            data-price="{{ $package->price }}"
                            data-includes='@json($package->includes->map->getTranslation("content", app()->getLocale()))'
                        >
                            {{ $package->getTranslation('title', app()->getLocale()) }}<br>
                            <span style="font-weight:400;color:#888;">
                                от {{ number_format($package->price, 0, '', ' ') }} {{ $package->currency ?? '₸' }}
                            </span>
                        </button>
                        @endforeach
                    </div>
                </div>
                <!-- Количество -->
                <div class="attribute-group" style="margin-bottom:18px">
                    <label class="attribute-label">Количество участников:</label>
                    <input type="number" name="qty" id="tourPersons" class="product-qty-input" min="1" max="10" value="1" style="width:60px;">
                </div>
                <!-- Итоговая стоимость -->
                <div class="total-price" style="margin-bottom:18px;">
                    Итого: <span id="totalTourPrice">{{ number_format($tour->packages[0]->price, 0, '', ' ') }}&nbsp;{{ $tour->currency ?? '₸' }}</span>
                </div>
                
                <!-- Что включено -->
                <div class="included-list" style="margin-bottom:18px">
                    <h5>Что включено</h5>
                    <ul class="included-list-ul" id="includedList">
                        @foreach($tour->packages[0]->includes as $inc)
                            <li>{{ $inc->getTranslation('content', app()->getLocale()) }}</li>
                        @endforeach
                    </ul>                
                </div>
                <!-- Дополнительные опции -->
                @if($tour->options && $tour->options->count())
                <div class="additional-options" style="margin-bottom:20px;">
                    <h5>Дополнительные опции</h5>
                    <ul class="included-list-ul additional-options-list">
                        @foreach($tour->options as $addon)
                            <li class="additional-option-row">
                                <label>
                                    <input type="checkbox" class="add-opt" name="options[]" value="{{ $addon->id }}" data-price="{{ $addon->price }}">
                                    {{ $addon->getTranslation('title', app()->getLocale()) }}
                                </label>
                                <span class="additional-option-price">+{{ number_format($addon->price, 0, '', ' ') }}&nbsp;{{ $tour->currency ?? '₸' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif        

                <div>
                    <button id="bookTourBtn" type="submit" class="custom-cart-btn">
                        <span class="btn-text">Забронировать тур</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="cart-icon" viewBox="0 0 24 24" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" stroke="currentColor" stroke-width="1.5"/></svg>
                    </button>
                </div>
                <div id="cartNotify" class="cart-notify">Запрос на бронирование отправлен</div>
            </form>
        </div>
    </div>
</section>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageBtns = document.querySelectorAll('#packageOptions .attribute-btn');
    const includedList = document.getElementById('includedList');
    const personsInput = document.getElementById('tourPersons');
    const totalTourPrice = document.getElementById('totalTourPrice');
    const hiddenTourPrice = document.getElementById('hiddenTourPrice');
    const hiddenPersonsQty = document.getElementById('hiddenPersonsQty');
    const hiddenPackageId = document.getElementById('hiddenPackageId');
    const currency = @json($tour->currency ?? '₸');
    
    function getActivePkg() {
        return document.querySelector('#packageOptions .attribute-btn.active');
    }

    function updateIncludedList(btn) {
        let includes = [];
        try {
            includes = JSON.parse(btn.dataset.includes);
        } catch (e) {}
        includedList.innerHTML = '';
        includes.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item;
            includedList.appendChild(li);
        });
    }

    function updateTotal() {
        const activeBtn = getActivePkg();
        const base = parseInt(activeBtn.dataset.price, 10);
        const pkgId = activeBtn.dataset.id;
        const qty = parseInt(personsInput.value, 10);
        let sum = base * qty;
        document.querySelectorAll('.additional-options-list .add-opt:checked').forEach(opt => {
            sum += parseInt(opt.dataset.price, 10) * qty;
        });
        totalTourPrice.innerHTML = `${sum.toLocaleString('ru-RU')}&nbsp;${currency}`;
        hiddenTourPrice.value = sum;
        hiddenPersonsQty.value = qty;
        hiddenPackageId.value = pkgId;
    }

    // init
    updateIncludedList(getActivePkg());
    updateTotal();

    packageBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            packageBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            updateIncludedList(this);
            updateTotal();
        });
    });

    personsInput.addEventListener('change', updateTotal);

    document.querySelectorAll('.additional-options-list .add-opt').forEach(opt => {
        opt.addEventListener('change', updateTotal);
    });

    // Swiper thumbs
    if (typeof Swiper !== "undefined") {
        new Swiper('.swiper', {
            slidesPerView: 3,
            spaceBetween: 10,
            breakpoints: {
                0: { slidesPerView: 2 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });
    }
});
</script>



   
<style>

    .slide-title, #showcase-carousel-holder .swiper-slide .outer .slide-title {
            line-height: 60px;
        }
        .product-info .slide-title {
        margin-top: 30px !important;
    }
        
                      /* Дополнительные опции */
                        .additional-options {
                            margin-bottom: 24px;
                        }
                        .additional-options h5 {
                            font-weight: 700;
                            margin-bottom: 12px;
                            font-size: 19px;
                        }
                        .additional-options-list {
                            list-style: none;
                            padding: 0;
                            margin: 0;
                        }
                        .additional-option-row {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            font-size: 16px;
                            margin-bottom: 10px;
                            background: none;
                            border: none;
                            padding: 0;
                            border-radius: 0;
                        }
                        .additional-option-row label {
                            display: flex;
                            align-items: center;
                            font-weight: 400;
                            gap: 10px;
                            cursor: pointer;
                            user-select: none;
                        }
                        .additional-option-row input[type="checkbox"] {
                            accent-color: #d4213c;
                            width: 22px;
                            height: 22px;
                            margin-right: 9px;
                            border-radius: 4px;
                        }
                        .additional-option-price {
                            font-weight: 500;
                            font-size: 16px;
                            color: #333;
                            white-space: nowrap;
                        }
    
                        /* Итоговая стоимость */
                        .total-price {
                            font-size: 21px;
                            font-weight: 700;
                            margin-bottom: 20px;
                        }
    
                        /* Что включено — обычный маркированный список */
                        .included-list h5 {
                            font-size: 18px;
                            font-weight: 700;
                            margin-bottom: 8px;
                        }
                        .included-list-ul {
                            list-style: disc inside;
                            margin: 0;
                            padding-left: 0;
                        }
                        .included-list-ul li {
                            font-size: 16px;
                            color: #111;
                            margin-bottom: 7px;
                            line-height: 1.65;
                            position: relative;
                            left: 0;
                        }
                        /* Плавное появление/скрытие для блока "что включено" */
                        .included-list-ul {
                            transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1);
                            opacity: 1;
                        }
                        .included-list-ul.fading {
                            opacity: 0;
                            pointer-events: none;
                        }
    
                        /* Плавное изменение итоговой суммы */
                        #totalTourPrice {
                            display: inline-block;
                            transition: color 0.35s, transform 0.35s;
                        }
                        #totalTourPrice.price-anim {
                            color: #d4213c;
                            transform: scale(1.09);
                        }
    
                      </style>
                      <style>
                        .included-list h5 {
                            font-size: 16px;
                            font-weight: 700;
                            color: #232120;
                            margin-bottom: 14px;
                            letter-spacing: 0.02em;
                        }
                        .included-list-ul {
                            list-style: disc;
                            margin-left: 20px;
                            padding-left: 0;
                            color: #333;
                            font-size: 15px;
                            margin-bottom: 10px;
                        }
                        .included-list-ul li {
                            color: #333 !important;
                        }
                        .attribute-group {
                            display: flex;
                            flex-direction: column;
                            gap: 10px;
                        }
                        .attribute-options {
                            display: flex;
                            gap: 10px;
                            margin-top: 5px;
                            flex-wrap: wrap;
                        }
                        .attribute-btn {
                            padding: 10px 16px;
                            font-size: 14px;
                            border: 1px solid #ccc;
                            background: #fff;
                            border-radius: 3px;
                            cursor: pointer;
                            transition: all 0.2s;
                        }
                        .attribute-btn.active {
                            border-color: black;
                            background-color: black;
                            color: white;
                        }
                        .total-price {
                            font-size: 20px;
                            font-weight: 700;
                            color: #222;
                            margin-top: 20px;
                            margin-bottom: 18px;
                            letter-spacing: 0.02em;
                        }
    
    
                            #logo img {
                            height: 70px;
                            }
                        
                        .service-includes li {
                            color: #333;
                        }
                        
    
                        .custom-cart-btn {
                            display: inline-flex;
                            align-items: center; /* 👈 ВЫРАВНИВАЕМ ПО ЦЕНТРУ */
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
    
                        .custom-cart-btn svg {
                            width: 18px;
                            height: 18px;
                            flex-shrink: 0;
                            display: inline-block;
                        }
    
    
                        .custom-cart-btn:hover {
                            background-color: black;
                            color: white;
                        }
    
                        .custom-cart-btn.added {
                            background-color: black;
                            color: white;
                        }
    
                        .btn-icon {
                            width: 20px;
                            height: 20px;
                        }
    
                        .cart-notify {
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            background: #333;
                            color: #fff;
                            padding: 12px 20px;
                            border-radius: 6px;
                            opacity: 0;
                            pointer-events: none;
                            transition: opacity 0.3s ease;
                            z-index: 9999;
                        }
    
                        .cart-notify.show {
                            opacity: 1;
                        }
    
    
                    .button-text {
                        font-weight: 400;
                        font-family: 'Mulish';
                        font-size: 16px;
                    }
    
                    .qty-and-button {
                        display: flex;
                        align-items: flex-end;
                        justify-content: space-between;
                        gap: 30px;
                        margin-bottom: 30px;
                        flex-wrap: wrap;
                    }
    
                    .qty-block {
                        flex-grow: 1;
                        max-width: 200px;
                    }
    
                    .cart-button-block {
                        width: 200px;
                    }
    
                    .qty-label {
                        display: block;
                        font-weight: 600;
                        font-size: 14px;
                        margin-bottom: 5px;
                    }
    
                    .qty-inner {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                    }
    
                    .product-qty-input {
                        width: 80px;
                        padding: 8px;
                        border: 1px solid #ccc;
                        border-radius: 6px;
                        text-align: center;
                        font-size: 14px;
                    }
    
                    .qty-available {
                        font-size: 13px;
                        color: #777;
                    }
    
                    .cart-button-block {
                        flex-shrink: 0;
                    }
    
    
                        .quantity-wrap {
                            display: flex;
                            flex-direction: column;
                            gap: 6px;
                        }
    
                        .light-content .button-text {
                            color: #0e0e0e;
                        } 
                        .light-content .button-icon {
                            color: #0e0e0e;
                        } 
    
                        .light-content #main .button-text span::after {
                            background: rgba(0, 0, 0, 0.1);
                        }
    
                        .price {
                            margin-bottom: 5px;
                            font-size: 20px;
                        }
    
                        .subtitle {
                            margin-bottom: 5px;
                        }
    
                        .list-disc li {
                            color: #333;
                        }
    
                        .attribute-buttons-wrapper {
                            display: flex;
                            flex-wrap: wrap;
                            gap: 30px;
                            margin-bottom: 30px;
                        }
    
                        .attribute-group {
                            display: flex;
                            flex-direction: column;
                            gap: 10px;
                        }
    
                        .attribute-label {
                            font-weight: 600;
                            font-size: 16px;
                        }
    
                        .attribute-options {
                            display: flex;
                            flex-wrap: wrap;
                            gap: 10px;
                        }
    
                        .attribute-btn {
                            padding: 10px 16px;
                            font-size: 14px;
                            border: 1px solid #ccc;
                            background: #fff;
                            border-radius: 3px;
                            cursor: pointer;
                            transition: all 0.2s;
                        }
    
                        .attribute-btn:hover {
                            background-color: #f0f0f0;
                        }
    
                        .attribute-btn.active {
                            border-color: black;
                            background-color: black;
                            color: white;
                        }
    
    
    
                        .product-select {
                            width: 100%;
                            padding: 8px 12px;
                            border: 1px solid #ccc;
                            border-radius: 6px;
                            background-color: #fff;
                            font-size: 14px;
                        }
    
                        .product-qty-input {
                            width: 60px;
                            padding: 8px;
                            border: 1px solid #ccc;
                            border-radius: 3px;
                            text-align: center;
                            font-size: 14px;
                        }
    
    
                        .slide-title {
                            text-align: left; 
                            margin: 0px !important;
                        }
    
                        .slide-title {
                            color: #000;
                            font-size: 40px;
                            font-weight: 600;
                            margin-bottom: 20px;
                        }
                        
                        .slide-title span {
                        transform: translateY(0px);
                        opacity: 1;
                        }
    
                        .subtitle span {
                        transform: translateY(0px);
                        opacity: 1;
                        }
    
                        .product-gallery {
                        max-width: 600px;
                        margin-top: 30px;
                        }
                        .main-image img {
                        width: 100%;
                        height: 500px;
                        object-fit: cover;
                        border-radius: 3px;
                        transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1);
                        opacity: 1;
                        }
                        .main-image img.fade-out {
                            opacity: 0;
                        }
                        .product-thumbs {
                        margin-top: 20px;
                        }
                        .product-thumbs .swiper-slide {
                        width: 100px;
                        height: 180px;
                        cursor: pointer;
                        opacity: 0.5;
                        transition: 0.3s;
                        }
                        .product-thumbs .swiper-slide-thumb-active {
                        opacity: 1;
                        }
                        .product-thumbs img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        border-radius: 4px;
                        border: 2px solid #ccc;
                        }
                        .bucket .button-icon {
                            height: 35px;
                            width: 35px;
                        }
                        .additional-options {
                            margin-bottom: 24px;
                        }
    
                        .additional-options h5 {
                            font-size: 16px;
                            font-weight: 700;
                            color: #232120;
                            margin-bottom: 14px;
                            letter-spacing: 0.02em;
                        }
    
                        .additional-options-list {
                            list-style: none;
                            margin: 0;
                            padding: 0;
                        }
    
                        .additional-option-row {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            font-size: 15px;
                            padding: 0 0 7px 0;
                            color: #363636 !important;
                            font-weight: 500;
                            border: none;
                            background: none;
                        }
    
                        .additional-option-row label {
                            display: flex;
                            align-items: center;
                            gap: 8px;
                            cursor: pointer;
                            font-weight: 400;
                        }
    
                        .additional-option-row input[type="checkbox"] {
                            accent-color: #333;
                            width: 18px;
                            height: 18px;
                            margin-right: 8px;
                        }
    
                        .additional-option-price {
                            font-weight: 600;
                            color: #222;
                            min-width: 85px;
                            text-align: right;
                            font-size: 15px;
                        }
    
                        .total-price {
                            font-size: 20px;
                            font-weight: 600;
                            font-family: 'Mulish';
                            color: #222;
                            margin-top: 20px;
                            margin-bottom: 18px;
                            letter-spacing: 0.02em;
                        }
    
    
                    </style>
                    
                    
                    <style>
                        .product-section {
                            padding: 100px 0;
                        }

                        .product-container {
                            max-width: 1300px;
                            margin: 0 auto;
                            display: flex;
                            flex-wrap: wrap;
                            gap: 60px;
                            align-items: flex-start;
                        }

                        .product-gallery {
                            flex: 1 1 50%;
                            max-width: 600px;
                        }

                        .product-info {
                            flex: 1 1 40%;
                            max-width: 500px;
                        }

                        .product-image {
                            width: 100%;
                            border-radius: 10px;
                            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                        }

                        .product-price {
                            font-size: 24px;
                            margin: 20px 0;
                            font-weight: bold;
                        }

                        .product-description p {
                            font-size: 16px;
                            line-height: 1.7;
                            color: #444;
                            margin-bottom: 30px;
                        }

                        .product-actions .link {
                            display: inline-flex;
                            align-items: center;
                            padding: 10px 20px;
                            background: black;
                            color: white;
                            border-radius: 30px;
                            text-transform: uppercase;
                            transition: transform 0.3s;
                        }

                        .product-actions .link:hover {
                            transform: scale(1.05);
                        }

                    </style>
@endpush
@endsection

