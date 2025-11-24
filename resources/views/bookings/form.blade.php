@extends('layouts.app')

@section('title', 'Бронирование тура - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}">
    <script src="{{ asset('js/scripts/booking-form.js') }}"></script>
@endsection

@section('content')
    <div class="booking-container">
        <div class="breadcrumbs">
            <a href="{{ route('home') }}">Главная</a> >
            <a href="{{ route('tour') }}">Туры</a> >
            <a href="{{ route('tour.detail', $tourDate->tour->id) }}">{{ $tourDate->tour->title }}</a> >
            <span>Бронирование</span>
        </div>

        <h1 class="booking-title">Бронирование тура: {{ $tourDate->tour->title }}</h1>

        <div class="booking-content">
            <div class="tour-info">
                <div class="tour-card">
                    <h3>Информация о туре</h3>
                    <div class="tour-dates">
                        <strong>Даты:</strong> {{ $tourDate->start_date->format('d.m.Y') }} - {{ $tourDate->end_date->format('d.m.Y') }}
                    </div>
                    <div class="tour-duration">
                        <strong>Продолжительность:</strong> {{ $tourDate->tour->duration_days }} дней
                    </div>
                    <div class="tour-price">
                        <strong>Цена за взрослого:</strong> {{ number_format($tourDate->current_price, 0, ',', ' ') }} руб
                    </div>
                    <div class="child-price">
                        <strong>Цена за ребенка:</strong> {{ number_format($tourDate->current_price * 0.7, 0, ',', ' ') }} руб
                    </div>
                    <div class="available-seats">
                        <strong>Доступно мест:</strong> {{ $tourDate->available_seats }}
                    </div>
                    @if($tourDate->is_guaranteed)
                        <div class="guaranteed-badge">
                            ✅ Гарантированный departure
                        </div>
                    @endif
                </div>

                @if($tourDate->tour->images->count() > 0)
                    <div class="tour-image">
                        <img src="{{ asset('storage/' . $tourDate->tour->images->first()->image_path) }}"
                             alt="{{ $tourDate->tour->title }}" class="tour-main-image">
                    </div>
                @endif
            </div>

            <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" class="booking-form"
                  data-adult-price="{{ $tourDate->current_price }}"
                  data-available-seats="{{ $tourDate->available_seats }}">
                @csrf
                <input type="hidden" name="tour_date_id" value="{{ $tourDate->id }}">

                <div class="form-section">
                    <h3>Информация о участниках</h3>

                    <div class="participants-count">
                        <div class="form-group">
                            <label for="adults_count">Количество взрослых *</label>
                            <select name="adults_count" id="adults_count" required>
                                <option value="">Выберите количество</option>
                                @for($i = 1; $i <= min(10, $tourDate->available_seats); $i++)
                                    <option value="{{ $i }}">{{ $i }} взрослых</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="children_count">Количество детей</label>
                            <select name="children_count" id="children_count">
                                <option value="0">0 детей</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} детей</option>
                                @endfor
                            </select>
                            <small class="form-hint">Дети до 12 лет - скидка 30%</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Что не включено (каждый пункт с новой строки)</label>
                        <textarea name="not_included" class="form-textarea" rows="3">@if($tourDate->tour->not_included){{ implode("\n", json_decode($tourDate->tour->not_included, true)) }}@endif</textarea>
                    </div>

                    <div class="participants-info" id="participantsInfo">
                        <h4>Информация об участниках</h4>
                        <div class="participant-fields">
                            <div class="participant-group">
                                <h5>Взрослые участники</h5>
                                <div id="adultsFields"></div>
                            </div>
                            <div class="participant-group">
                                <h5>Дети</h5>
                                <div id="childrenFields"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Контактная информация</h3>

                    <div class="form-group">
                        <label for="contact_phone">Контактный телефон *</label>
                        <input type="tel" name="contact_phone" id="contact_phone"
                               value="{{ Auth::user()->phone ?? '' }}"
                               placeholder="+7 (999) 999-99-99" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_email">E-mail *</label>
                        <input type="email" name="contact_email" id="contact_email"
                               value="{{ Auth::user()->email }}"
                               placeholder="your@email.com" required readonly>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Дополнительная информация</h3>

                    <div class="form-group">
                        <label for="special_requests">Особые пожелания</label>
                        <textarea name="special_requests" id="special_requests"
                                  rows="4"
                                  placeholder="Ваши пожелания, диетические ограничения, аллергии и т.д."></textarea>
                    </div>
                </div>

                <div class="price-summary">
                    <h3>Стоимость</h3>
                    <div class="price-breakdown">
                        <div class="price-row">
                            <span>Взрослые:</span>
                            <span id="adultsPrice">0 руб</span>
                        </div>
                        <div class="price-row">
                            <span>Дети:</span>
                            <span id="childrenPrice">0 руб</span>
                        </div>
                        <div class="price-row total">
                            <strong>Итого:</strong>
                            <strong id="totalPrice">0 руб</strong>
                        </div>
                    </div>
                </div>

                <div class="booking-actions">
                    <button type="submit" class="book-button" id="bookButton">
                        Забронировать
                    </button>
                    <a href="{{ route('tour.detail', $tourDate->tour->id) }}" class="cancel-button">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
