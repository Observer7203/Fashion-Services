@extends('layouts.app')
@section('title', 'тур')  
@section('content')


<!-- Подключи в <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/basiclightbox@5.0.4/dist/basicLightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/basiclightbox@5.0.4/dist/basicLightbox.min.js"></script>


<!-- Перед закрывающим </body> -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" /><link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet" />
<section class="about-banner" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/379410672_845717123525682_6733083808991049778_n.jpg?_t=1747850731');">
  
   <style>.about-banner {
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
     body { margin: 0px; }
    </style>
  <div class="about-banner__content container fade-in-section">
    <h1 class="about-main-title fade-in-section">PARIS FASHION WEEK TOUR</h1>
    <nav class="breadcrumbs fade-in-section" aria-label="Breadcrumb">
      <ul>
        <li><a href="/">Home</a></li>
        <li class="separator">/</li>
        <li class="current">Tours</li>
        <li class="separator">/</li>
        <li class="current">Paris Fashion Week Tour</li>
      </ul>
    </nav>
  </div>
</section>
<div class="tour-top-block">
    <!-- Большое изображение -->
    <div class="tour-cover-img fade-in-section">
        <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/IMG_3604.JPG?_t=1747708855" alt="Fashion Week Tour" />
    </div>
    
    <!-- Текстовый блок -->
    <div class="tour-main-desc fade-in-section">
        <div class="tour-category fade-in-section">Fashion Services</div>
        <h1 class="tour-title fade-in-section">PARIS FASHION WEEK TOUR</h1>
        <div class="tour-lead fade-in-section">
            <span class="first-letter">E</span>xperience the glamour of Paris Fashion Week with exclusive access to Haute Couture and Prêt-à-Porter shows, invitations to private events and after-parties, personal shopping on Rue Saint-Honoré, Avenue Montaigne, and at Galeries Lafayette, a styling masterclass at a leading Parisian fashion house, and a professional photoshoot at iconic locations like the Eiffel Tower and Palais-Royal. Enjoy gourmet dining at Café de Flore and gifts from Dior, Chanel, and Hermès partners.<br><br>
            Whether you choose our Exclusive, Express, or Street Style package, our dedicated team will ensure a seamless and luxurious journey from arrival to departure, making your Fashion Week experience unforgettable.
        </div>
    </div>
  
      <!-- Блок с видео -->
    <div class="tour-cover-video fade-in-section" style="position: relative;">
        <video autoplay muted loop playsinline class="bg-video" style="width: 100%; height: auto; display: block; object-fit: cover; top: -600px; position: relative;">
            <source src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/IMG_5054%20%28online-video-cutter.com%29%20%284%29.mp4?_t=1747722498" type="video/mp4">
        </video>
        <div class="video-overlay" style="position: absolute; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.14);"></div>
    </div>
  
  
  <!-- Блок с тремя параметрами тура -->
<section class="tour-params">
    <div class="tour-param fade-in-section">
        <div class="tour-param__icon">
            <!-- SVG Location -->
            <svg width="36" height="36" fill="none" stroke="#222" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 21s-6.7-6.26-6.7-10.38A6.7 6.7 0 0 1 12 4a6.7 6.7 0 0 1 6.7 6.62C18.7 14.74 12 21 12 21z"></path><circle cx="12" cy="11" r="3"></circle></svg>
        </div>
        <div class="tour-param__title">LOCATION</div>
        <div class="tour-param__desc">Paris, France</div>
    </div>
    <div class="tour-param fade-in-section tour-param--border">
        <div class="tour-param__icon">
            <!-- SVG Calendar -->
            <svg width="36" height="36" fill="none" stroke="#222" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"></rect><path d="M16 3v4M8 3v4M3 9h18"></path></svg>
        </div>
        <div class="tour-param__title">FREQUENCY</div>
        <div class="tour-param__desc">
            Held twice a year:<br>
            Spring/Summer and Fall/Winter seasons
        </div>
    </div>
    <div class="tour-param fade-in-section tour-param--border">
        <div class="tour-param__icon">
            <!-- SVG Calendar -->
            <svg width="36" height="36" fill="none" stroke="#222" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"></rect><path d="M16 3v4M8 3v4M3 9h18"></path></svg>
        </div>
        <div class="tour-param__title">UPCOMING DATES</div>
        <div class="tour-param__desc">
            Ready-to-Wear:<br>
            Sept 23–Oct 1, 2025<br>
            Haute Couture: July 1–4, 2025<br>
            Menswear: June 18–22, 2025
        </div>
    </div>
</section>


<!-- EXCLUSIVE PACKAGE -->
<section class="tour-package tour-package--exclusive fade-in-section" style="font-family: 'Inter';">
    <h2>EXCLUSIVE PACKAGE — €3000 / 1 SHOW</h2>
    <hr>
    <div class="tour-package__features">
        <ul>
            <li>Access to top runway shows</li>
            <li>Personal transportation</li>
            <li>Individual styling session and wardrobe curation</li>
            <li>Professional photo &amp; video shoot</li>
            <li>Hair &amp; makeup by professional artists</li>
        </ul>
        <ul>
            <li>Table reservations at high-end restaurants</li>
            <li>Access to exclusive afterparties</li>
            <li>Snacks and beverages included</li>
            <li>Private guide and translator</li>
            <li>Full itinerary planning &amp; coordination</li>
        </ul>
    </div>
    <div class="tour-package__note">
        <b>Not included:</b> Last-minute show tickets, hotel accommodation, personal shopping items, gourmet dinners, alcoholic beverages.
    </div>
</section>

  <section class="tour-photos fade-in-section">
    <h2 class="tour-block-title" style="font-family: 'Inter';">PHOTOS &amp; HIGHLIGHTS</h2>
    <hr class="tour-hr">

    <!-- Swiper (или обычная сетка, если не подключал Swiper) -->
    <div class="swiper tour-photos-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://lh3.google.com/u/0/d/1dvWW7uvM1tjAOA_2R2YUUDgB7ZrCJdCS=w1607-h912-iv1?auditContext=prefetch" alt="Fashion Show" class="js-photo-modal">
            </div>
            <div class="swiper-slide">
                <img src="https://lh3.google.com/u/0/d/1yRgQrsjTd6IJRbVxn6tm5nIEmDoqAxRG=w1607-h912-iv1?auditContext=prefetch" alt="Louvre Paris" class="js-photo-modal">
            </div>
            <!-- можно добавить ещё -->
          <div class="swiper-slide">
                <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/309316230_196895196076245_858455837778871300_n.jpg?_t=1747850731" alt="Fashion Show" class="js-photo-modal">
            </div>
          <div class="swiper-slide">
                <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/309279819_203532872104460_4149712445089616985_n.jpg?_t=1747850731" alt="Fashion Show"  class="js-photo-modal">
            </div>
        </div>
    </div>

    <!-- Пакеты: две колонки -->
    <div class="tour-photo-packages">
        <div class="tour-photo-package fade-in-section">
            <h3>EXPRESS PACKAGE — €2000 / 1 SHOW</h3>
            <hr>
            <ul>
                <li>Reserved seats at selected fashion shows</li>
                <li>Professional itinerary coordination</li>
                <li>Styled photo &amp; video shoot</li>
                <li>Hair and makeup team support</li>
            </ul>
            <div class="tour-package__note">
                <b>Not included:</b> Accommodation, outfits, stylist for look creation, afterparty access.
            </div>
        </div>
        <div class="tour-photo-package fade-in-section">
            <h3>STREET PACKAGE — €1000 / 1 SHOW</h3>
            <hr>
            <ul>
                <li>Street style location scouting in Paris</li>
                <li>Logistics and shoot coordination</li>
                <li>High-quality photo/video content</li>
            </ul>
            <div class="tour-package__note">
                <b>Not included:</b> Fashion show access, hotel, personal styling, outfits.<br>
                <b>Optional Add-ons:</b> Styling per look – €500, Makeup &amp; Hair – €300
            </div>
        </div>
    </div>
</section>
  
  
  <!-- TOUR HIGHLIGHTS -->
<section class="tour-highlights-block fade-in-section">
    <h2 class="tour-block-title">TOUR HIGHLIGHTS</h2>
    <hr class="tour-hr">

    <div class="tour-highlights-cols">
        <ul>
            <li>Access to Paris Fashion Week runway shows</li>
            <li>Afterparty invitations with VIP entry</li>
            <li>Professional fashion photoshoots</li>
        </ul>
        <ul>
            <li>Visits to top fashion landmarks: Palais Galliera, Le Bon Marché, Rue Saint-Honoré</li>
            <li>Private shopping sessions and styling consultations</li>
        </ul>
    </div>
</section>

<!-- PRICING OVERVIEW -->
<section class="tour-pricing-block fade-in-section">
    <h2 class="tour-block-title">PRICING OVERVIEW</h2>
    <hr class="tour-hr">

    <div class="tour-pricing-table-wrap">
        <table class="tour-pricing-table">
            <thead>
                <tr>
                    <th>Package</th>
                    <th>Price</th>
                    <th>Includes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Exclusive</td>
                    <td>€3000</td>
                    <td>Full access, styling, afterparty, restaurant reservations</td>
                </tr>
                <tr>
                    <td>Express</td>
                    <td>€2000</td>
                    <td>Show access, photo session, hair &amp; makeup</td>
                </tr>
                <tr>
                    <td>Street style</td>
                    <td>€1000</td>
                    <td>Photoshoot coordination, Paris locations</td>
                </tr>
            </tbody>
        </table>
    </div>
    <button class="tour-btn-book fade-in-section">Book Your Tour</button>
</section>

</div>
<style>
.tour-top-block { max-width: 1100px; margin: 0 auto; padding: 44px 0 0 0; }
.tour-cover-img { width: 100%; margin-bottom: 40px; }
.tour-cover-img img { width: 100%; border-radius: 0; object-fit: cover; display: block; }
.tour-main-desc { margin-bottom: 54px; }
.tour-category { color: #6a6a6a; font-size: 20px; margin-bottom: 12px; font-family: 'Raleway', Arial, sans-serif; }
.tour-title { font-size: 58px; font-weight: 900; margin-bottom: 18px; letter-spacing: -2px; font-family: 'Raleway', Arial, sans-serif; }
.tour-lead { font-size: 18px; color: #aaaaaa; line-height: 1.55; font-family: 'Inter'; text-align: justify; }
.tour-lead .first-letter { float: left; font-size: 72px; font-weight: 600; line-height: 1; margin-right: 10px; color: #313131; font-family: auto; }
@media (max-width: 900px) {
    .tour-title { font-size: 36px; }
    .tour-lead { font-size: 16px; }
}
.tour-cover-video {
    width: 100%;
    height: 500px;
    position: relative;
    overflow: hidden;
    border-radius: 0;
    margin-bottom: 40px;
}
.bg-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.video-overlay {
    position: absolute;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.14);
    pointer-events: none;
}
@media (max-width: 900px) {
    .tour-cover-video { height: 260px; }
}
.tour-params {
    display: flex;
    justify-content: space-between;
    align-items: stretch;
    max-width: 1100px;
    margin: 0 auto 0px auto;
    padding: 36px 0 30px 0;
    background: #fff;
}
.tour-param {
    flex: 1;
    text-align: center;
    padding: 0 24px;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.tour-param--border::before {
    content: "";
    position: absolute;
    left: 0;
    top: 20%;
    height: 60%;
    width: 1px;
    background: #e1e1e1;
}
.tour-param__icon { margin-bottom: 10px; }
.tour-param__title { font-size: 17px; font-weight: 700; letter-spacing: 2px; color: #222; margin-bottom: 8px; text-transform: uppercase; font-family: 'Inter'; }
.tour-param__desc { font-size: 15px; color: #aaaaaa; font-family: 'Inter'; }
@media (max-width: 900px) {
    .tour-params { flex-direction: column; border: none; }
    .tour-param, .tour-param--border { padding: 24px 0; }
    .tour-param--border::before { display: none; }
}

.tour-package--exclusive {
    max-width: 1100px;
    margin: 0px auto 0 auto;
    padding: 16px 0 20px 0;
}
.tour-package--exclusive h2 {
    font-size: 28px; font-weight: 800; letter-spacing: 0; margin-bottom: 17px;
}
.tour-package--exclusive hr {
    border: none; border-top: 1.5px solid #ddd; margin: 12px 0 18px 0;
}
.tour-package__features { display: flex; gap: 40px;
color: #aaaaaa;
}
.tour-package__features ul { flex: 1; list-style: disc; color: #555; font-size: 16px; margin: 0 0 0 24px; padding: 0; color: #aaaaaa; }
.tour-package__features li { margin-bottom: 9px; }
.tour-package__note { margin-top: 16px; font-size: 15px; color: #7a7a7a; }
.tour-package__note b { color: #333; }

@media (max-width: 900px) {
    .tour-params { flex-direction: column; border: none; }
    .tour-param { padding: 24px 0; border-bottom: 1px solid #ececec; }
    .tour-param:last-child { border-bottom: none; }
    .tour-package__features { flex-direction: column; gap: 0; }
}

.tour-block-title {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 8px;
    letter-spacing: 0;
}
.tour-hr { border: none; border-top: 2px solid #e4e4e4; margin-bottom: 32px; }

.tour-photos { max-width: 1100px; margin: 0 auto 48px auto; margin-top: 30px; }
.tour-photos-swiper, .tour-photos-grid {
    width: 100%; display: flex; gap: 32px; margin-bottom: 32px;
}
.tour-photos-swiper .swiper-slide {
    width: 49%; min-width: 240px; border-radius: 0; overflow: hidden;
}
.tour-photos-swiper img {
    width: 100%; height: 320px; object-fit: cover; display: block; border-radius: 0;
}

.tour-photo-packages { display: flex; gap: 38px; margin-bottom: 44px; font-family: 'Inter';}
.tour-photo-package { flex: 1; background: #fff; padding: 0; }
.tour-photo-package h3 { font-size: 24px; font-weight: 800; margin: 0 0 8px 0; font-family: 'Inter'; }
.tour-photo-package hr { border: none; border-top: 1.5px solid #ddd; margin: 8px 0 14px 0; }
.tour-photo-package ul { list-style: disc; font-size: 16px; color: #444; margin: 0 0 0 22px; padding: 0; color: #aaaaaa;}
.tour-photo-package li { margin-bottom: 8px; }
.tour-package__note { margin-top: 12px; font-size: 15px; color: #7a7a7a; }
.tour-package__note b { color: #333; }

@media (max-width: 900px) {
    .tour-photos-swiper { flex-direction: column; gap: 14px; }
    .tour-photos-swiper .swiper-slide { width: 100%; }
    .tour-photo-packages { flex-direction: column; gap: 24px; }
}


@import url('https://fonts.googleapis.com/css?family=Inter:400,500&display=swap');
@import url('https://fonts.googleapis.com/css?family=Raleway:700,800&display=swap');

.tour-block-title {
    font-family: 'Raleway', Arial, sans-serif;
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 8px;
    letter-spacing: 0;
}
.tour-hr {
    border: none;
    border-top: 2px solid #e4e4e4;
    margin-bottom: 32px;
}

.tour-highlights-block {
    max-width: 1100px;
    margin: 0 auto 48px auto;
    font-family: 'Inter', Arial, sans-serif;
}
.tour-highlights-cols {
    display: flex;
    gap: 38px;
    margin-bottom: 44px;
}
.tour-highlights-cols ul {
    flex: 1;
    list-style: disc;
    font-size: 16px;
    color: #444;
    margin: 0 0 0 22px;
    padding: 0;
  color: #aaaaaa;
}
.tour-highlights-cols li { margin-bottom: 10px; }

.tour-pricing-block {
    max-width: 1100px;
    margin: 0 auto 64px auto;
    font-family: 'Inter', Arial, sans-serif;
}
.tour-pricing-table-wrap {
    margin-bottom: 38px;
}
.tour-pricing-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 17px;
    background: #fff;
}
.tour-pricing-table th, .tour-pricing-table td {
    border: 1px solid #d1d1d1;
    padding: 16px 14px;
    text-align: left;
}
.tour-pricing-table th {
    background: #ececec;
    font-weight: 700;
    font-family: 'Raleway', Arial, sans-serif;
    font-size: 17px;
}
.tour-btn-book {
    display: block;
    margin: 34px 0 0 0;
    padding: 18px 58px;
    font-size: 18px;
    background: #111;
    color: #fff;
    border: none;
    border-radius: 0;
    font-family: 'Raleway', Arial, sans-serif;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.16s;
}
.tour-btn-book:hover {
    background: #d3b17f;
    color: #222;
}
.swiper {
    height: 100% !important;
}

@media (max-width: 900px) {
    .tour-highlights-cols { flex-direction: column; gap: 14px; }
    .tour-pricing-table th, .tour-pricing-table td { font-size: 15px; padding: 12px 7px; color: #aaaaaa; }
}
</style>
<script>
  const swiper = new Swiper('.tour-photos-swiper', {
    slidesPerView: 2,
    spaceBetween: 5,
    loop: true,
    autoplay: {
      delay: 3000,  // медленный автоскролл
      disableOnInteraction: false
    },
    speed: 900,
    breakpoints: {
      900: { slidesPerView: 2 },
      0: { slidesPerView: 1 }
    }
  });

  // basicLightbox для просмотра в модалке
  document.querySelectorAll('.js-photo-modal').forEach(function(img) {
    img.style.cursor = 'zoom-in';
    img.addEventListener('click', function() {
      basicLightbox.create('<img src="' + img.src + '" style="max-width:96vw;max-height:88vh;">').show();
    });
  });
</script>
@endsection