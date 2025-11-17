<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div>
            <a href="{{ url('/') }}"><img src="{{ asset('img/Лого.svg') }}" alt="logo"></a>
        </div>
        <nav class="menu">
            <a href="{{ url('/') }}">главная</a>
            <a href="{{ url('/hot') }}">горящие туры</a>
            <a href="{{ url('/tour') }}">туры</a>
            <a href="{{ url('/aboutus') }}">о нас</a>
            <a href="{{ url('/reviews') }}">отзывы</a>
            <a href="{{ url('/contact') }}">контакты</a>
            @auth
                <a href="{{ route('profile') }}">личный кабинет ({{ Auth::user()->first_name }})</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    выход
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @if(Auth::user()->role_id === 2)
                    <li><a href="{{ route('admin.tours') }}">Админка</a></li>
                @endif
            @else
                <a href="{{ url('/login') }}">войти</a>
            @endauth
        </nav>
        <nav class="BossBurger">
            <div class="burger">
                |
                |
                |
            </div>
            <menu class="navBurger">
                <li><a href="{{ url('/') }}">главная</a></li>
                <li><a href="{{ url('/hot') }}">горящие туры</a></li>
                <li><a href="{{ url('/tour') }}">туры</a></li>
                <li><a href="{{ url('/aboutus') }}">о нас</a></li>
                <li><a href="{{ url('/reviews') }}">отзывы</a></li>
                <li><a href="{{ url('/contact') }}">контакты</a></li>
                <li><a href="{{ url('/login') }}">войти</a></li>
                @auth
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        выход ({{ Auth::user()->first_name }})
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ url('/login') }}">войти</a>
                @endauth
            </menu>
        </nav>
    </div>
</header>

<main>
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 15px; text-align: center;">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<footer>
    <div class="footer-nav">
        <div>
            <a href="{{ url('/') }}">NOMADIC TOUR</a>
            <a href="{{ url('/') }}">главная</a>
            <a href="{{ url('/hot') }}">горящие туры</a>
            <a href="{{ url('/tour') }}">туры</a>
            <a href="{{ url('/aboutus') }}">о нас</a>
            <a href="{{ url('/reviews') }}">отзывы</a>
            <a href="{{ url('/contact') }}">контакты</a>
        </div>
        <div>
            <div>
                <a href="mailto:nomadictour@gmail.com"><img src="{{ asset('img/email.svg') }}" alt="email"> nomadictour@gmail.com</a>
            </div>
            <a href="">политика конфедициальности</a>
            <a href="">пользовательское соглашение</a>
            <div>
                <a href="tel:+78005553535"><img src="{{ asset('img/phone.svg') }}" alt="phone"> +7(800)555-35-35</a>
            </div>
        </div>
        <div>
            <p>* не является офертой</p>
            <p>наши социальные сети</p>
            <div>
                <a href=""><img src="{{ asset('img/telegram.svg') }}" alt="telegram"></a>
                <a href=""><img src="{{ asset('img/instagram.svg') }}" alt="instagram"></a>
                <a href=""><img src="{{ asset('img/vk.svg') }}" alt="vk"></a>
            </div>
            <p>2024</p>
        </div>
    </div>
</footer>
</body>
</html>
