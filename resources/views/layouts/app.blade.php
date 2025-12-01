<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    @yield('styles')
    <script src="{{ asset('js/scripts/header.js') }}" defer></script>
    <title>@yield('title', 'Nomadic Tour')</title>
</head>
<body>
<header>
    <div class="header-nav">
        <div class="logo-container">
            <a href="{{ url('/') }}"><img src="{{ asset('img/Лого.svg') }}" alt="Nomadic Tour" class="logo"></a>
        </div>
        <nav class="menu">
            <a href="{{ url('/') }}">главная</a>
            <a href="{{ url('/hot') }}">горящие туры</a>
            <a href="{{ url('/tour') }}">туры</a>
            <a href="{{ url('/aboutus') }}">о нас</a>
            <a href="{{ url('/reviews') }}">отзывы</a>
            <a href="{{ url('/contact') }}">контакты</a>
            @auth
                <a href="{{ route('booking.user-list') }}">мои бронирования</a>
                <a href="{{ route('profile') }}">личный кабинет ({{ Auth::user()->first_name }})</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">выход</a>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.tours') }}">Админка</a>
                @endif
            @else
                <a href="{{ url('/login') }}">войти</a>
            @endauth
        </nav>
        <nav class="mobile-nav">
            <div class="burger">
                |
                |
                |
            </div>
            <ul class="nav-menu">
                <li><a href="{{ url('/') }}">главная</a></li>
                <li><a href="{{ url('/hot') }}">горящие туры</a></li>
                <li><a href="{{ url('/tour') }}">туры</a></li>
                <li><a href="{{ url('/aboutus') }}">о нас</a></li>
                <li><a href="{{ url('/reviews') }}">отзывы</a></li>
                <li><a href="{{ url('/contact') }}">контакты</a></li>
                @auth
                    <li><a href="{{ route('booking.user-list') }}">мои бронирования</a></li>
                    <li><a href="{{ route('profile') }}">личный кабинет ({{ Auth::user()->first_name }})</a></li>
                    @if(Auth::user()->isAdmin())
                        <li><a href="{{ route('admin.tours') }}">Админка</a></li>
                    @endif
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">выход</a></li>
                @else
                    <li><a href="{{ url('/login') }}">войти</a></li>
                @endauth
            </ul>
        </nav>
    </div>
</header>

<main>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<footer>
    <div class="footer-nav">
        <div class="footer-section">
            <a href="{{ url('/') }}" class="footer-logo">NOMADIC TOUR</a>
            <a href="{{ url('/') }}">главная</a>
            <a href="{{ url('/hot') }}">горящие туры</a>
            <a href="{{ url('/tour') }}">туры</a>
            <a href="{{ url('/aboutus') }}">о нас</a>
            <a href="{{ url('/reviews') }}">отзывы</a>
            <a href="{{ url('/contact') }}">контакты</a>
        </div>
        <div class="footer-section">
            <div class="contact-item">
                <a href="mailto:nomadictour@gmail.com">
                    <img src="{{ asset('img/email.svg') }}" alt="email" class="contact-icon">
                    nomadictour@gmail.com
                </a>
            </div>
            <a href="#" class="footer-link">политика конфиденциальности</a>
            <a href="#" class="footer-link">пользовательское соглашение</a>
            <div class="contact-item">
                <a href="tel:+78005553535">
                    <img src="{{ asset('img/phone.svg') }}" alt="phone" class="contact-icon">
                    +7(800)555-35-35
                </a>
            </div>
        </div>
        <div class="footer-section">
            <p class="footer-note">* не является офертой</p>
            <p class="footer-text">наши социальные сети</p>
            <div class="social-links">
                <a href="#" aria-label="Telegram"><img src="{{ asset('img/telegram.svg') }}" alt="telegram"></a>
                <a href="#" aria-label="Instagram"><img src="{{ asset('img/instagram.svg') }}" alt="instagram"></a>
                <a href="#" aria-label="VK"><img src="{{ asset('img/vk.svg') }}" alt="vk"></a>
            </div>
            <p class="footer-copyright">2025</p>
        </div>
    </div>
</footer>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>
</body>
</html>
