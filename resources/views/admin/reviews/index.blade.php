@extends('layouts.app')

@section('title', 'Модерация отзывов - Nomadic Tour')

@section('content')
    <div class="main-wrapper" style="max-width: 1200px; margin: auto; padding: 20px;">
        <h1>Модерация отзывов</h1>

        <div style="margin-bottom: 40px;">
            <h2>Ожидающие модерации ({{ $pendingReviews->count() }})</h2>

            @forelse($pendingReviews as $review)
                <div style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 5px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                        <div>
                            <strong>{{ $review->user->first_name }} {{ $review->user->last_name }}</strong>
                            <br>
                            <small>{{ $review->created_at->format('d.m.Y H:i') }}</small>
                            <br>
                            <strong>Тур: {{ $review->tour->title }}</strong>
                            <br>
                            <div style="color: #ffc107;">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                                ({{ $review->rating }}/5)
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}">
                                @csrf
                                <button type="submit" style="background: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">
                                    Опубликовать
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.reviews.reject', $review->id) }}">
                                @csrf
                                <button type="submit" style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">
                                    Отклонить
                                </button>
                            </form>
                        </div>
                    </div>
                    <p>{{ $review->comment }}</p>
                </div>
            @empty
                <p>Нет отзывов, ожидающих модерации.</p>
            @endforelse
        </div>

        <div>
            <h2>Опубликованные отзывы ({{ $approvedReviews->count() }})</h2>

            @forelse($approvedReviews as $review)
                <div style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 5px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                        <div>
                            <strong>{{ $review->user->first_name }} {{ $review->user->last_name }}</strong>
                            <br>
                            <small>{{ $review->created_at->format('d.m.Y H:i') }}</small>
                            <br>
                            <strong>Тур: {{ $review->tour->title }}</strong>
                            <br>
                            <div style="color: #ffc107;">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                                ({{ $review->rating }}/5)
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">
                                Удалить
                            </button>
                        </form>
                    </div>
                    <p>{{ $review->comment }}</p>
                </div>
            @empty
                <p>Нет опубликованных отзывов.</p>
            @endforelse
        </div>
    </div>
@endsection
