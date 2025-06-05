@extends ('layouts.app')
@section('title', 'Услуга')
@section('content')

<link href="https://fonts.googleapis.com/css?family=Raleway:700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background: #fff;
            color: #212121;
            font-family: 'Inter', Arial, sans-serif;
        }
        .main-section {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px 32px 24px;
            gap: 44px;
            align-items: flex-start;
              text-align: justify;
        }
        .content {
            flex: 0 0 75%;
            max-width: 75%;
            min-width: 320px;
            box-sizing: border-box;
             margin-top: 80px;
        }
        .service-img-wrap {
            width: 100%;
            margin-bottom: 30px;
        }
        .service-img-wrap img {
            width: 100%;
            height: auto;
            display: block;
            box-shadow: 0 6px 32px #d3d3d37a;
            object-fit: cover;
            max-height: 500px;
        }
        .service-title {
            font-family: 'Raleway', Arial, sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0 0 10px 0;
            letter-spacing: 1px;
        }
        .service-desc {
font-size: 16px;
    margin-bottom: 26px;
    line-height: 1.55;
    color: #a5a5a5;
    font-family: 'Inter', Arial, sans-serif;
        }
        .service-quote {
            font-style: italic;
            font-size: 1.15rem;
            color: #6a5372;
            border-left: 3px solid #d02570;
            padding-left: 20px;
            margin: 30px 0 32px 0;
            font-family: 'Inter', Arial, sans-serif;
        }
        .service-details {
font-size: 16px;
    margin-bottom: 26px;
    line-height: 1.55;
    color: #a5a5a5;
    font-family: 'Inter', Arial, sans-serif;
        }
        .order-btn {
            padding: 13px 38px;
            background: #181818;
            color: #fff;
            border: none;
            font-family: 'Inter';
            font-size: 16px;
            font-weight: 300;
            letter-spacing: 1px;
            cursor: pointer;
            text-transform: lowercase;
            margin-top: 18px;
            transition: background 0.18s;
            box-shadow: 0 2px 12px #bdbdbd37;
        }
        .order-btn:hover {
            background: #d02570;
        }
        /* Sidebar */
        aside {
            flex: 0 0 25%;
            max-width: 25%;
            min-width: 250px;
            margin-top: 80px;
        }
        .sidebar-block {
            background: #faf6fa;
            border-radius: 10px;
            margin-bottom: 22px;
            padding: 26px 22px 18px 22px;
            box-shadow: 0 4px 18px #e6e6e6a2;
        }
        .sidebar-block h4 {
            font-family: 'Raleway', Arial, sans-serif;
            font-weight: 700;
            margin: 0 0 12px 0;
            font-size: 1.08rem;
            color: #d02570;
            letter-spacing: 0.5px;
        }
        .sidebar-block ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-block ul li {
            margin-bottom: 8px;
            color: #494949;
            font-size: 15px;
        }
        .sidebar-block .sidebar-title {
            font-size: 1rem;
            font-family: 'Inter', Arial, sans-serif;
            color: #232323;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .about-me-block {
            text-align: left;
            margin-bottom: 30px;
        }
        .about-me-block h5 {
            font-family: 'Raleway', Arial, sans-serif;
            font-size: 1rem;
            margin: 0 0 7px 0;
            color: #d02570;
        }
        .about-me-block p {
            font-size: 14px;
            color: #555;
            margin: 0;
        }
        @media (max-width: 950px) {
            .main-section {
                flex-direction: column;
                gap: 0;
                padding: 36px 3vw 22px 3vw;
            }
            .content, aside {
                max-width: 100%;
                flex: 1 1 100%;
                min-width: 0;
            }
            .service-img-wrap img
        }
        @media (max-width: 600px) {
            .main-section { padding: 16px 1vw 10px 1vw; }
            .service-title { font-size: 1.1rem; }
            .sidebar-block, .about-me-block { padding: 11px 5px 8px 5px; }
            .service-img-wrap img { max-height: 120px; }
        }
    </style>

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
    </style>
   

<section class="about-banner fade-in-section" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/405200428_372791005200701_2072196467200213261_n%20%281%29%20%E2%80%94%20%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F%20%E2%80%94%20%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F.jpg?_t=1748757668');">
  <div class="about-banner__content container">
    <h1 class="about-main-title fade-in-section">PERSONAL STYLING</h1>
    <nav class="breadcrumbs fade-in-section" aria-label="Breadcrumb">
      <ul>
        <li><a href="/">Home</a></li>
        <li class="separator">/</li>
        <li class="current">Services</li>
        <li class="separator">/</li>
        <li class="current">Personal styling</li>
      </ul>
    </nav>
  </div>
