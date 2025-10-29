@extends('layouts.app')

@section('title', 'Горящие туры - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/hot.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div>
            <p>ГОРЯЩИЕ ТУРЫ</p>
        </div>
        <div class="cards">
            @foreach($hotTours as $tour)
                <div class="container{{ $loop->iteration }}">
                    <div class="image-container{{ $loop->iteration }}"
                         style="background-image: url('{{ asset('storage/' . $tour->main_image) }}')">
                        <p>{{ $tour->title }}</p>
                    </div>
                    <p>{{ $tour->short_description }}</p>
                    <div>
                        @if($tour->tourDates->count() > 0)
                            <p>{{ $tour->tourDates->first()->start_date->format('d M') }}</p>
                        @endif
                        <p>{{ number_format($tour->price, 0, ',', ' ') }} руб</p>
                    </div>
                    <a href="{{ route('tour.detail', $tour->id) }}">СМОТРЕТЬ ТУР</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
