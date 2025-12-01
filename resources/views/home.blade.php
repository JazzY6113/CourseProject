@extends('layouts.app')

@section('title', 'Nomadic Tour - Туры на Алтай')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <div class="home-hero">
        <div class="hero-content">
            <h1 class="hero-title">ТУР<br>НА АЛТАЙ</h1>
            <p class="hero-description">
                Горный Алтай славится своей природой - горными массивами, чистыми озёрами
                и водопадами, многообразием флоры и фауны, целебными источниками, перевалами, долинами.
            </p>
            <div class="hero-actions">
                <a href="{{ url('/tour') }}" class="hero-btn hero-btn-primary">Выбрать тур</a>
                <a href="{{ url('/hot') }}" class="hero-btn hero-btn-secondary">Горящие туры</a>
            </div>
        </div>
    </div>
@endsection
