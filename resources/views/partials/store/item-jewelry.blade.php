@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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

    #logo img {
    height: 70px;
    }


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

<div id="page-content" class="light-content" data-bgcolor="#fff">
    <section class="white-section product-section change-header-color" data-bgcolor="#ffffff">
        <div class="product-container flex flex-col lg:flex-row gap-10 px-6 py-10">

            
            {{-- Галерея изображений --}}
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
                
                <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
                <script>

                    console.log('===> Swiper JS файл подключен:', typeof Swiper);
                    document.addEventListener('DOMContentLoaded', function() {
                        if (window.Swiper) {
                            const thumbsSwiper = new Swiper('.swiper', {
                                slidesPerView: 3,
                                spaceBetween: 10,
                                breakpoints: {
                                    0: { slidesPerView: 2 },
                                    768: { slidesPerView: 2 },
                                    1024: { slidesPerView: 3 }
                                }
                            });
                            console.log('Swiper инициализирован:', thumbsSwiper);
                    
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
                        } else {
                            alert('Swiper не подключен!');
                        }
                    });
                    </script>
    

                @endif
            </div>
           
            {{-- Информация о продукте --}}
            <div class="product-info w-full lg:w-1/2">
                <h1 class="slide-title mb-4"><span>{{ $product->title }}</span></h1>
                <div class="subtitle mb-4"><span>{{ $product->subtitle ?? '' }}</span></div>
                <div class="text-2xl font-semibold mb-6 price">{{ number_format($product->price, 0, '.', ' ') }} ₸</div>

                <div class="product-description mb-6 leading-relaxed text-lg">
                    <p>{{ $product->description }}</p>
                </div>

                {{-- Пример характеристик украшений --}}
                @if(!empty($product->attributes))
                <div class="mb-6">
                    <h5 class="mb-1 font-semibold">Характеристики:</h5>
                    <ul class="text-sm list-disc list-inside text-gray-700 leading-relaxed">
                        @foreach($product->attributes as $label => $value)
                            <li>{{ $label }}: {{ $value }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Количество и кнопка В Корзину --}}
                <div class="qty-and-button">
                    <div class="qty-block">
                        <label for="quantity" class="qty-label">Количество</label>
                        <div class="qty-inner">
                            <input id="quantity" type="number" min="1" max="10" value="1" class="product-qty-input">
                            <span class="qty-available">Доступно: {{ $product->quantity ?? 10 }} шт</span>
                        </div>
                    </div>
                    <div class="cart-button-block">
                        <form method="POST" action="{{ route('bucket.add') }}" id="addToCartForm">
                            @csrf
                            <input type="hidden" name="type" value="jewelry">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="title" value="{{ $product->title }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="currency" value="{{ $product->currency ?? '₸' }}">
                            <input type="hidden" name="qty" id="inputQty" value="1">                            
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
                        </form>


                        <script>
                            document.getElementById('addToCartForm').addEventListener('submit', function(e) {
                                // Перед отправкой формы — логируем содержимое всех полей
                                const formData = new FormData(this);
                                let data = {};
                                for (let [key, value] of formData.entries()) {
                                    data[key] = value;
                                }
                                console.log('В корзину отправляется:', data);
                            });
                            </script>
                    </div>
                    <div id="cartNotify" class="cart-notify">Товар добавлен в корзину</div>
                </div>

                <div class="product-extra text-sm mt-6">
                    <h5 class="mb-1 font-semibold">Доставка и возврат</h5>
                    <p>Бесплатная доставка по Казахстану. Возврат в течение 14 дней.</p>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Подключение стилей и скриптов Swiper можно вынести в layout --}}
@push('scripts')

<script>
    document.getElementById('quantity').addEventListener('change', function() {
    document.getElementById('inputQty').value = this.value;
});

</script>

<script>

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
    }, 2000);
});
</script>


<script>
    document.querySelectorAll('.attribute-options').forEach(group => {
        group.querySelectorAll('.attribute-btn').forEach(button => {
            button.addEventListener('click', () => {
                group.querySelectorAll('.attribute-btn').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                // Здесь можно сохранить значение: button.dataset.value
            });
        });
    });
</script>


@endpush

@endsection


                
                    