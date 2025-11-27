@extends('layouts.app')

@section('title', 'Оставить отзыв - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reviews-create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}">
    <script src="{{ asset('js/scripts/star-rating.js') }}"></script>
@endsection

@section('content')
    <div class="main-wrapper">
        <div class="page-header">
            <h1>ОСТАВИТЬ ОТЗЫВ</h1>
            <p>Поделитесь вашими впечатлениями о путешествии</p>
        </div>

        <div class="review-form-container">
            <form method="POST" action="{{ route('reviews.store') }}" class="review-form">
                @csrf

                <div class="form-group">
                    <label for="tour_id" class="form-label">Выберите тур *</label>
                    <select name="tour_id" id="tour_id" class="form-control" required>
                        <option value="">-- Выберите тур --</option>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}" {{ old('tour_id') == $tour->id ? 'selected' : '' }}>
                                {{ $tour->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('tour_id')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                @guest
                    <div class="form-group">
                        <label for="author_name" class="form-label">Ваше имя *</label>
                        <input type="text" name="author_name" id="author_name" class="form-control"
                               value="{{ old('author_name') }}" placeholder="Введите ваше имя" required>
                        @error('author_name')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                @else
                    <div class="form-group">
                        <label class="form-label">Ваше имя</label>
                        <div class="user-info-display">
                            <p class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                            <small class="form-hint">Будет использовано имя из вашего профиля</small>
                        </div>
                    </div>
                @endguest

                <div class="form-group">
                    <label class="form-label">Оценка *</label>
                    <div class="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                   {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label for="star{{ $i }}" title="{{ $i }} звезд">★</label>
                        @endfor
                    </div>
                    @error('rating')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="comment" class="form-label">Ваш отзыв *</label>
                    <textarea name="comment" id="comment" class="form-control" rows="6" required
                              placeholder="Поделитесь вашими впечатлениями о туре... Расскажите о качестве обслуживания, организации тура, гиде, питании и т.д.">{{ old('comment') }}</textarea>
                    <div class="char-count">
                        <span id="charCount">0</span> / 1000 символов
                    </div>
                    @error('comment')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        📨 Отправить на модерацию
                    </button>
                    <a href="{{ route('reviews') }}" class="btn-secondary">
                        ↩️ Вернуться к отзывам
                    </a>
                </div>

                <div class="form-note">
                    <small>
                        💡 <strong>Важно:</strong> Все отзывы проходят модерацию перед публикацией.
                        Это помогает нам поддерживать качество и достоверность отзывов на сайте.
                        Обычно модерация занимает до 24 часов.
                    </small>
                </div>
            </form>
        </div>
    </div>
@endsection
