@extends('layouts.app')

@section('title', 'Подтверждение Email - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('content')
    <div class="main-wrapper" style="text-align:center; margin-top: 50px;">
        <img src="{{ asset('img/Лого.svg') }}" alt="Nomadic Tour" width="150">
        <h2>Подтвердите ваш Email</h2>

        @if (session('status') == 'verification-link-sent')
            <p style="color: green;">На ваш почтовый ящик отправлена новая ссылка для подтверждения.</p>
        @endif

        <p>Мы отправили письмо на ваш адрес <strong>{{ auth()->user()->email }}</strong>.</p>
        <p>Если вы не получили письмо, вы можете запросить повторную отправку:</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" style="background-color: #d9534f; color: #fff; border: none; border-radius: 25px; padding: 10px 20px; cursor: pointer;">
                Отправить повторно
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" style="background-color: #ccc; color: #000; border: none; border-radius: 25px; padding: 10px 20px; cursor: pointer;">
                Выйти
            </button>
        </form>
    </div>
@endsection
