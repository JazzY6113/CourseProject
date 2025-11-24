@extends('layouts.app')

@section('title', 'Мои бронирования - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/booking-list.css') }}">
    <script src="{{ asset('js/scripts/booking-cancel.js') }}"></script>
@endsection

@section('content')
    <div class="bookings-container">
        <h1 class="bookings-title">Мои бронирования</h1>

        @if($bookings->count() > 0)
            <div class="bookings-list">
                @foreach($bookings as $booking)
                    <div class="booking-card">
                        <div class="booking-header">
                            <h3>{{ $booking->tourDate->tour->title }}</h3>
                            <span class="booking-status status-{{ $booking->status->name }}">
                                {{ $booking->status->name }}
                            </span>
                        </div>
                        <div class="booking-details">
                            <p><strong>Даты:</strong> {{ $booking->tourDate->start_date->format('d.m.Y') }} - {{ $booking->tourDate->end_date->format('d.m.Y') }}</p>
                            <p><strong>Участники:</strong> {{ $booking->adults_count }} взрослых, {{ $booking->children_count }} детей</p>
                            <p><strong>Стоимость:</strong> {{ number_format($booking->total_price, 0, ',', ' ') }} руб</p>
                            <p><strong>Статус оплаты:</strong> {{ $booking->is_paid ? 'Оплачено' : 'Не оплачено' }}</p>
                            <p><strong>Дата бронирования:</strong> {{ $booking->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="booking-actions">
                            @if($booking->canBeCancelled())
                                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="cancel-form" id="cancelForm-{{ $booking->id }}">
                                    @csrf
                                    @method('POST')
                                    <button type="button" class="cancel-btn" onclick="cancelBooking({{ $booking->id }})">
                                        Отменить бронь
                                    </button>
                                </form>
                            @else
                                <span class="cancel-disabled">
                                    Отмена невозможна
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $bookings->links() }}
        @else
            <div class="no-bookings">
                <p>У вас пока нет бронирований</p>
                <a href="{{ route('tour') }}" class="btn-primary">Найти тур</a>
            </div>
        @endif
    </div>
@endsection
