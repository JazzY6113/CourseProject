@extends('layouts.app')

@section('title', 'Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div>
            <p>ТУР<br>НА АЛТАЙ</p>
        </div>
        <div>
            <div>
                <p>Горный Алтай славится своей природой -
                    <br>горными массивами, чистыми озёрами
                    <br>и водопадами, многообразием флоры и фауны,
                    <br>целебными источниками, перевалами, долинами.</p>
            </div>
            <div>
                <a href="{{ url('/tour') }}">Выбрать тур</a>
                <a href="{{ url('/hot') }}">Горящие туры</a>
            </div>
        </div>
    </div>
@endsection
