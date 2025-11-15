@extends('layouts.app')

@section('title', 'Отзывы - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
    <style>
        .reviews-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .review {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .review-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .review-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        .review-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .review-meta p {
            margin: 0;
            font-weight: bold;
            color: #333;
        }
        .stars {
            display: flex;
            gap: 5px;
        }
        .review-comment {
            line-height: 1.6;
            color: #555;
            margin: 0;
        }
        .btn-primary {
            background: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 30px;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: #0056b3;
            color: white;
            text-decoration: none;
        }
        .no-reviews {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
@endsection

@section('content')
    <div class="reviews-container">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="font-size: 2.5rem; margin-bottom: 10px;">ОТЗЫВЫ</h1>
            <p style="color: #666; font-size: 1.1rem;">Что говорят наши путешественники</p>
        </div>

        <div style="text-align: center; margin-bottom: 40px;">
            <a href="{{ route('reviews.create') }}" class="btn-primary">
                📝 Оставить отзыв
            </a>
        </div>

        <div class="reviews">
            @forelse($reviews as $review)
                <div class="review">
                    <div class="review-header">
                        <img src="{{ $review->author_avatar }}" alt="{{ $review->author_name }}">
                        <div>
                            <p style="font-weight: bold; margin: 0; color: #333;">{{ $review->author_name }}</p>
                            <p style="margin: 0; color: #666; font-size: 0.9rem;">{{ $review->formatted_date }}</p>
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
                    <a href="{{ route('reviews.create') }}" class="btn-primary" style="margin-top: 20px;">
                        Оставить первый отзыв
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