</section>
    <div class="main-section">
        <!-- Content -->
        <div class="content">
            <div class="service-img-wrap fade-in-section">
                <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/image8%20%281%29%20%E2%80%94%20%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F.png?_t=1748752186" alt="Personal Styling">
            </div>
            <div class="service-title fade-in-section">Personal styling</div>
            <div class="service-desc fade-in-section">
                My approach is rooted in high fashion sensibility, attention to detail, and a deep understanding of aesthetics. I collaborate with luxury boutiques, designer showrooms, and fashion houses across Paris, Milan, and London, offering early access to exclusive collections and vintage finds. I can also assist with shopping tours, fittings, and full styling management during fashion weeks and overseas trips.<br><br>
                I work internationally with VIP clients, public figures, and professionals from the creative industries, offering fashion-forward styling for editorial photo shoots, video productions, fashion shows, red carpet events, business conferences, and private celebrations. I also provide professional support in modeling and personal branding sessions.
            </div>
            <div class="service-quote fade-in-section">
                “Avec moi, le stylisme ne se limite pas aux vêtements — c’est l’art de raconter votre histoire à travers la mode, de révéler votre personnalité, vos valeurs et votre élégance à chaque détail.”
            </div>
          <div class="row fade-in-section" style="height: 300px; display: flex; gap: 5px;">
            <img class="col-md-6"src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/405551852_1061449608325857_8492329640374453592_n.jpg?_t=1747845690" style="object-fit: cover; width: 100%;"/>
                        <img class="col-md-6" src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/image7.png?_t=1747708616" style="object-fit: cover; width: 100%;"/>
          </div>
            <div class="service-details fade-in-section"><br>
                As a personal stylist working closely with clients in the world of fashion, media, and luxury events, I offer a bespoke styling experience designed to highlight your individuality, elevate your image, and reflect the lifestyle you aspire to.<br><br>
    <div class="fade-in-section" style="height: 400px; height: 400px; overflow: hidden; align-items: center; display: flex
