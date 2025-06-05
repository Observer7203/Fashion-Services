@extends('layouts.app')
@section('title', 'Fashion Events')


@section('content')
    <link href="https://fonts.googleapis.com/css?family=Mulish:400,500,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:700,800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Inter:400,500&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      background: #fff;
      color: #232323;
      font-family: 'Inter', Arial, sans-serif;
      font-size: 18px;
    }
    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 36px 32px 0 32px;
    }
    .intro {
      color: #aaaaaa;
      font-family: 'Inter', Arial, sans-serif;
      font-size: 1rem;
      line-height: 1.55;
      margin-bottom: 38px;
      margin-top: 8px;
      max-width: 1100px;
      text-align: justify;
    }
    .events-flex {
      display: flex;
      align-items: flex-start;
      gap: 36px;
    }
    .video-main {
      flex: 3;
      background: #000;
      border-radius: 0;
      box-shadow: none;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }
    .video-youtube {
      width: 700px;
      height: 390px;
      background: #000;
      border-radius: 0;
      box-shadow: 0 2px 12px rgba(0,0,0,0.09);
      overflow: hidden;
      margin-bottom: 0;
    }
    .video-youtube iframe {
      width: 100%;
      height: 100%;
      border: none;
      background: #000;
    }
    .event-slider-bar {
      display: flex;
      align-items: center;
      width: 700px;
      margin-top: 22px;
    }
    .event-slider-bar .arrow {
      font-size: 1.5rem;
      color: #b6b6b6;
      cursor: pointer;
      user-select: none;
      margin: 0 8px;
      padding: 0 8px;
      transition: color .15s;
    }
    .event-slider-bar .arrow:hover { color: #634cff; }
    .event-slider-title {
      flex: 1;
      color: #313131;
      font-family: 'Inter', Arial, sans-serif;
      font-size: 1.07rem;
      font-weight: 400;
      display: flex;
      align-items: center;
      gap: 0 7px;
      letter-spacing: .02em;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .event-slider-bar button {
      font-family: 'Inter', Arial, sans-serif;
      font-size: 1.05rem;
      padding: 7px 18px;
      margin-left: 16px;
      border: 1px solid #232323;
      background: #fff;
      border-radius: 6px;
      cursor: pointer;
      transition: background .13s;
      outline: none;
    }
    .event-slider-bar button:hover {
      background: #634cff;
      color: #fff;
      border: 1px solid #634cff;
    }
    .event-slider-bar .discover-arrow {
      font-size: 1rem;
      margin-left: 4px;
      vertical-align: middle;
    }
    /* Sidebar */
    .sidebar-list {
      flex: 1;
      min-width: 320px;
      max-width: 340px;
      background: #fff;
      border-radius: 0;
      box-shadow: none;
      padding: 0;
      margin-left: 0;
    }
    .sidebar-item {
      display: flex;
      align-items: center;
      gap: 13px;
      padding: 0 0 0 0;
      border-bottom: 1px solid #ededed;
      background: transparent;
      transition: background .09s;
      cursor: pointer;
      height: 54px;
      position: relative;
    }
    .sidebar-item.active, .sidebar-item:active, .sidebar-item:focus {
      background: #232323 !important;
      color: #fff;
    }
    .sidebar-item.active .sidebar-title {
      color: #fff;
      font-weight: 700;
    }
    .sidebar-thumb {
      width: 78px;
      height: 52px;
      background: #111;
      flex-shrink: 0;
      object-fit: cover;
      border-radius: 0;
    }
    .sidebar-info {
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-width: 0;
    }
    .sidebar-title {
      font-family: 'Inter', Arial, sans-serif;
      font-size: 0.97rem;
      color: inherit;
      font-weight: 600;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      line-height: 1.16;
      margin: 0 0 2px 0;
    }
    .sidebar-desc {
      font-size: .93rem;
      color: #7b7b7b;
      font-weight: 400;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .sidebar-item:not(.active):hover {
      background: #f2efff;
    }
    .sidebar-scroll {
      max-height: 370px;
      overflow-y: auto;
      border-radius: 0;
    }
    .events-list-title {
      margin: 0px 0 15px 0;
      font-family: 'Raleway', Arial, sans-serif;
      font-size: 1.31rem;
      font-weight: 700;
      color: #222;
      letter-spacing: .04em;
      border-bottom: 1px solid #ededed;
      padding-bottom: 6px;
    }
    @media (max-width: 1250px) {
      .video-youtube, .event-slider-bar { width: 100%; }
      .events-flex { flex-direction: column; }
      .sidebar-list { max-width: 100%; min-width: unset; margin-top: 30px; }
    }
    ::-webkit-scrollbar { width: 8px; background: #fafafa; }
    ::-webkit-scrollbar-thumb { background: #ededed; border-radius: 5px; }
  </style>
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
              .container {
            max-width: 1200px;
            margin: auto 10%;
            padding: 2rem;
        }
    </style>
<section class="about-banner fade-in-section" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/ES-20231001-00286%20%E2%80%94%20%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F%20%E2%80%94%20%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F.JPG?_t=1748838821');">
  <div class="about-banner__content container">
    <h1 class="about-main-title fade-in-section">FASHION EVENTS</h1>
    <nav class="breadcrumbs fade-in-section" aria-label="Breadcrumb">
      <ul>
        <li><a href="/">Home</a></li>
        <li class="separator">/</li>
        <li class="current">Events</li>
      </ul>
    </nav>
  </div>
</section>
  <div class="container"  style="padding-bottom: 0px;    display: flex; flex-direction: column; align-items: center;">
    <div class="intro fade-in-section">
      A global calendar of influential events that move fashion forward. Fashion events gather the most influential voices in fashion. These occasions bring together designers, industry professionals, media, and tastemakers in exclusive settings where collections are revealed, ideas are exchanged, and global narratives are set. Whether it's the prestige of Haute Couture, the commercial pulse of Fashion Weeks, or the impact of iconic galas and exhibitions, fashion events remain at the core of creative and business evolution in the industry.
    </div>
    <!-- Elfsight YouTube Gallery | Untitled YouTube Gallery -->
<script src="https://static.elfsight.com/platform/platform.js" async></script>
<div class="elfsight-app-b99b5ff0-6a09-46e9-a932-2227d2c6b9bc" data-elfsight-app-lazy></div>
<style>
  .events-list-title {
    margin: 48px 0 15px 0;
    font-family: 'Raleway', Arial, sans-serif;
    font-size: 1.31rem;
    font-weight: 700;
    color: #222;
    letter-spacing: .04em;
    border-bottom: 1px solid #ededed;
    padding-bottom: 6px;
  }
  .events-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 28px 18px;
    margin-top: 0px;
    padding-top: 0px;
    margin-bottom: 100px;
  }
  .event-card-grid {
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 0;
    box-shadow: none;
    cursor: pointer;
    min-width: 0;
    transition: box-shadow 0.18s;
  }
  .event-card-img {
    width: 100%;
    aspect-ratio: 4/3;
    object-fit: cover;
    border-radius: 0;
    margin-bottom: 9px;
    background: #f4f4f4;
  }
  .event-card-title {
    font-family: 'Raleway', Arial, sans-serif;
    font-weight: 700;
    font-size: 1.04rem;
    color: #111;
    margin-bottom: 2px;
    margin-top: 0;
    line-height: 1.18;
  }
  .event-card-date {
    color: #222;
    font-size: .97rem;
    margin-bottom: 0;
    line-height: 1.13;
  }
  .event-card-place {
    color: #222;
    font-size: .97rem;
    margin-top: 1px;
    margin-bottom: 0;
    line-height: 1.13;
  }
  @media (max-width: 1100px) {
    .events-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 700px) {
    .events-grid { grid-template-columns: 1fr; }
  }
  
  .yottie-container .yottie {
    margin-left: 0;
}
</style>
 
          
 <!-- EVENTS LIST на 8 карточек, можно вставить прямо в твой шаблон -->
  <div style="width: 100%;"><div class="events-list-title">EVENTS LIST</div></div> 
<div class="events-grid">
  <div class="event-card-grid fade-in-section">
    <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/PFW.webp?_t=1748802831" class="event-card-img" alt="">
    <div class="event-card-title">Paris Fashion Week</div>
    <div class="event-card-date">May 6, 2025 - May 8, 2025</div>
    <div class="event-card-place">Paris, France</div>
  </div>
  <div class="event-card-grid fade-in-section">
    <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/nedelya-modi-v-milane.png?_t=1748802831" class="event-card-img" alt="">
    <div class="event-card-title fade-in-section">Milan Fashion Week</div>
    <div class="event-card-date fade-in-section">June 1, 2025 - June 7, 2025</div>
    <div class="event-card-place fade-in-section">Milan, Italy</div>
  </div>
  <div class="event-card-grid fade-in-section">
    <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/LFW-2023-CITY-WIDE-BANNER-3-TEXINTEL.jpg?_t=1748802831" class="event-card-img" alt="">
    <div class="event-card-title fade-in-section">London Fashion Week</div>
    <div class="event-card-date fade-in-section">September 15, 2025 - September 20, 2025</div>
    <div class="event-card-place fade-in-section">London, UK</div>
  </div>
  <div class="event-card-grid fade-in-section">
    <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/New-York-Fashion-Week.jpg?_t=1748802831" class="event-card-img" alt="">
    <div class="event-card-title fade-in-section">New York Fashion Week</div>
    <div class="event-card-date fade-in-section">February 8, 2025 - February 16, 2025</div>
    <div class="event-card-place fade-in-section">New York, USA</div>
  </div>
  <div class="event-card-grid fade-in-section">
    <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/met-gala-2021-1631525584.jpg?_t=1748802831" class="event-card-img" alt="">
    <div class="event-card-title fade-in-section">The Met Gala</div>
    <div class="event-card-date fade-in-section">May 5, 2025</div>
    <div class="event-card-place fade-in-section">New York, USA</div>
  </div>
  <div class="event-card-grid fade-in-section">
    <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/20231230105403_20530.jpg?_t=1748802831" class="event-card-img" alt="">
    <div class="event-card-title fade-in-section">Pitti Uomo</div>
    <div class="event-card-date fade-in-section">January 9, 2025 - January 12, 2025</div>
    <div class="event-card-place fade-in-section">Florence, Italy</div>
  </div>
  <div class="event-card-grid fade-in-section">
    <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/maxresdefault%20%286%29.jpg?_t=1748802831" class="event-card-img" alt="">
    <div class="event-card-title fade-in-section">Texprocess Americas</div>
    <div class="event-card-date fade-in-section">May 6, 2025 - May 8, 2025</div>
    <div class="event-card-place fade-in-section">Atlanta, USA</div>
  </div>
  <div class="event-card-grid fade-in-section">
    <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/hbz-viktor-rolf-statement-gowns-05-1548271843.jpg?_t=1748802831" class="event-card-img" alt="">
    <div class="event-card-title fade-in-section">Viktor & Rolf Haute Couture</div>
    <div class="event-card-date fade-in-section">May 10, 2025</div>
    <div class="event-card-place fade-in-section">Amsterdam, Netherlands</div>
  </div>
</div>
  </div>

@endsection


 