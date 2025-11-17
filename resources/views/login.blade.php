@extends('layouts.app')

@section('title', 'Вход - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="{{ asset('js/validation.js') }}"></script>
@endsection

@section('content')
    <div class="main-wrapper">
        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <fieldset class="form-fieldset">
                <div class="form-container">
                    <a href="{{ url('/') }}" class="logo-link">
                        <img src="{{ asset('img/Лого.svg') }}" alt="logo">
                    </a>
                    <p class="form-title">Вход</p>
                    <p class="form-subtitle">Введите свои данные</p>

                    <input type="email" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required class="form-input">
                    @error('email')
                    <span class="error-message">{{ $message }}</span>
                    @enderror

                    <input type="password" id="password" name="password" placeholder="Пароль" required class="form-input">
                    @error('password')
                    <span class="error-message">{{ $message }}</span>
                    @enderror

                    <div class="form-actions">
                        <button type="submit" class="submit-button">
                            <span class="button-text">Войти</span>
                        </button>
                    </div>

                    <div class="form-links">
                        <p><a href="{{ route('password.request') }}" class="link">Забыли пароль?</a></p>
                        <p>Нет аккаунта? <a href="{{ route('register') }}" class="link">Зарегистрироваться</a></p>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
