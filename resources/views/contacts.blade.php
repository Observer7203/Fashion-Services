@extends('layouts.app')
@section('title', 'Contacts')
@section('content')

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Raleway:wght@700&family=Mulish:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Inter', Arial, sans-serif;
      background: #fff;
      color: #232323;
    }
    .contacts-wrap {
      max-width: 1200px;
      margin: 50px auto;
      padding: 0 30px;
      display: flex;
      gap: 90px;
      align-items: flex-start;
      justify-content: flex-start;
      margin-bottom: 100px;
      margin-top: 100px;
    }
    .contacts-form-col {
      flex: 1.1;
      display: flex;
      flex-direction: column;
      min-width: 350px;
    }
    .contacts-form-title {
      font-family: 'Raleway', Arial, sans-serif;
      font-size: 2.5rem;
      font-weight: 700;
      margin: 0 0 42px 0;
      letter-spacing: 0.01em;
      text-transform: uppercase;
    }
    .contacts-form {
      display: flex;
      flex-direction: column;
      gap: 26px;
      width: 100%;
    }
    .contacts-form input,
    .contacts-form textarea {
      font-family: 'Inter', Arial, sans-serif;
      font-size: 1.1rem;
      border: 1.5px solid #bbb;
      border-radius: 0;
      padding: 16px 14px;
      margin: 0;
      background: #fff;
      color: #232323;
      outline: none;
      transition: border 0.2s;
      resize: none;
    }
    .contacts-form input:focus,
    .contacts-form textarea:focus {
      border: 1.5px solid #232323;
    }
    .contacts-form textarea {
      min-height: 90px;
    }
    .contacts-form button {
      margin-top: 8px;
      padding: 14px 0;
      font-family: 'Inter', Arial, sans-serif;
      font-size: 1.12rem;
      background: #232323;
      color: #fff;
      border: none;
      cursor: pointer;
      transition: background .2s;
      text-transform: none;
      border-radius: 0;
    }
    .contacts-form button:hover {
      background: #444;
    }

    .contacts-info-title {
      font-family: 'Raleway', Arial, sans-serif;
      font-size: 2.05rem;
      font-weight: 700;
      margin: 0 0 34px 0;
      letter-spacing: 0.01em;
    }
    .contacts-info-block {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }
    .contacts-info-block div {
      margin-bottom: 0;
    }
    .contacts-info-label {
      font-family: 'Mulish', Arial, sans-serif;
      font-weight: 700;
      font-size: 1.12rem;
      margin-bottom: 3px;
      color: #232323;
      letter-spacing: 0.02em;
    }
    .contacts-info-value {
      font-family: 'Inter', Arial, sans-serif;
      color: #787878;
      font-size: 1.08rem;
      font-weight: 400;
      margin-bottom: 0;
    }
    @media (max-width: 900px) {
      .contacts-wrap {
        flex-direction: column;
        gap: 45px;
        padding: 0 10px;
      }
      .contacts-info-col {
        margin-left: 0;
      }
    }
    @media (max-width: 600px) {
      .contacts-form-title, .contacts-info-title {
        font-size: 1.35rem;
      }
      .contacts-wrap { margin: 20px 0; }
      .contacts-info-col, .contacts-form-col { min-width: 0; }
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

        .contacts-info-col {
    flex: 1;
    min-width: 320px;
    display: flex;
    flex-direction: column;
    margin-top: 6px;
    margin-left: 40px;
    left: 100px;
    position: relative;
}
    </style>
   

<section class="about-banner fade-in-section" style="background-image: url('https://cdn1.kdt.kz/files/sites/1713254119191113/files/%D0%9D%D0%BE%D0%B2%D0%B0%D1%8F%D0%9F%D0%B0%D0%BF%D0%BA%D0%B0/470900623_894009546217894_6161413880945939838_n.jpg?_t=1747716076');">
  <div class="about-banner__content container">
    <h1 class="about-main-title fade-in-section">CONTACTS</h1>
    <nav class="breadcrumbs fade-in-section" aria-label="Breadcrumb">
      <ul>
        <li><a href="/">Home</a></li>
        <li class="separator">/</li>
        <li class="current">Contacts</li>
      </ul>
    </nav>
  </div>
</section>
  <div class="contacts-wrap fade-in-section">
    <div class="contacts-form-col">
      <div class="contacts-form-title fade-in-section">LEAVE A REQUEST</div>
      <form class="contacts-form fade-in-section" autocomplete="off">
        <input type="text" placeholder="Name*" required>
        <input type="email" placeholder="Email*" required>
        <input type="tel" placeholder="Telephone*" required>
        <textarea placeholder="Your request" required></textarea>
        <button type="submit">Send Request</button>
      </form>
    </div>
    <div class="contacts-info-col fade-in-section">
      <div class="contacts-info-title">Get info</div>
      <div class="contacts-info-block">
        <div class="fade-in-section">
          <div class="contacts-info-label">Adress</div>
          <div class="contacts-info-value">3, rue Fransois Bonvin, Saint<br>Germain en Laye, 78100 France</div>
        </div>
        <div class="fade-in-section">
          <div class="contacts-info-label">Phone number</div>
          <div class="contacts-info-value">+ 33 608083420</div>
        </div>
        <div class="fade-in-section">
          <div class="contacts-info-label">E-mail adress</div>
          <div class="contacts-info-value">baktygul.bulatkali@gmail.com</div>
        </div>
        <div class="fade-in-section">
          <div class="contacts-info-label">Instagram</div>
          <div class="contacts-info-value">@b.b.b.style</div>
        </div>
      </div>
    </div>
  </div>
<!-- КАРТА: -->
<div style="width:100vw;position:relative;left:50%;right:50%;margin-left:-50vw;margin-right:-50vw;margin-top:40px;">
  <iframe
    src="https://www.google.com/maps?q=3,+rue+Fransois+Bonvin,+Saint+Germain+en+Laye,+78100+France&output=embed"
    width="100%"
    height="400"
    style="border:0; min-height:50vh; display:block;"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

@endsection