@extends('layouts.app')

@section('title', 'Вход - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}">
    <script src="{{ asset('js/validation.js') }}" defer></script>
@endsection

@section('content')
    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <a href="{{ url('/') }}" class="auth-logo">
                        <img src="{{ asset('img/Лого.svg') }}" alt="Nomadic Tour">
                    </a>
                    <h1 class="auth-title">Вход</h1>
                    <p class="auth-subtitle">Введите свои данные</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               class="form-input"
                               placeholder="your@email.com"
                               required
                               data-validate="email">
                        @error('email')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" id="password" name="password"
                               class="form-input"
                               placeholder="Введите пароль"
                               required>
                        @error('password')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Войти
                    </button>

                    <div class="auth-footer">
                        <p><a href="{{ route('password.request') }}" class="auth-link">Забыли пароль?</a></p>
                        <p>Нет аккаунта? <a href="{{ route('register') }}" class="auth-link">Зарегистрироваться</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
