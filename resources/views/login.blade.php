@extends('layouts.app')

@section('title', 'Вход - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="{{ asset('js/validation.js') }}"></script>
@endsection

@section('content')
    <div class="main-wrapper">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <fieldset>
                <div>
                    <a href="{{ url('/') }}"><img src="{{ asset('img/Лого.svg') }}" alt="logo"></a>
                    <p>Вход</p>
                    <p>Введите свои данные</p>

                    <input type="email" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                    @error('email')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror

                    <input type="password" id="password" name="password" placeholder="Пароль" required>
                    @error('password')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror

                    <div>
                        <button type="submit">
                            <a>Войти</a>
                        </button>
                    </div>

                    <div style="margin-top: 20px; text-align: center;">
                        <p><a href="{{ route('password.request') }}">Забыли пароль?</a></p>
                        <p>Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
