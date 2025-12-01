@extends('layouts.app')

@section('title', 'Туры - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/tour.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div class="page-title">
            <h1>ТУРЫ</h1>
        </div>

        @if($tours->count() > 0)
            <div class="tours-grid">
                @foreach($tours as $tour)
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

            @if($tours->hasPages())
                <div class="pagination">
                    {{ $tours->links() }}
                </div>
            @endif
        @else
            <div class="no-tours">
                <p>Пока нет доступных туров</p>
                <a href="{{ route('home') }}" class="btn btn-primary">На главную</a>
            </div>
        @endif
    </div>
@endsection
