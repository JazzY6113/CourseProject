@extends('layouts.app')

@section('title', 'Туры - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/tour.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div>
            <p>ТУРЫ</p>
        </div>

        @if(isset($tours) && $tours->count() > 0)
            <div class="containers">
                @foreach($tours as $tour)
                    <div class="container{{ ($loop->iteration % 9) + 1 }}">
                        <div class="image-container{{ ($loop->iteration % 9) + 1 }}"
                             @if($tour->images->count() > 0)
                                 style="background-image: url('{{ asset('storage/' . $tour->images->first()->image_path) }}')"
                             @else
                                 style="background-image: url('{{ asset('img/default-tour.jpg') }}')"
                            @endif>
                            <p>{{ $tour->title }}</p>
                        </div>
                        <p>{{ Str::limit($tour->short_description, 200) }}</p>
                        <div>
                            <p>{{ number_format($tour->price, 0, ',', ' ') }} руб</p>
                        </div>
                        <a href="{{ route('tour.detail', $tour->id) }}">СМОТРЕТЬ ТУР</a>
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
