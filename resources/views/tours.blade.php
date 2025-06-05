@extends('layouts.app')

@section('title', 'Tours | Baktygul Bulatkali')

@section('content')

    <link href="https://fonts.googleapis.com/css?family=Raleway:700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500&display=swap" rel="stylesheet">
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
    body {
      margin: 0px;
    }
              .container {
            max-width: 1200px;
            margin: auto 10%;
            padding: 2rem;
        }
    </style>
   

<section class="about-banner fade-in-section" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/379410672_845717123525682_6733083808991049778_n.jpg?_t=1747850731');">
  <div class="about-banner__content container">
    <h1 class="about-main-title fade-in-section">FASHION TOURS</h1>
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
            Step into the world of high fashion with our exclusive fashion tours across Paris, the French countryside, and Europe. Created for fashion enthusiasts, stylists, VIP clients, designers, and creatives, our experiences combine luxury, culture, and style in unforgettable journeys. Explore the heart of the fashion capital during Paris Fashion Week, with access to runway shows, designer presentations, private events, and behind-the-scenes moments.
        </p>
    </div>
</section>

<section class="tours-list">
    <div class="container">
        <!-- 1. Paris Fashion Week Tour (фото слева, текст справа) -->
        <div class="tour-block fade-in-section">
            <div class="tour-block__img fade-in-section">
                <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/IMG_3604.JPG?_t=1747708855" alt="Paris Fashion Week Tour">
            </div>
            <div class="tour-block__content">
                <div class="tour-block__cat fade-in-section">Fashion Tours</div>
                <h2 class="tour-block__title fade-in-section">PARIS FASHION WEEK TOUR</h2>
                <div class="tour-block__subtitle fade-in-section">L'événement mode le plus attendu de l'année</div>
                <div class="tour-block__line fade-in-section"></div>
                <div class="tour-block__desc fade-in-section">
                    Experience Paris Fashion Week with access to top shows, private events, and personal shopping on Rue Saint-Honoré and Avenue Montaigne. Enjoy a styling masterclass, a photoshoot by the Eiffel Tower, and gourmet dining at Café de Flore. VIP service, visits to Palais Galliera and Musée Yves Saint Laurent, and gifts from Dior, Chanel, and Hermès are included. Limited availability.
                </div>
                <div class="tour-block__actions">
                <a class="btn btn-black fade-in-section" href="{{ url('/tours/pfwt') }}">discover</a>
                    <a href="#" class="btn btn-outline fade-in-section">reserve</a>
                </div>
            </div>
        </div>

        <!-- 2. Styling Tour (фото справа, текст слева) -->
        <div class="tour-block tour-block--reverse fade-in-section">
            <div class="tour-block__img fade-in-section">
                <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/466069205_981731930635900_3992012161666740664_n.jpg?_t=1747848116" alt="Styling Tour">
            </div>
            <div class="tour-block__content">
                <div class="tour-block__cat fade-in-section">Fashion Tours</div>
                <h2 class="tour-block__title fade-in-section">STYLING TOUR</h2>
                <div class="tour-block__subtitle fade-in-section">L'événement mode le plus attendu de l'année</div>
                <div class="tour-block__line fade-in-section"></div>
                <div class="tour-block__desc fade-in-section">
                    Experience Paris like a true fashion insider. From private visits to legendary fashion houses and galleries to VIP shopping at Le Bon Marché, you’ll enjoy exclusive access to the city's most iconic fashion and lifestyle landmarks. The program includes guided tours of Dior and Ritz Paris, personal image consultations, elegant dining, and a professional street-style photoshoot — all wrapped in the unique charm of Paris.
                </div>
                <div class="tour-block__actions">
                    <a href="#" class="btn btn-black fade-in-section">discover</a>
                                      <a href="#" class="btn btn-outline fade-in-section">reserve</a>
                </div>
            </div>
        </div>

        <!-- 3. Vintage Paris Tour (фото слева, текст справа) -->
        <div class="tour-block fade-in-section">
            <div class="tour-block__img fade-in-section">
                <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/449462037_18442758469060040_4028082527966796404_n.jpg?_t=1748296752" alt="Vintage Paris Tour">
            </div>
            <div class="tour-block__content">
                <div class="tour-block__cat fade-in-section">Fashion Tours</div>
                <h2 class="tour-block__title fade-in-section">VINTAGE PARIS TOUR</h2>
                <div class="tour-block__subtitle fade-in-section">L'événement mode le plus attendu de l'année</div>
                <div class="tour-block__line fade-in-section"></div>
                <div class="tour-block__desc fade-in-section">
                    Discover the timeless elegance of vintage Paris on a 3-day curated tour for lovers of fashion, history, and unique finds. Visit the iconic Marché aux Puces, explore charming vintage boutiques, and meet private collectors. Enjoy expertly guided shopping, fine dining in historic restaurants, and cocktails in atmospheric Parisian bars. Full tour coordination, transport, and personal assistance are included — all tailored to offer an unforgettable and stylish experience.
                </div>
                <div class="tour-block__actions">
                    <a href="#" class="btn btn-black fade-in-section">discover</a>
                                      <a href="#" class="btn btn-outline fade-in-section">reserve</a>
                </div>
            </div>
        </div>

        <!-- 4. Countryside Fashion Tour (фото справа, текст слева) -->
        <div class="tour-block tour-block--reverse fade-in-section">
            <div class="tour-block__img fade-in-section">
                <img src="https://ec28uoaht5h.exactdn.com/wp-content/uploads/2024/09/Europe-Trip-Deals-Website-2-1920x830.jpg?strip=all&lossy=1&ssl=1" alt="Countryside Fashion Tour">
            </div>
            <div class="tour-block__content fade-in-section">
                <div class="tour-block__cat fade-in-section">Fashion Tours</div>
                <h2 class="tour-block__title fade-in-section">COUNTRYSIDE FASHION TOUR</h2>
                <div class="tour-block__subtitle fade-in-section">L'événement mode le plus attendu de l'année</div>
                <div class="tour-block__line fade-in-section"></div>
                <div class="tour-block__desc fade-in-section">
                    Countryside Fashion Tour — A Chic Escape to Europe's Hidden Gems.<br>
                    Step into a world where nature meets style. This exclusive fashion tour takes you through the most picturesque countryside locations in Europe — from charming villages to elegant châteaux. Discover local ateliers, vintage markets, and artisanal boutiques, all while enjoying curated fashion experiences, wine tastings, and fine dining in breathtaking rural settings.
                </div>
                <div class="tour-block__actions">
                    <a href="#" class="btn btn-black fade-in-section">discover</a>
                                      <a href="#" class="btn btn-outline fade-in-section">reserve</a>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
.tours-hero {
      font-family: 'Inter';
}

.container {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 16px;
}
.tours-hero__lead {
        font-size: 16px;
        color: #aaaaaa;
    margin: 56px 0 56px 0;
    text-align: left;
    line-height: 1.5;
    text-align: justify;
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
/*.btn-black:hover {
    background: #fff;
    color: black;
    border: 2px, solid;
}*/
.tour-block--reverse {
    flex-direction: row-reverse;
}
@media (max-width: 900px) {
    .tour-block, .tour-block--reverse {
        flex-direction: column; 
        gap: 26px;
        align-items: stretch;
    }
  body {
    margin: 0px;
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

@endsection
