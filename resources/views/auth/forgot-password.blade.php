@extends('layouts.app')

@section('title', 'Восстановление пароля')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <fieldset>
                <div>
                    <h2>Восстановление пароля</h2>
                    <p>Введите ваш e-mail, на него придет ссылка для сброса</p>

                    <input type="email" name="email" placeholder="E-mail" required>
                    @error('email')
                    <span style="color:red;">{{ $message }}</span>
                    @enderror

                    <button type="submit" style="margin-top:15px;">Отправить ссылку</button>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
