@extends('layouts.app')

@section('title', 'Регистрация - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <script src="{{ asset('js/validation.js') }}"></script>
@endsection

@section('content')
    <div class="main-wrapper">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <fieldset>
                <div>
                    <a href="{{ url('/') }}"><img src="{{ asset('img/Лого.svg') }}" alt="logo"></a>
                    <p>Регистрация</p>
                    <p>Введите свои данные</p>

                    <input type="text" id="first_name" name="first_name" placeholder="Имя" value="{{ old('first_name') }}" required>
                    @error('first_name')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror

                    <input type="text" id="last_name" name="last_name" placeholder="Фамилия" value="{{ old('last_name') }}" required>
                    @error('last_name')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror

                    <input type="text" id="patronymic" name="patronymic" placeholder="Отчество (необязательно)" value="{{ old('patronymic') }}">

                    <input type="email" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                    @error('email')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror

                    <input type="password" id="password" name="password" placeholder="Пароль" required>
                    @error('password')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror

                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Повторите пароль" required>

                    <div>
                        <p>
                            Нажимая на кнопку,
                            вы даете согласие на обработку своих персональных данных и
                            соглашаетесь
                            <a href="">c политикой конфиденциальности</a>.
                        </p>
                        <button type="submit">
                            <a>Зарегистрироваться</a>
                        </button>
                    </div>

                    <div style="margin-top: 20px;">
                        <p>Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
