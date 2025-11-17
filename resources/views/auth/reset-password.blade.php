@extends('layouts.app')

@section('title', 'Сброс пароля - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <form method="POST" action="{{ route('password.update') }}" class="reset-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <fieldset class="form-fieldset">
                <div class="form-container">
                    <a href="{{ url('/') }}" class="logo-link">
                        <img src="{{ asset('img/Лого.svg') }}" alt="logo">
                    </a>
                    <p class="form-title">Введите новый пароль</p>

                    <input type="email" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required class="form-input">
                    @error('email')
                    <span class="error-message">{{ $message }}</span>
                    @enderror

                    <input type="password" id="password" name="password" placeholder="Новый пароль" required class="form-input">
                    @error('password')
                    <span class="error-message">{{ $message }}</span>
                    @enderror

                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Повторите пароль" required class="form-input">

                    <div class="form-actions">
                        <button type="submit" class="submit-button">
                            <span class="button-text">Сбросить пароль</span>
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
