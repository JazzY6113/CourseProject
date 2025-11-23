@extends('layouts.app')

@section('title', 'Оставить отзыв - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reviews-create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}">
    <script src="{{ asset('js/scripts/star-rating.js') }}"></script>
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
                    <span>{{ $message }}</span>
                    @enderror
                </div>

                @guest
                    <div class="form-group">
                        <label for="author_name">Ваше имя:</label>
                        <input type="text" name="author_name" id="author_name" class="form-control"
                               value="{{ old('author_name') }}" placeholder="Введите ваше имя" required>
                        @error('author_name')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>
                @else
                    <div class="form-group">
                        <label>Ваше имя:</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" disabled>
                        <small>Будет использовано имя из вашего профиля</small>
                    </div>
                @endguest

                <div class="form-group">
                    <label>Рейтинг</label>
                    <div class="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                            <label for="star{{ $i }}">★</label>
                        @endfor
                    </div>
                    @error('rating')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="comment">Ваш отзыв:</label>
                    <textarea name="comment" id="comment" class="form-control" required
                              placeholder="Поделитесь вашими впечатлениями о туре...">{{ old('comment') }}</textarea>
                    @error('comment')
                    <span>{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-primary">
                    Отправить на модерацию
                </button>

                <div class="form-note">
                    <small>
                        💡 <strong>Важно:</strong> Все отзывы проходят модерацию перед публикацией.
                        Это помогает нам поддерживать качество и достоверность отзывов на сайте.
                    </small>
                </div>
            </form>
        </div>
    </div>
@endsection
