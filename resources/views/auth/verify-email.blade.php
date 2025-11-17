@extends('layouts.app')

@section('title', 'Подтверждение Email - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('content')
    <div class="main-wrapper verify-container">
        <img src="{{ asset('img/Лого.svg') }}" alt="Nomadic Tour" class="verify-logo">
        <h2 class="verify-title">Подтвердите ваш Email</h2>

        @if (session('status') == 'verification-link-sent')
            <p class="verify-success">На ваш почтовый ящик отправлена новая ссылка для подтверждения.</p>
        @endif

        <p class="verify-text">Мы отправили письмо на ваш адрес <strong>{{ auth()->user()->email }}</strong>.</p>
        <p class="verify-text">Если вы не получили письмо, вы можете запросить повторную отправку:</p>

        <form method="POST" action="{{ route('verification.send') }}" class="verify-form">
            @csrf
            <button type="submit" class="verify-button">
                Отправить повторно
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="logout-button">
                Выйти
            </button>
        </form>
    </div>
@endsection
