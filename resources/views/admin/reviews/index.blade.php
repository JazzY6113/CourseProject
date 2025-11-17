@extends('layouts.app')

@section('title', 'Модерация отзывов - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/reviews.css') }}">
@endsection

@section('content')
    <div class="reviews-container">
        <h1 class="reviews-title">Модерация отзывов</h1>

        <div class="reviews-section">
            <h2 class="section-title">Ожидающие модерации ({{ $pendingReviews->count() }})</h2>

            @forelse($pendingReviews as $review)
                <div class="review-card review-card--pending">
                    <div class="review-header">
                        <div class="review-info">
                            <strong class="review-author">{{ $review->user->first_name }} {{ $review->user->last_name }}</strong>
                            <br>
                            <small class="review-date">{{ $review->created_at->format('d.m.Y H:i') }}</small>
                            <br>
                            <strong class="review-tour">Тур: {{ $review->tour->title }}</strong>
                            <br>
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                                ({{ $review->rating }}/5)
                            </div>
                        </div>
                        <div class="review-actions">
                            <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}" class="action-form">
                                @csrf
                                <button type="submit" class="btn btn--approve">
                                    Опубликовать
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.reviews.reject', $review->id) }}" class="action-form">
                                @csrf
                                <button type="submit" class="btn btn--reject">
                                    Отклонить
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="review-comment">{{ $review->comment }}</p>
                </div>
            @empty
                <p class="no-reviews">Нет отзывов, ожидающих модерации.</p>
            @endforelse
        </div>

        <div class="reviews-section">
            <h2 class="section-title">Опубликованные отзывы ({{ $approvedReviews->count() }})</h2>

            @forelse($approvedReviews as $review)
                <div class="review-card review-card--approved">
                    <div class="review-header">
                        <div class="review-info">
                            <strong class="review-author">{{ $review->user->first_name }} {{ $review->user->last_name }}</strong>
                            <br>
                            <small class="review-date">{{ $review->created_at->format('d.m.Y H:i') }}</small>
                            <br>
                            <strong class="review-tour">Тур: {{ $review->tour->title }}</strong>
                            <br>
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                                ({{ $review->rating }}/5)
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" class="action-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn--delete">
                                Удалить
                            </button>
                        </form>
                    </div>
                    <p class="review-comment">{{ $review->comment }}</p>
                </div>
            @empty
                <p class="no-reviews">Нет опубликованных отзывов.</p>
            @endforelse
        </div>
    </div>
@endsection
