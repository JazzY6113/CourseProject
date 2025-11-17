@extends('layouts.app')

@section('title', 'Отзывы - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
@endsection

@section('content')
    <div class="reviews-container">
        <div>
            <h1>ОТЗЫВЫ</h1>
            <p>Что говорят наши путешественники</p>
        </div>

        <div>
            <a href="{{ route('reviews.create') }}" class="btn-primary">
                Оставить отзыв
            </a>
        </div>

        <div class="reviews">
            @forelse($reviews as $review)
                <div class="review">
                    <div class="review-header">
                        <img src="{{ $review->author_avatar }}" alt="{{ $review->author_name }}">
                        <div>
                            <p>{{ $review->author_name }}</p>
                            <p>{{ $review->formatted_date }}</p>
                        </div>
                    </div>
                    <div class="review-meta">
                        <p>Тур: {{ $review->tour->title }}</p>
                        <div class="stars">
                            {!! $review->star_rating !!}
                        </div>
                    </div>
                    <p class="review-comment">{{ $review->comment }}</p>
                </div>
            @empty
                <div class="no-reviews">
                    <h3>Пока нет отзывов</h3>
                    <p>Будьте первым, кто поделится впечатлениями о наших турах!</p>
                    <a href="{{ route('reviews.create') }}" class="btn-primary">
                        Оставить первый отзыв
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
