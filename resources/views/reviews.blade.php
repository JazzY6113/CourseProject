@extends('layouts.app')

@section('title', 'Отзывы - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
@endsection

@section('content')
    <div class="reviews-container">
        <div class="reviews-header">
            <h1>ОТЗЫВЫ</h1>
            <p>Что говорят наши путешественники</p>
        </div>

        <div class="reviews-actions">
            <a href="{{ route('reviews.create') }}" class="btn-primary">
                Оставить отзыв
            </a>
        </div>

        <div class="reviews-list">
            @forelse($reviews as $review)
                <div class="review-card">
                    <div class="review-header">
                        <img src="{{ $review->author_avatar }}" alt="{{ $review->author_name }}" class="review-avatar">
                        <div class="review-author-info">
                            <p class="author-name">{{ $review->author_name }}</p>
                            <p class="review-date">{{ $review->formatted_date }}</p>
                        </div>
                    </div>
                    <div class="review-meta">
                        <p class="review-tour">Тур: {{ $review->tour->title }}</p>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <span class="star filled">★</span>
                                @else
                                    <span class="star">☆</span>
                                @endif
                            @endfor
                            <span class="rating-text">({{ $review->rating }}/5)</span>
                        </div>
                    </div>
                    <p class="review-comment">{{ $review->comment }}</p>
                </div>
            @empty
                <div class="no-reviews">
                    <h3>Пока нет отзывов</h3>
                    <p>Будьте первым, кто поделится впечатлениями о наших турах!</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
