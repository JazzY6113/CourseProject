@extends('layouts.app')

@section('title', 'Сброс пароля - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <fieldset>
                <div>
                    <a href="{{ url('/') }}"><img src="{{ asset('img/Лого.svg') }}" alt="logo"></a>
                    <p>Введите новый пароль</p>

                    <input type="email" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                    @error('email')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror

                    <input type="password" id="password" name="password" placeholder="Новый пароль" required>
                    @error('password')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror

                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Повторите пароль" required>

                    <div>
                        <button type="submit" style="background: none; border: none; cursor: pointer;">
                            <a style="font-size: 18pt; border: 1px solid red; border-radius: 30px; margin: 2% 0 0 0; padding: 3% 7%; text-align: center; display: inline-block; text-decoration: none;">
                                Сбросить пароль
                            </a>
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