;"><img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/466021798_1082841146616262_1346581091037462494_n.jpg?_t=1747848452" style="    width: -webkit-fill-available;" /></div><br>
                My service begins with an in-depth consultation where I analyze your wardrobe, personal style, body shape, and color profile. From there, I help curate a cohesive and expressive wardrobe — whether you're building your everyday look, preparing for high-profile appearances, or transforming your style completely. 
            </div>
            <button class="order-btn">Order service</button>
        </div>

        <!-- Sidebar -->
        <aside>
    <div class="sidebar-block about-me-custom fade-in-section" style="background: #fff; border-radius: 0; box-shadow: none; padding: 0 0 36px 0; text-align: left;">
        <div class="fade-in-section" style="font-family: 'Raleway', Arial, sans-serif; font-weight: 800; font-size: 2rem; letter-spacing: 1px; margin: 0 0 30px 0; text-transform: uppercase; text-align: left;">ABOUT ME</div>
        <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/IMG_4784%20%E2%80%94%20%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F%20%E2%80%94%20%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F%20%E2%80%94%20%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F.jpeg?_t=1748759633"
             alt="Baktygul Bulatkali" style="width: 190px; height: 190px; object-fit: cover; display: block;"><br>
        <div class="fade-in-section" style="color: #aaaaaa; font-family: 'Inter', Arial, sans-serif; font-size: 1rem; line-height: 1.55; margin-bottom: 38px; font-weight: 400;">
            Stylist and fashion influencer<br>with 9 years of experience in<br>the fashion industry.
        </div>
        <div class="fade-in-section" style="font-family: 'Raleway', Arial, sans-serif; font-weight: 800; font-size: 1.18rem; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 14px;">INSTAGRAM</div>
        <a href="{{ url('/instagram') }}" target="_blank"
           style="display: inline-block; padding: 17px 30px; background: #111; color: #fff; border-radius: 2px; font-family: 'Inter', Arial, sans-serif; font-size: 1.07rem; font-weight: 500; letter-spacing: 0.3px; text-decoration: none; margin-bottom: 10px;">
            @bbb.style
        </a>
    </div>

          
            <!-- Other Services -->
        <!-- Other Services -->
    <div style="margin-bottom: 48px;">
        <div class="fade-in-section" style="font-family:'Raleway',Arial,sans-serif;font-weight:800;    font-size: 1.3rem;text-transform:uppercase;margin-bottom:19px;letter-spacing:0.3px;">OTHER SERVICES</div>
        <div class="fade-in-section" style="display:flex;align-items:center;gap:13px;margin-bottom:18px;">
            <img src="https://lh3.google.com/u/0/d/1gpRLCHwmpbtVsAMPyJmTrK4qETwZgecA=w1920-h912-iv1?auditContext=prefetch"
                 alt="Fashion Tours" style="width:100px;height:100px;object-fit:cover;">
            <span style="font-family:'Raleway',Arial,sans-serif;font-weight:800;font-size:1rem;text-transform:uppercase;line-height:1.2;">
                FASHION<br>TOURS
            </span>
        </div>
        <div class="fade-in-section" style="display:flex;align-items:center;gap:13px;margin-bottom:18px;">
            <img src="https://lh3.google.com/u/0/d/15JjTL4K_gYqGOljKZlOO8iVlXq1yfo9p=w1607-h912-iv1?auditContext=prefetch"
                 alt="Concierge Services" style="width:100px;height:100px;object-fit:cover;">
            <span style="font-family:'Raleway',Arial,sans-serif;font-weight:800;font-size:1rem;text-transform:uppercase;line-height:1.2;">
                CONCIERGE<br>SERVICES
            </span>
        </div>
        <div class="fade-in-section" style="display:flex;align-items:center;gap:13px;margin-bottom:18px;">
            <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/IMG_3604.JPG?_t=1747708855"
                 alt="Paris Fashion Week" style="width:100px;height:100px;object-fit:cover;">
            <span style="font-family:'Raleway',Arial,sans-serif;font-weight:800;font-size:1rem;text-transform:uppercase;line-height:1.2;">
                PARIS FASHION<br>WEEK
            </span>
        </div>
    </div>

    <!-- Fashion Tours -->
    <div style="margin-bottom: 38px;">
        <div class="fade-in-section" style="font-family:'Raleway',Arial,sans-serif;font-weight:800;    font-size: 1.3rem;text-transform:uppercase;margin-bottom:20px;">FASHION TOURS</div>
        <div class="fade-in-section" style="margin-bottom:20px;font-family:'Inter',Arial,sans-serif;font-size:15px;font-weight:400;color:#888;line-height:1.3;">PARIS FASHION WEEK</div>
        <div class="fade-in-section" style="margin-bottom:20px;font-family:'Inter',Arial,sans-serif;font-size:15px;font-weight:400;color:#888;">STYLING TOUR</div>
        <div class="fade-in-section" style="margin-bottom:20px;font-family:'Inter',Arial,sans-serif;font-size:15px;font-weight:400;color:#888;">PFW - STREET STYLE</div>
        <div class="fade-in-section" style="margin-bottom:20px;font-family:'Inter',Arial,sans-serif;font-size:15px;font-weight:400;color:#888;">PFW - EXPRESS PACKAGE</div>
   <div class="fade-in-section" style="margin-bottom:20px;font-family:'Inter',Arial,sans-serif;font-size:15px;font-weight:400;color:#888;">VINTAGE TOUR</div>
    </div>

    <!-- Banner -->
    <div class="fade-in-section" style="width:100%;display:flex; justify-content: left;    margin-bottom: 40px;">
        <img src="https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/banner.png?_t=1748761685"
             alt="Banner" style="width:100%;max-width:260px;height:auto;object-fit:cover;">
    </div>
            <!-- Events -->
    <div style="margin-bottom: 58px;">
        <div class="fade-in-section" style="font-family:'Raleway',Arial,sans-serif;font-weight:800;    font-size: 1.3rem;text-transform:uppercase;margin-bottom:22px;letter-spacing:0.4px;">
            EVENTS
        </div>
        <div class="fade-in-section" style="font-family:'Inter',Arial,sans-serif;font-size:1rem;font-weight:400;color:#aaaaaa;margin-bottom:20px;line-height:1.25;">
            Paris Fashion Week
        </div>
        <div class="fade-in-section" style="font-family:'Inter',Arial,sans-serif;font-size:1rem;font-weight:400;color:#aaaaaa;margin-bottom:20px;line-height:1.25;">
            Viktor & Rolf Haute Couture<br>Spring/Summer 2023
        </div>
        <div class="fade-in-section" style="font-family:'Inter',Arial,sans-serif;font-size:1rem;font-weight:400;color:#aaaaaa;margin-bottom:20px;line-height:1.25;">
            Versace House Party |<br>Pre-Fall 2020 Campaign
        </div>
        <div class="fade-in-section" style="font-family:'Inter',Arial,sans-serif;font-size:1rem;font-weight:400;color:#aaaaaa;margin-bottom:20px;line-height:1.25;">
            Countryside Tour
        </div>
    </div>
        </aside>
    </div>

@endsection