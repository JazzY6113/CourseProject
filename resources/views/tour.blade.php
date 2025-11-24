@extends('layouts.app')

@section('title', 'Туры - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/tour.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div class="page-title">
            <p>ТУРЫ</p>
        </div>

        @if($tours->count() > 0)
            <div class="containers">
                @foreach($tours as $tour)
                    <div class="tour-container container-{{ ($loop->iteration % 9) + 1 }}">
                        <div class="tour-image image-container-{{ ($loop->iteration % 9) + 1 }}"
                             @if($tour->images->count() > 0)
                                 style="background-image: url('{{ asset('storage/' . $tour->images->first()->image_path) }}')"
                             @else
                                 style="background-image: url('{{ asset('img/default-tour.jpg') }}')"
                            @endif>
                            <p class="tour-title">{{ $tour->title }}</p>
                        </div>
                        <p class="tour-description">{{ Str::limit($tour->short_description, 200) }}</p>
                        <div class="price-container">
                            <p class="tour-price">{{ number_format($tour->base_price, 0, ',', ' ') }} руб</p>
                        </div>
                        <a href="{{ route('tour.detail', $tour->id) }}" class="tour-link">СМОТРЕТЬ ТУР</a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-tours">
                <p>Пока нет доступных туров</p>
            </div>
        @endif
    </div>
@endsection
