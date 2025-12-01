@extends('layouts.app')

@section('title', 'Регистрация - Nomadic Tour')

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
                    <h1 class="auth-title">Регистрация</h1>
                    <p class="auth-subtitle">Создайте свой аккаунт</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name" class="form-label">Имя</label>
                            <input type="text" id="first_name" name="first_name"
                                   value="{{ old('first_name') }}"
                                   class="form-input"
                                   placeholder="Иван"
                                   required
                                   data-validate="cyrillic">
                            @error('first_name')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="form-label">Фамилия</label>
                            <input type="text" id="last_name" name="last_name"
                                   value="{{ old('last_name') }}"
                                   class="form-input"
                                   placeholder="Иванов"
                                   required
                                   data-validate="cyrillic">
                            @error('last_name')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="patronymic" class="form-label">Отчество (необязательно)</label>
                        <input type="text" id="patronymic" name="patronymic"
                               value="{{ old('patronymic') }}"
                               class="form-input"
                               placeholder="Иванович">
                        @error('patronymic')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

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
                               placeholder="Создайте пароль"
                               required>
                        @error('password')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-input"
                               placeholder="Повторите пароль"
                               required>
                    </div>

                    <div class="privacy-text">
                        Нажимая на кнопку, вы даете согласие на обработку своих персональных данных и соглашаетесь
                        <a href="#" class="privacy-link">с политикой конфиденциальности</a>.
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Зарегистрироваться
                    </button>

                    <div class="auth-footer">
                        <p>Уже есть аккаунт? <a href="{{ route('login') }}" class="auth-link">Войти</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
