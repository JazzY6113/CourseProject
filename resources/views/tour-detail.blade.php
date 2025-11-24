@extends('layouts.app')

@section('title', $tour->title . ' - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/tour-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}">
    <script src="{{ asset('js/scripts/avatar.js') }}"></script>
@endsection

@section('content')
    <div class="tour-detail-wrapper">
        <div class="breadcrumbs">
            <a href="{{ route('home') }}">Главная</a> >
            <a href="{{ route('tour') }}">Туры</a> >
            <span>{{ $tour->title }}</span>
        </div>

        <div class="tour-header">
            <h1 class="tour-title">{{ $tour->title }}</h1>
            <div class="tour-meta">
                <span class="duration">⏱ {{ $tour->duration_days }} дней</span>
                <span class="group-size">👥 До {{ $tour->max_group_size }} человек</span>
            </div>
        </div>

        <div class="tour-gallery">
            @if($tour->images->count() > 0)
                <div class="main-image">
                    <img src="{{ asset('storage/' . $tour->images->first()->image_path) }}"
                         alt="{{ $tour->title }}"
                         id="mainTourImage">
                </div>
                @if($tour->images->count() > 1)
                    <div class="image-thumbnails">
                        @foreach($tour->images as $image)
                            <div class="thumbnail {{ $loop->first ? 'active' : '' }}"
                                 data-image="{{ asset('storage/' . $image->image_path) }}">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     alt="{{ $tour->title }} - изображение {{ $loop->iteration }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="main-image">
                    <img src="{{ asset('img/default-tour.jpg') }}" alt="{{ $tour->title }}">
                </div>
            @endif
        </div>

        <div class="tour-content">
            <div class="tour-main-info">
                <div class="tour-description-section">
                    <h2>Описание тура</h2>
                    <div class="full-description">
                        {!! nl2br(e($tour->full_description)) !!}
                    </div>
                </div>

                <div class="tour-dates-section">
                    <h2>Доступные даты</h2>
                    @if($tour->tourDates->count() > 0)
                        <div class="dates-list">
                            @foreach($tour->tourDates->where('start_date', '>', now())->where('available_seats', '>', 0) as $date)
                                <div class="date-item {{ $loop->first ? 'active' : '' }}"
                                     data-date-id="{{ $date->id }}"
                                     data-price="{{ $date->current_price }}"
                                     data-seats="{{ $date->available_seats }}">
                                    <div class="date-info">
                                    <span class="date-range">
                                        {{ $date->start_date->format('d.m.Y') }} - {{ $date->end_date->format('d.m.Y') }}
                                    </span>
                                        <span class="seats-available">
                                        Осталось мест: {{ $date->available_seats }}
                                    </span>
                                    </div>
                                    <div class="date-price">
                                        {{ number_format($date->current_price, 0, ',', ' ') }} руб
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="no-dates">На данный момент нет доступных дат для этого тура</p>
                    @endif
                </div>
            </div>

            <div class="booking-section">
                <div class="booking-card">
                    <div class="price-info">
                        <span class="price-label">от</span>
                        <span class="price-amount" id="currentPrice">
                            @if($tour->activeTourDates->count() > 0)
                                {{ number_format($tour->activeTourDates->min('current_price'), 0, ',', ' ') }}
                            @else
                                {{ number_format($tour->base_price, 0, ',', ' ') }}
                            @endif
                        </span>
                        <span class="price-currency">руб</span>
                    </div>

                    @if($tour->activeTourDates->count() > 0)
                        <div class="available-dates">
                            <h3>Доступные даты:</h3>
                            <div class="dates-list">
                                @foreach($tour->activeTourDates as $date)
                                    <div class="date-option">
                                        <div class="date-info">
                                            <strong>{{ $date->start_date->format('d.m.Y') }} - {{ $date->end_date->format('d.m.Y') }}</strong>
                                            <span class="seats-available">Осталось мест: {{ $date->available_seats }}</span>
                                            <span class="date-price">{{ number_format($date->current_price, 0, ',', ' ') }} руб</span>
                                        </div>
                                        @auth
                                            <a href="{{ route('booking.form', $date->id) }}" class="book-date-btn">
                                                Выбрать дату
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="book-date-btn">
                                                Войти для бронирования
                                            </a>
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="no-dates-available">
                            <p>На данный момент нет доступных дат для этого тура</p>
                        </div>
                    @endif

                    @auth
                        @if($tour->activeTourDates->count() === 0)
                            <div class="auth-required">
                                <p>Следите за обновлениями - новые даты появятся скоро!</p>
                            </div>
                        @endif
                    @else
                        <div class="auth-required">
                            <p>Для бронирования тура необходимо <a href="{{ route('login') }}">войти</a> в систему</p>
                            <p>Или <a href="{{ route('register') }}">зарегистрироваться</a>, если у вас еще нет аккаунта</p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <div class="tour-additional-info">
            <div class="info-card">
                <h3>📅 Срок бронирования</h3>
                <p>За {{ $tour->booking_deadline_days }} {{ trans_choice('день|дня|дней', $tour->booking_deadline_days) }} до начала тура</p>
            </div>

            <div class="info-card">
                <h3>👥 Размер группы</h3>
                <p>От {{ $tour->min_group_size }} до {{ $tour->max_group_size }} человек</p>
            </div>

            <div class="info-card">
                <h3>⏱ Продолжительность</h3>
                <p>{{ $tour->duration_days }} {{ trans_choice('день|дня|дней', $tour->duration_days) }}</p>
            </div>
        </div>
    </div>

    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Бронирование успешно!</h2>
            <p>Ваше бронирование было успешно создано. Мы свяжемся с вами в ближайшее время для подтверждения.</p>
            <button id="closeModal">OK</button>
        </div>
    </div>
@endsection
