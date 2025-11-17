@extends('layouts.app')

@section('title', 'Восстановление пароля')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <form method="POST" action="{{ route('password.email') }}" class="forgot-form">
            @csrf
            <fieldset class="form-fieldset">
                <div class="form-container">
                    <h2 class="form-title">Восстановление пароля</h2>
                    <p class="form-subtitle">Введите ваш e-mail, на него придет ссылка для сброса</p>

                    <input type="email" name="email" placeholder="E-mail" required class="form-input">
                    @error('email')
                    <span class="error-message">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="submit-button">Отправить ссылку</button>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
