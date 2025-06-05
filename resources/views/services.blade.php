@extends('layouts.app')

@section('title', 'Services | Baktygul Bulatkali')

@section('content')

 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Mulish:wght@400;700&family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <style>
      body {
        
        margin: 0px;
      }
        .services-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 60px 20px;
        }
        .service-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 70px;
        }
        .service-row.reverse {
            flex-direction: row-reverse;
        }
        .service-text {
            flex: 1.2;
            padding: 0 38px;
        }
        .service-image {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        .service-image img {
            width: 500px;
            max-width: 95vw;
            height: 100%;
            object-fit: cover;
            box-shadow: 0 6px 32px #d3d3d37a;
        }
        .service-from {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 15px;
            color: #a8a8a8;
            margin-bottom: 10px;
        }
        .service-title {
            font-family: 'Raleway', Arial, sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0 0 8px 0;
            letter-spacing: 1px;
        }
        .service-subtitle {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 17px;
            color: #555;
            margin-bottom: 17px;
        }
        .service-divider {
            width: 48px;
            height: 3px;
            background: #212121;
            margin: 17px 0 26px 0;
        }
        .service-desc {
            font-size: 16px;
            color: #333;
            margin-bottom: 26px;
            line-height: 1.55;
            font-family: 'Inter', Arial, sans-serif;
        }
        .service-btn {
            padding: 12px 32px;
            background: #181818;
            color: #fff;
            border: none;
            font-family: 'Raleway', Arial, sans-serif;
            font-size: 16px;
            letter-spacing: 1px;
            cursor: pointer;
            text-transform: lowercase;
            transition: background 0.18s;
            box-shadow: 0 2px 12px #bdbdbd37;
        }
        .service-btn:hover {
            background: #d02570;
        }
        @media (max-width: 1024px) {
            .services-section { padding: 22px 3vw 38px 3vw; }
            .service-row { flex-direction: column; margin-bottom: 54px;}
            .service-row.reverse { flex-direction: column; }
            .service-text { padding: 0 0 14px 0; text-align: center; }
            .service-divider { margin-left: auto; margin-right: auto;}
            .service-image img { width: 98vw; max-width: 430px; }
        }
        @media (max-width: 600px) {
            .service-image img { height: 170px; }
            .service-title { font-size: 1.3rem; }
            .service-subtitle { font-size: 14px; }
        }
      
      
      
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
    background: rgba(0,0,0,0.34); /* затемнение */
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
    align-items: center;
    gap: 12px;
  align-items: self-start;
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
    transition: color 0.2s;
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
@media (max-width: 650px) {
    .about-banner {
        height: 280px;
        min-height: 160px;
    }
    .about-main-title {
        font-size: 2rem;
    }
    .about-banner__subtitle {
        font-size: 1rem;
    }
}
              .container {
            max-width: 1200px;
            margin: auto 10%;
            padding: 2rem;
        }
    </style>

<section class="about-banner fade-in-section" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/bg-breadcrumbs2.JPG?_t=1748661703');">
  <div class="about-banner__content container fade-in-section">
    <h1 class="about-main-title fade-in-section">SERVICES</h1>
    <nav class="breadcrumbs fade-in-section" aria-label="Breadcrumb">
      <ul>
        <li><a href="/">Home</a></li>
        <li class="separator">/</li>
        <li class="current">Services</li>
      </ul>
    </nav>
  </div>
</section>

    <!-- Services Grid -->
     <section class="services-section" style="margin-top: 100px; margin-bottom: 50px;">

        <!-- Первый блок -->
        <div class="service-row fade-in-section">
            <div class="service-text fade-in-section">
                <div class="service-from fade-in-section">From The Fashion</div>
                <div class="service-title fade-in-section">PERSONAL STYLING</div>
                <div class="service-subtitle fade-in-section">Candid Enthusiasm from the Summer</div>
                <div class="service-divider fade-in-section"></div>
                <div class="service-desc fade-in-section">
                    Transform your personal image with exclusive one-on-one styling sessions.
                    From everyday elegance to red-carpet glamour, we curate complete looks that reflect your individuality, lifestyle, and aspirations.
                </div>
                <a class="service-btn fade-in-section" href="{{ url('/service/personal-styling') }}">read more</a>

            </div>
            <div class="service-image fade-in-section">
                <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/404938529_1586498311881129_6707843715254820543_n.jpg?_t=1747715957">
            </div>
        </div>

        <!-- Второй блок (reverse) -->
        <div class="service-row reverse fade-in-section">
            <div class="service-text fade-in-section">
                <div class="service-from fade-in-section">From The Fashion</div>
                <div class="service-title fade-in-section">FASHION TOURS</div>
                <div class="service-subtitle fade-in-section">Curabitur tortor nec eleifend, justo ante</div>
                <div class="service-divider fade-in-section"></div>
                <div class="service-desc fade-in-section">
                    Discover Paris through a fashion lover’s eyes. Our private tours lead you to legendary designer boutiques, emerging concept stores, couture ateliers, and hidden vintage treasures, all tailored to your style and interests.
                </div>
                <button class="service-btn fade-in-section">read more</button>
            </div>
            <div class="service-image fade-in-section">
                <img src="https://lh3.google.com/u/0/d/14hGKfnDOTlXUYqXhyl5QZojY5BYtAaoi=w1607-h912-iv1?auditContext=prefetch" alt="Fashion Tours">
            </div>
        </div>

       
       <!-- Concierge services -->
        <div class="service-row fade-in-section">
            <div class="service-text fade-in-section">
                <div class="service-from fade-in-section">From The Fashion</div>
                <div class="service-title fade-in-section">CONCIERGE SERVICES</div>
                <div class="service-subtitle fade-in-section">Curabitur tortor nec eleifend, justo ante</div>
                <div class="service-divider fade-in-section"></div>
                <div class="service-desc fade-in-section">
                    Our bespoke concierge services ensure a seamless Parisian experience, including private transportation, reservations at exclusive venues, personalized itineraries, luxury shopping assistance, and round-the-clock support.
                </div>
                <button class="service-btn fade-in-section">read more</button>
            </div>
            <div class="service-image fade-in-section">
                <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/image2.png?_t=1747708616" alt="Concierge Services">
            </div>
        </div>

        <!-- Vintage Wear & Jewel -->
        <div class="service-row reverse fade-in-section">
            <div class="service-text fade-in-section">
                <div class="service-from fade-in-section">From The Fashion</div>
                <div class="service-title fade-in-section">VINTAGE WEAR & JEWEL</div>
                <div class="service-subtitle fade-in-section">Curabitur tortor nec eleifend, justo ante</div>
                <div class="service-divider fade-in-section"></div>
                <div class="service-desc fade-in-section">
                    Embark on a curated journey to discover exceptional vintage fashion and rare jewelry pieces. We open doors to Paris’s best-kept secrets — prestigious vintage boutiques, private showrooms, and collectors’ hidden gems.
                </div>
                <button class="service-btn fade-in-section">read more</button>
            </div>
            <div class="service-image fade-in-section">
                <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/405201231_382002000893665_5876306834808737193_n.jpg?_t=1747845690" alt="Vintage Wear & Jewel">
            </div>
        </div>

        <!-- Paris Fashion Week -->
        <div class="service-row fade-in-section">
            <div class="service-text fade-in-section">
                <div class="service-from fade-in-section">From The Fashion</div>
                <div class="service-title fade-in-section">PARIS FASHION WEEK</div>
                <div class="service-subtitle fade-in-section">Curabitur tortor nec eleifend, justo ante</div>
                <div class="service-divider fade-in-section"></div>
                <div class="service-desc fade-in-section">
                    Step into the heart of the fashion world with VIP experiences at Paris Fashion Week. Enjoy priority access to top runway shows, backstage meet-and-greets, after-parties, and curated street style moments designed just for you.
                </div>
                <button class="service-btn fade-in-section">read more</button>
            </div>
            <div class="service-image fade-in-section">
                <img src="https://lh3.google.com/u/0/d/1DSbyEs2TfNJyX5Cm3f7f8zkM3F1EGJEJ=w1920-h912-iv1?auditContext=prefetch" alt="Paris Fashion Week">
            </div>
        </div>

        <!-- Personal Shopper -->
        <div class="service-row reverse fade-in-section">
            <div class="service-text fade-in-section">
                <div class="service-from fade-in-section">From The Fashion</div>
                <div class="service-title fade-in-section">PERSONAL SHOPPER</div>
                <div class="service-subtitle fade-in-section">Curabitur tortor nec eleifend, justo ante</div>
                <div class="service-divider fade-in-section"></div>
                <div class="service-desc fade-in-section">
                    Experience a tailor-made shopping journey across Paris’s most luxurious stores. Guided by a fashion expert, you'll find exceptional pieces that perfectly match your taste, wardrobe goals, and the spirit of Parisian elegance.
                </div>
                <button class="service-btn fade-in-section">read more</button>
            </div>
            <div class="service-image fade-in-section">
                <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/image3.png?_t=1747708616" alt="Personal Shopper">
            </div>
        </div>

        <!-- Третий, четвертый и далее блоки — копируй по аналогии, меняй текст и картинки -->

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

@endsection
