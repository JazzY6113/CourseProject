@extends('layouts.app')

@section('title', 'Горящие туры - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/tour.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div class="page-title">
            <h1>ГОРЯЩИЕ ТУРЫ</h1>
        </div>

        @if($hotTours->count() > 0)
            <div class="tours-grid">
                @foreach($hotTours as $tour)
                    <div class="tour-card">
                        <div class="tour-image"
                             style="background-image: url('{{ $tour->images->count() > 0 ? asset('storage/' . $tour->images->first()->image_path) : asset('img/default-tour.jpg') }}')"
                             loading="lazy">
                            <p class="tour-title">{{ $tour->title }}</p>
                        </div>
                        <div class="tour-content">
                            <p class="tour-description">{{ Str::limit($tour->short_description, 200) }}</p>
                            <div class="tour-price">{{ number_format($tour->base_price, 0, ',', ' ') }} руб</div>
                            <a href="{{ route('tour.detail', $tour->id) }}" class="tour-link">СМОТРЕТЬ ТУР</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-tours">
                <p>Пока нет горящих туров</p>
                <a href="{{ route('tour') }}" class="btn btn-primary">Посмотреть все туры</a>
            </div>
        @endif
    </div>
@endsection
