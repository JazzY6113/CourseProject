@extends('layouts.app')

@section('title', $tour->title . ' - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/tour-detail.css') }}">
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
                        @if($tour->tourDates->count() > 0)
                                {{ number_format($tour->tourDates->where('start_date', '>', now())->where('available_seats', '>', 0)->min('current_price') ?? $tour->price, 0, ',', ' ') }}
                            @else
                                {{ number_format($tour->price, 0, ',', ' ') }}
                            @endif
                    </span>
                        <span class="price-currency">руб</span>
                    </div>

                    @auth
                        <form id="bookingForm" class="booking-form">
                            @csrf
                            <input type="hidden" name="tour_date_id" id="selectedTourDateId" value="">

                            <div class="form-group">
                                <label for="guests_count">Количество гостей</label>
                                <select name="guests_count" id="guests_count" required>
                                    <option value="">Выберите количество</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ trans_choice('человек|человека|человек', $i) }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="contact_phone">Контактный телефон</label>
                                <input type="tel"
                                       name="contact_phone"
                                       id="contact_phone"
                                       value="{{ Auth::user()->phone ?? '' }}"
                                       required
                                       placeholder="+7 (XXX) XXX-XX-XX">
                            </div>

                            <div class="form-group">
                                <label for="special_requests">Особые пожелания (необязательно)</label>
                                <textarea name="special_requests"
                                          id="special_requests"
                                          rows="3"
                                          placeholder="Ваши пожелания..."></textarea>
                            </div>

                            <div class="total-price">
                                <strong>Итого: </strong>
                                <span id="totalPrice">0 руб</span>
                            </div>

                            <button type="submit" class="book-button" id="bookButton" disabled>
                                Забронировать
                            </button>
                        </form>
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
                <p>До {{ $tour->booking_deadline->format('d.m.Y') }}</p>
            </div>

            <div class="info-card">
                <h3>👥 Размер группы</h3>
                <p>До {{ $tour->max_group_size }} человек</p>
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnails = document.querySelectorAll('.thumbnail');
            const mainImage = document.getElementById('mainTourImage');

            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    const imageUrl = this.getAttribute('data-image');
                    mainImage.src = imageUrl;

                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            const dateItems = document.querySelectorAll('.date-item');
            const selectedDateInput = document.getElementById('selectedTourDateId');
            const currentPriceElement = document.getElementById('currentPrice');
            const guestsCountSelect = document.getElementById('guests_count');
            const totalPriceElement = document.getElementById('totalPrice');
            const bookButton = document.getElementById('bookButton');

            let selectedDate = null;

            dateItems.forEach(item => {
                item.addEventListener('click', function() {
                    dateItems.forEach(d => d.classList.remove('active'));
                    this.classList.add('active');

                    selectedDate = {
                        id: this.getAttribute('data-date-id'),
                        price: parseFloat(this.getAttribute('data-price')),
                        seats: parseInt(this.getAttribute('data-seats'))
                    };

                    selectedDateInput.value = selectedDate.id;

                    currentPriceElement.textContent = selectedDate.price.toLocaleString('ru-RU');

                    updateTotalPrice();

                    updateBookButton();
                });
            });

            if (dateItems.length > 0) {
                dateItems[0].click();
            }

            guestsCountSelect.addEventListener('change', function() {
                updateTotalPrice();
                updateBookButton();
            });

            function updateTotalPrice() {
                if (selectedDate && guestsCountSelect.value) {
                    const guestsCount = parseInt(guestsCountSelect.value);
                    const totalPrice = selectedDate.price * guestsCount;
                    totalPriceElement.textContent = totalPrice.toLocaleString('ru-RU') + ' руб';
                } else {
                    totalPriceElement.textContent = '0 руб';
                }
            }

            function updateBookButton() {
                if (selectedDate && guestsCountSelect.value) {
                    const guestsCount = parseInt(guestsCountSelect.value);
                    if (guestsCount <= selectedDate.seats) {
                        bookButton.disabled = false;
                        bookButton.textContent = 'Забронировать';
                    } else {
                        bookButton.disabled = true;
                        bookButton.textContent = 'Недостаточно мест';
                    }
                } else {
                    bookButton.disabled = true;
                    bookButton.textContent = 'Забронировать';
                }
            }

            const bookingForm = document.getElementById('bookingForm');
            if (bookingForm) {
                bookingForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    fetch('{{ route("bookings.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                alert('Ошибка: ' + data.message);
                            } else {
                                document.getElementById('successModal').style.display = 'block';
                                bookingForm.reset();
                                updateTotalPrice();
                                updateBookButton();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Произошла ошибка при бронировании');
                        });
                });
            }

            const modal = document.getElementById('successModal');
            const closeModal = document.getElementById('closeModal');
            const span = document.getElementsByClassName('close')[0];

            if (closeModal) {
                closeModal.onclick = function() {
                    modal.style.display = 'none';
                }
            }

            if (span) {
                span.onclick = function() {
                    modal.style.display = 'none';
                }
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>
@endsection
