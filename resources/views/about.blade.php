@extends('layouts.app')

@section('title', 'About Me — Baktygul Bulatkali')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/basiclightbox@5.0.4/dist/basicLightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/basiclightbox@5.0.4/dist/basicLightbox.min.js"></script>

<script>
  // basicLightbox для просмотра в модалке
  document.querySelectorAll('.js-photo-modal').forEach(function(img) {
    img.style.cursor = 'zoom-in';
    img.addEventListener('click', function() {
      basicLightbox.create('<img src="' + img.src + '" style="max-width:96vw;max-height:88vh;">').show();
    });
  });
</script>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Mulish:wght@400;700&family=Raleway:wght@400;700&display=swap" rel="stylesheet">
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

        body {
            font-family: 'Inter', 'Mulish', 'Raleway', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
            color: #1a1a1a;
        }
        .container {
            max-width: 1200px;
            margin: auto 10%;
            padding: 2rem;
        }
        .about-header {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 2rem;
        }
        .about-photo {
            width: 320px;
            min-width: 200px;
            aspect-ratio: 3/4;
            border-radius: 24px;
            object-fit: cover;
            box-shadow: 0 6px 32px rgba(0,0,0,0.12);
        }
        .about-title {
            font-family: 'Raleway', sans-serif;
            font-size: 2.6rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
            letter-spacing: 0.01em;
        }
        .about-role {
            font-size: 1.3rem;
            font-family: 'Mulish', sans-serif;
            font-weight: 400;
            color: #898989;
        }
        .about-desc {
            margin: 2.5rem 0;
            font-size: 1.14rem;
            line-height: 1.7;
            max-width: 640px;
        }
        .stats-block {
            display: flex;
            flex-wrap: wrap;
            gap: 2.5rem;
            margin-bottom: 2rem;
        }
        .stat-item {
            flex: 1 1 160px;
            background: #fafafa;
            border-radius: 16px;
            padding: 1.2rem 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .stat-value {
            font-size: 2rem;
            font-family: 'Raleway', sans-serif;
            font-weight: 700;
            color: #C8956D;
        }
        .stat-label {
            font-size: 1.1rem;
            color: #898989;
            font-family: 'Mulish', sans-serif;
        }
        .about-quote {
            margin: 2rem 0;
            padding: 1.6rem 2rem;
            border-left: 4px solid #C8956D;
            background: #f7f5f2;
            font-family: 'Mulish', sans-serif;
            font-size: 1.2rem;
            color: #555;
        }
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .social-link {
            display: inline-block;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 8px rgba(0,0,0,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: box-shadow .2s;
        }
        .social-link:hover {
            box-shadow: 0 4px 16px rgba(200,149,109,0.28);
        }
        .about-cta {
            display: inline-block;
            margin-top: 2.2rem;
            padding: 1rem 2.4rem;
            background: #C8956D;
            color: #fff;
            font-family: 'Raleway', sans-serif;
            font-size: 1.22rem;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s;
        }
        .about-cta:hover {
            background: #a17956;
        }
        @media (max-width: 900px) {
            .about-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .about-photo {
                width: 180px;
            }
        }
        @media (max-width: 600px) {
            .container {
                padding: 1rem;
            }
            .about-title {
                font-size: 2rem;
            }
            .about-photo {
                width: 100%;
                max-width: 180px;
            }
            .stats-block {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
 <!-- Banner с хлебными крошками и большим заголовком -->
<section class="about-banner" style="background-image: url('https://thumbsnap.com/i/qAsZZaWT.jpg');">
  <div class="about-banner__content container">
    <h1 class="about-main-title">ABOUT ME</h1>
    <nav class="breadcrumbs" aria-label="Breadcrumb">
      <ul>
        <li><a href="/">Home</a></li>
        <li class="separator">/</li>
        <li class="current">About Me</li>
      </ul>
    </nav>
  </div>
</section>

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
</style>


    <div class="container">
        <!-- Блок About Me — вставь после баннера -->
<section class="about-info-block fade-in-section" data-delay="0">
  <div class="about-info-inner">
    <div class="about-info-photo fade-in-section"data-delay="1">
      <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/profile-%20%283%29-4%20%281%29.png?_t=1748293654" alt="Baktygul fashion photo">
    </div>
    <div class="about-info-text fade-in-section" data-delay="2">
      <div class="about-info-profession fade-in-section">Fashion stylist</div>
      <h2 class="about-info-name fade-in-section">BAKTYGUL BULATKALI</h2>
      <div class="about-info-title fade-in-section">
        STYLIST AND FASHION INFLUENCER WITH 9 YEARS OF EXPERIENCE IN THE FASHION INDUSTRY.
      </div>
      <div class="about-info-divider fade-in-section"></div>
      <div class="about-info-description fade-in-section">
        I'm a professional stylist that provides styling services, image consultations, wardrobe analysis, fashion tours to Paris, photo & video styling, organization and participation in Paris Fashion Week, shopping support, vintage clothing and jewelry. More than 500 clients worldwide, including Elle, L'official, Le Bon Marché Paris and Paris Fashion Week.
      </div>
    </div>
  </div>
</section>

<style>
.about-info-block {
  width: 100%;
  background: #fff;
  padding: 48px 0 32px 0;
  display: flex;
  justify-content: center;
}
.about-info-inner {
  display: flex;
  max-width: 1160px;
  width: 100%;
  gap: 44px;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
}
.about-info-photo {
  flex: 0 1 445px;
  max-width: 445px;
}
.about-info-photo img {
  display: block;
  width: 100%;
  object-fit: cover;
        height: 400px;
    object-position: 0px -240px;
}
.about-info-text {
  flex: 1 1 420px;
  min-width: 320px;
  max-width: 600px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
.about-info-profession {
  font-family: 'Mulish', 'Raleway', sans-serif;
  font-size: 1.07rem;
  color: #979797;
  margin-bottom: 6px;
}
.about-info-name {
  font-family: 'Raleway', sans-serif;
  font-size: 2.6rem;
  font-weight: 900;
  letter-spacing: -0.02em;
  color: #111;
  margin: 0 0 10px 0;
}
.about-info-title {
  font-family: 'Mulish', 'Inter', sans-serif;
  font-size: 1.15rem;
  font-weight: 600;
  text-transform: uppercase;
  color: #232323;
  margin-bottom: 16px;
}
.about-info-divider {
  width: 56px;
  height: 3px;
  background: #111;
  border-radius: 3px;
  margin-bottom: 22px;
}
.about-info-description {
  font-family: 'Mulish', 'Inter', sans-serif;
  font-size: 1.07rem;
  color: #848484;
  line-height: 1.7;
  max-width: 98%;
}
@media (max-width: 900px) {
  .about-info-inner {
    flex-direction: column;
    gap: 32px;
    align-items: stretch;
  }
  .about-info-photo, .about-info-text {
    max-width: 100%;
  }
}
@media (max-width: 650px) {
  .about-info-block {
    padding: 24px 0 8px 0;
  }
  .about-info-name {
    font-size: 1.43rem;
  }
}
</style>
    </div>
        <section class="testimonials-section fade-in-section" style="background-image: url('https://eona.qodeinteractive.com/wp-content/uploads/2020/04/h3-parallax-img-1.jpg');">
  <div class="testimonials-overlay">
    <div class="testimonials-inner">
      <div class="testimonials-label fade-in-section">Testimonials</div>
      <div class="testimonials-title fade-in-section">OUR CLIENTS SAY</div>
      <!-- Swiper -->
      <div class="swiper testimonials-swiper fade-in-section">
        <div class="swiper-wrapper">
          <!-- Слайд 1 -->
          <div class="swiper-slide testimonials-slide">
            Amazing service! My stylist quickly understood my taste and helped me create a stylish, confident look. I finally feel like my wardrobe truly fits me.
          </div>
          <!-- Слайд 2 -->
          <div class="swiper-slide testimonials-slide">
            Working with Baktygul was inspiring. She found unique looks and gave me confidence for my Paris trip!
          </div>
          <!-- Слайд 3 -->
          <div class="swiper-slide testimonials-slide">
            The best stylist experience ever. Shopping tour and vintage finds were unforgettable. Highly recommend!
          </div>
        </div>
        <!-- Стрелки -->
        <div class="swiper-button-prev testimonials-swiper-btn"></div>
        <div class="swiper-button-next testimonials-swiper-btn"></div>
        <!-- Пагинация -->
        <div class="swiper-pagination testimonials-swiper-pagination"></div>
      </div>
    </div>
  </div>
</section>

  
  <section class="experience-section fade-in-section">
  <div class="experience-inner">
    <div class="experience-head">
      <div class="experience-label">Styling</div>
      <div class="experience-title">PROFESSIONAL EXPERIENCE</div>
      <div class="experience-subtitle">Curabitur placerat, tortor nec eleifend, justo urna ante</div>
      <div class="experience-divider"></div>
    </div>
    <div class="experience-grid fade-in-section">
      <!-- Карточка 1 -->
      <div class="experience-card fade-in-section">
        <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/405551852_1061449608325857_8492329640374453592_n.jpg?_t=1747845690" alt="Client Consultancy">
        <div class="experience-card-title">CLIENT CONSULTANCY</div>
        <div class="experience-card-divider"></div>
        <div class="experience-card-text">
          Conducted over 500 online and offline style consultations for clients in different countries and cities. Services include wardrobe reviews, style recommendations, creation of capsule collections.
        </div>
      </div>
      <!-- Карточка 2 -->
      <div class="experience-card fade-in-section">
        <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0f/7d/10/92/photo1jpg.jpg?w=1200&h=-1&s=1" alt="Fashion Shows and Events">
        <div class="experience-card-title">FASHION SHOWS AND EVENTS</div>
        <div class="experience-card-divider"></div>
        <div class="experience-card-text">
          Stylized shows and art events in Kazakhstan, was the ambassador of Fashion Night Astana.
        </div>
      </div>
      <!-- Карточка 3 -->
      <div class="experience-card fade-in-section">
        <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/449641469_18442758559060040_7249012181105555205_n.jpg?_t=1748296752" alt="Exclusive Personal Shopping">
        <div class="experience-card-title">EXCLUSIVE PERSONAL SHOPPING</div>
        <div class="experience-card-divider"></div>
        <div class="experience-card-text">
          Personal consultations are provided to VIP clients at Le Bon Marché (Paris) by exclusive agreement.
        </div>
      </div>
      <!-- Карточка 4 -->
      <div class="experience-card fade-in-section">
        <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/IMG_3604.JPG?_t=1747708855" alt="Participation in Fashion Weeks">
        <div class="experience-card-title">PARTICIPATION IN FASHION WEEKS</div>
        <div class="experience-card-divider"></div>
        <div class="experience-card-text">
          Participated in Paris Fashion Week in 2023 and 2024, promoting Kazakhstani designers as a model and stylist.
        </div>
      </div>
      <!-- Карточка 5 -->
      <div class="experience-card fade-in-section">
        <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/449462037_18442758469060040_4028082527966796404_n.jpg?_t=1748296752" alt="Fashion and Shopping Tours">
        <div class="experience-card-title">FASHION AND SHOPPING TOURS</div>
        <div class="experience-card-divider"></div>
        <div class="experience-card-text">
          Organized individual shopping and styling tours for VIP clients from Kazakhstan in Paris, acting as a guide and stylist.
        </div>
      </div>
      <!-- Карточка 6 -->
      <div class="experience-card fade-in-section">
        <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/File_000%20%E2%80%94%20%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F.png?_t=1747735845" alt="Modeling and Collaboration with Brands">
        <div class="experience-card-title">MODELING AND COLLABORATION WITH BRANDS</div>
        <div class="experience-card-divider"></div>
        <div class="experience-card-text">
          Worked as a model for international brands, and contributed to the entry of French luxury and mid-range brands into the Kazakh market.
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.experience-section {
  width: 100%;
  background: #fff;
  padding: 64px 0 50px 0;
  display: flex;
  justify-content: center;
}
.experience-inner {
  width: 100%;
  max-width: 1150px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.experience-head {
  text-align: center;
  margin-bottom: 40px;
}
.experience-label {
  font-family: 'Mulish', 'Raleway', sans-serif;
  font-size: 1.07rem;
  color: #888;
  margin-bottom: 5px;
  font-weight: 400;
}
.experience-title {
  font-family: 'Raleway', sans-serif;
  font-size: 2.35rem;
  font-weight: 900;
  color: #111;
  letter-spacing: -0.01em;
}
.experience-subtitle {
  font-family: 'Mulish', 'Inter', sans-serif;
  font-size: 1.09rem;
  color: #232323;
  opacity: 0.8;
  margin-top: 8px;
  margin-bottom: 14px;
}
.experience-divider {
  width: 60px;
  height: 3px;
  background: #111;
  margin: 0 auto 0 auto;
}
.experience-grid {
  width: 100%;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px 24px;
}
.experience-card {
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  transition: box-shadow 0.15s;
}
.experience-card img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  object-position: center;
}
.experience-card-title {
  font-family: 'Raleway', sans-serif;
  font-size: 1.12rem;
  font-weight: 800;
  margin: 14px 0 0 0;
  letter-spacing: -0.01em;
  color: #111;
}
.experience-card-divider {
  width: 36px;
  height: 3px;
  background: #111;
  margin: 10px 0 0 0;
  border-radius: 3px;
}
.experience-card-text {
  font-family: 'Mulish', 'Inter', sans-serif;
  font-size: 0.98rem;
  color: #3a3a3a;
  opacity: 0.8;
  margin: 14px 18px 18px 0;
  line-height: 1.5;
}
@media (max-width: 900px) {
  .experience-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 24px 16px;
  }
}
@media (max-width: 650px) {
  .experience-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }
  .experience-section {
    padding: 28px 0 12px 0;
  }
  .experience-title {
    font-size: 1.33rem;
  }
}
</style>

  <section class="portfolio-section fade-in-section">
  <div class="portfolio-inner">
    <!-- Левая колонка -->
    <div class="portfolio-left">
      <div class="portfolio-handwrite">The</div>
      <div class="portfolio-title">PORTFOLIO</div>
      <div class="portfolio-subtitle">Curabitur nec eleifend, justo</div>
      <div class="portfolio-divider"></div>
      <ul class="portfolio-list">
        <li class="active" data-portfolio="0">Elle Kazakhstan</li>
        <li data-portfolio="1">L'Officiel</li>
        <li data-portfolio="2">Marie Claire Kazakhstan</li>
        <li data-portfolio="3">Fashion Night Astana</li>
        <li data-portfolio="4">Le Bon Marché Paris</li>
        <li data-portfolio="5">Fashion Paris Week</li>
      </ul>
    </div>
    <!-- Правая часть: Swiper для каждого проекта -->
    <div class="portfolio-swipers">
      <!-- Галерея для 1 проекта -->
      <div class="portfolio-swiper-wrap" data-portfolio="0" style="display:block;">
        <div class="swiper portfolio-swiper">
          <div class="swiper-wrapper fade-in-section">
            <div class="swiper-slide fade-in-section">
              <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/image2.png?_t=1747708616" alt="Elle Kazakhstan Project Image 1" class="js-photo-modal">
            </div>
            <div class="swiper-slide fade-in-section">
              <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/image3.png?_t=1747708616" alt="" class="js-photo-modal">
            </div>
                        <div class="swiper-slide fade-in-section">
              <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/image7.png?_t=1747708616" alt="" class="js-photo-modal">
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
      <!-- Галерея для 2 проекта -->
      <div class="portfolio-swiper-wrap" data-portfolio="1">
        <div class="swiper portfolio-swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/image3.png?_t=1747708616" alt="">
            </div>
            <div class="swiper-slide">
              <img src="65576297-43a0-4ec4-97f4-5e55aac4e353.png" alt="">
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
      <!-- и так далее -->
    </div>
  </div>
</section>
<section class="stats-section fade-in-section">
  <div class="stats-inner">
    <div class="stat-block fade-in-section">
      <div class="stat-num">23</div>
      <div class="stat-title">FASHION SHOWS</div>
      <div class="stat-desc">Stylized shows and fashion events</div>
    </div>
    <div class="stat-block fade-in-section">
      <div class="stat-num">61</div>
      <div class="stat-title">TOURS VISITED</div>
      <div class="stat-desc">Organized individual shopping and styling tours for VIP clients</div>
    </div>
    <div class="stat-block fade-in-section">
      <div class="stat-num">128</div>
      <div class="stat-title">PHOTOSHOOTING</div>
      <div class="stat-desc">Stylized for photo and video shooting</div>
    </div>
    <div class="stat-block fade-in-section">
      <div class="stat-num">500</div>
      <div class="stat-title">CONSULTATIONS</div>
      <div class="stat-desc">Conducted consultations in individual and professional formats.</div>
    </div>
  </div>
</section>

<style>
.stats-section {
  width: 100%;
  background: #fff;
  padding: 56px 0 36px 0;
  display: flex;
  justify-content: center;
}
.stats-inner {
  width: 100%;
  max-width: 1200px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0 34px;
  justify-content: center;
  align-items: flex-start;
}
.stat-block {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}
.stat-num {
  font-family: 'Raleway', 'Mulish', sans-serif;
  font-size: 3.3rem;
  font-weight: 800;
  color: #C8956D;
  margin-bottom: 6px;
  letter-spacing: 0.01em;
}
.stat-title {
  font-family: 'Raleway', 'Mulish', sans-serif;
  font-size: 1.13rem;
  font-weight: 800;
  color: #111;
  margin-bottom: 7px;
  letter-spacing: 0.01em;
}
.stat-desc {
  font-family: 'Mulish', 'Inter', sans-serif;
  font-size: 1.01rem;
  color: #949494;
  opacity: 0.91;
  line-height: 1.5;
  font-weight: 400;
  margin-bottom: 0;
}
@media (max-width: 900px) {
  .stats-inner {
    grid-template-columns: repeat(2, 1fr);
    gap: 28px 10px;
  }
  .stat-num { font-size: 2.2rem; }
}
@media (max-width: 600px) {
  .stats-inner {
    grid-template-columns: 1fr;
    gap: 18px 0;
  }
  .stat-block { margin-bottom: 14px; }
  .stat-num { font-size: 1.45rem; }
}





.testimonials-section {
  width: 100%;
  min-height: 340px;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  margin: 0;
  padding: 0;
}
.testimonials-overlay {
  width: 100%;
  height: 100%;
  padding: 60px 0 48px 0;
  display: flex;
  align-items: center;
  justify-content: center;
}
.testimonials-inner {
  width: 100%;
  max-width: 800px;
  text-align: center;
  margin: 0 auto;
  color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.testimonials-label {
  font-family: 'Mulish', 'Raleway', sans-serif;
  color: #ededed;
  font-size: 1.1rem;
  font-weight: 400;
  margin-bottom: 7px;
  letter-spacing: 0.08em;
}
.testimonials-title {
  font-family: 'Raleway', sans-serif;
  font-size: 2.55rem;
  font-weight: 800;
  letter-spacing: 0.01em;
  margin-bottom: 30px;
  margin-top: 0;
  color: #fff;
  text-shadow: 0 1px 24px rgba(0,0,0,0.11);
}
.testimonials-swiper {
  width: 100%;
  margin: 0 auto;
  position: relative;
}
.testimonials-slide {
  font-family: 'Inter', 'Mulish', sans-serif;
  font-size: 1.16rem;
  font-weight: 400;
  color: #fff;
  opacity: 0.93;
  margin: 0 auto 10px auto;
  line-height: 1.7;
  text-shadow: 0 1px 12px rgba(0,0,0,0.17);
  min-height: 108px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.testimonials-swiper-btn {
  color: #fff !important;
  background: rgba(0,0,0,0.23);
  border-radius: 50%;
  width: 42px;
  height: 42px;
  top: 50%;
  transform: translateY(-50%);
  box-shadow: 0 2px 12px rgba(0,0,0,0.14);
  transition: background 0.18s, color 0.18s;
}
.swiper-button-prev, .swiper-button-next {
  background: rgba(0,0,0,0.2);
}
.swiper-button-prev::after, .swiper-button-next::after {
  font-size: 1.7rem;
  font-weight: 700;
}
.testimonials-swiper-btn:hover {
  background: #C8956D;
  color: #fff !important;
}
.testimonials-swiper-pagination {
  margin-top: 18px;
  --swiper-pagination-color: #C8956D;
  --swiper-pagination-bullet-inactive-color: #fff;
  --swiper-pagination-bullet-inactive-opacity: 0.5;
}
.swiper-pagination-bullet {
  width: 12px;
  height: 12px;
  background: #fff;
  opacity: 0.5;
  border-radius: 50%;
  transition: background 0.2s, opacity 0.2s;
}
.swiper-pagination-bullet-active {
  background: #C8956D !important;
  opacity: 1 !important;
}

.swiper {
    height: 100% !important;
}
@media (max-width: 700px) {
  .testimonials-title { font-size: 1.4rem;}
  .testimonials-inner { padding: 0 10px;}
  .testimonials-slide { font-size: 1rem; }
  .testimonials-section { min-height: 180px; }
}

.swiper-button-next, .swiper-button-prev {
    justify-content: space-between !important;
}

.portfolio-section {
  width: 100%;
  background: #fff;
  display: flex;
  justify-content: center;
}
.portfolio-inner {
  width: 100%;
  display: flex;
  gap: 42px;
  align-items: flex-start;
  justify-content: center;
  height: 100vh;
}
.portfolio-left {
  min-width: 320px;
  max-width: 360px;
  padding-right: 18px;
  text-align: left;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
      height: inherit;
      padding-left: 5%;
    padding-top: 5%;
}
.portfolio-handwrite {
  font-family: 'Raleway', cursive;
  color: #C8956D;
  font-size: 3.5rem;
  line-height: 1;
  margin-bottom: -18px;
  font-weight: 300;
  letter-spacing: 0.02em;
}
.portfolio-title {
  font-family: 'Raleway', sans-serif;
  font-weight: 900;
  font-size: 2.3rem;
  letter-spacing: -0.02em;
}
.portfolio-subtitle {
  font-family: 'Mulish', 'Inter', sans-serif;
  font-size: 1.1rem;
  color: #232323;
  opacity: 0.75;
  margin: 6px 0 8px 0;
}
.portfolio-divider {
  width: 44px;
  height: 3px;
  background: #111;
  border-radius: 3px;
  margin: 16px 0 14px 0;
}
.portfolio-list {
  list-style: none;
  padding: 0;
  margin: 0;
  font-family: 'Mulish', 'Inter', sans-serif;
  font-size: 1.07rem;
  width: 100%;
}
.portfolio-list li {
  padding: 8px 0;
  color: #888;
  cursor: pointer;
  transition: color 0.2s, font-weight 0.2s;
}
.portfolio-list li.active {
  color: #111;
  font-weight: 700;
  text-decoration: underline;
  text-underline-offset: 5px;
}
.portfolio-swipers {
  flex: 1 1 0%;
  min-width: 0;
  display: flex;
  flex-direction: column;
  width: 100%;
  gap: 0;
  position: relative;
      height: inherit;
}
.portfolio-swiper-wrap {
  width: 100%;
  display: none;
  min-height: 440px;
      height: inherit;
}
.portfolio-swiper {
  width: 100%;
  height: 440px;
  background: #fff;
  border-radius: 0;
  /* БЕЗ тени и рамки! */
  box-shadow: none;
  overflow: hidden;
  position: relative;
      height: inherit;
}
.portfolio-swiper .swiper-slide {
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff;
}
.portfolio-swiper img {
  max-width: 100%;
    height: 100vh;
  border-radius: 0;
  object-fit: cover;
}
.swiper-pagination-bullet {
  background: #C8956D !important;
  opacity: 0.7;
}
.swiper-pagination-bullet-active {
  opacity: 1;
}
@media (max-width: 900px) {
  .portfolio-inner { flex-direction: column; align-items: stretch; gap: 32px;}
  .portfolio-swiper { height: 320px;}
  .portfolio-swiper-wrap { min-height: 280px;}
}
@media (max-width: 600px) {
  .portfolio-section { padding: 28px 0 14px 0;}
  .portfolio-left { min-width: 0; max-width: 100%; }
  .portfolio-handwrite { font-size: 2.1rem;}
  .portfolio-title { font-size: 1.2rem;}
  .portfolio-swiper { height: 170px;}
  .portfolio-swiper-wrap { min-height: 120px;}
}
.portfolio-swipers .swiper-wrapper {
      gap: 5px;
}
</style>
  <!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>

  const testimonialsSwiper = new Swiper('.testimonials-swiper', {
    loop: true,
    speed: 650,
    slidesPerView: 1,
    spaceBetween: 0,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    effect: 'slide',
  });

document.querySelectorAll('.portfolio-list li').forEach((el, idx) => {
  el.addEventListener('click', function() {
    document.querySelectorAll('.portfolio-list li').forEach(li => li.classList.remove('active'));
    this.classList.add('active');
    document.querySelectorAll('.portfolio-swiper-wrap').forEach(w => w.style.display = 'none');
    document.querySelector('.portfolio-swiper-wrap[data-portfolio="'+idx+'"]').style.display = 'block';
  });
});
document.querySelectorAll('.portfolio-swiper').forEach((swiperEl) => {
  new Swiper(swiperEl, {
    slidesPerView: 2.5,
    spaceBetween: 0,
    loop: true,
    speed: 650,
    // Нет navigation!
    pagination: {
      el: swiperEl.querySelector('.swiper-pagination'),
      clickable: true,
    },
    simulateTouch: true,  // включено по умолчанию, позволяет drag
    grabCursor: true,
  });
});
document.querySelector('.portfolio-swiper-wrap[data-portfolio="0"]').style.display = 'block';
</script>



@endsection
