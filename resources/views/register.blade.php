@extends('layouts.app')

@section('title', 'Регистрация - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <script src="{{ asset('js/validation.js') }}"></script>
@endsection

@section('content')
    <div class="main-wrapper">
        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf
            <fieldset class="form-fieldset">
                <div class="form-container">
                    <a href="{{ url('/') }}" class="logo-link">
                        <img src="{{ asset('img/Лого.svg') }}" alt="logo">
                    </a>
                    <p class="form-title">Регистрация</p>
                    <p class="form-subtitle">Введите свои данные</p>

                    <input type="text" id="first_name" name="first_name" placeholder="Имя" value="{{ old('first_name') }}" required class="form-input">
                    @error('first_name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror

                    <input type="text" id="last_name" name="last_name" placeholder="Фамилия" value="{{ old('last_name') }}" required class="form-input">
                    @error('last_name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror

                    <input type="text" id="patronymic" name="patronymic" placeholder="Отчество (необязательно)" value="{{ old('patronymic') }}" class="form-input">

                    <input type="email" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required class="form-input">
                    @error('email')
                    <span class="error-message">{{ $message }}</span>
                    @enderror

                    <input type="password" id="password" name="password" placeholder="Пароль" required class="form-input">
                    @error('password')
                    <span class="error-message">{{ $message }}</span>
                    @enderror

                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Повторите пароль" required class="form-input">

                    <div class="form-footer">
                        <p class="privacy-text">
                            Нажимая на кнопку,
                            вы даете согласие на обработку своих персональных данных и
                            соглашаетесь
                            <a href="" class="privacy-link">c политикой конфиденциальности</a>.
                        </p>
                        <button type="submit" class="submit-button">
                            <span class="button-text">Зарегистрироваться</span>
                        </button>
                    </div>

                    <div class="login-redirect">
                        <p>Уже есть аккаунт? <a href="{{ route('login') }}" class="login-link">Войти</a></p>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
