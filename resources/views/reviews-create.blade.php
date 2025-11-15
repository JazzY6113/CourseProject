@extends('layouts.app')

@section('title', 'Оставить отзыв - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
    <style>
        .review-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .star-rating {
            display: flex;
            gap: 10px;
            margin: 10px 0;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            font-size: 30px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #ffc107;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        .btn-primary {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
    </style>
@endsection

@section('content')
    <div class="main-wrapper">
        <div>
            <p>ОСТАВИТЬ ОТЗЫВ</p>
        </div>

        <div class="review-form">
            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf

                <div class="form-group">
                    <label for="tour_id">Выберите тур:</label>
                    <select name="tour_id" id="tour_id" class="form-control" required>
                        <option value="">-- Выберите тур --</option>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}" {{ old('tour_id') == $tour->id ? 'selected' : '' }}>
                                {{ $tour->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('tour_id')
                    <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
                    @enderror
                </div>

                @guest
                    <div class="form-group">
                        <label for="author_name">Ваше имя:</label>
                        <input type="text" name="author_name" id="author_name" class="form-control"
                               value="{{ old('author_name') }}" placeholder="Введите ваше имя" required>
                        @error('author_name')
                        <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>
                @else
                    <div class="form-group">
                        <label>Ваше имя:</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" disabled>
                        <small style="color: #666;">Будет использовано имя из вашего профиля</small>
                    </div>
                @endguest

                <div class="form-group">
                    <label>Оценка:</label>
                    <div class="star-rating">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                   {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label for="star{{ $i }}">★</label>
                        @endfor
                    </div>
                    @error('rating')
                    <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="comment">Ваш отзыв:</label>
                    <textarea name="comment" id="comment" class="form-control" required
                              placeholder="Поделитесь вашими впечатлениями о туре...">{{ old('comment') }}</textarea>
                    @error('comment')
                    <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-primary">
                    Отправить на модерацию
                </button>

                <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 4px;">
                    <small style="color: #666;">
                        💡 <strong>Важно:</strong> Все отзывы проходят модерацию перед публикацией.
                        Это помогает нам поддерживать качество и достоверность отзывов на сайте.
                    </small>
                </div>
            </form>
        </div>
    </div>

    <script>
        // JavaScript для улучшения UX звездного рейтинга
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating label');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.htmlFor.replace('star', '');
                    document.querySelector(`#star${rating}`).checked = true;
                });
            });
        });
    </script>
@endsection
