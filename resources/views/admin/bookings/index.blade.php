@extends('layouts.app')

@section('title', 'Управление бронированиями - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/bookings.css') }}">
    <script src="{{ asset('js/scripts/admin-bookings.js') }}" defer></script>
@endsection

@section('content')
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Управление бронированиями</h1>
        </div>

        <div class="bookings-filters">
            <form method="GET" class="filter-form">
                <select name="status" onchange="this.form.submit()">
                    <option value="">Все статусы</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->name }}" {{ request('status') == $status->name ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if($bookings->count() > 0)
            <table class="bookings-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Тур</th>
                    <th>Пользователь</th>
                    <th>Даты</th>
                    <th>Участники</th>
                    <th>Стоимость</th>
                    <th>Статус</th>
                    <th>Дата брони</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>
                            <a href="{{ route('tour.detail', $booking->tourDate->tour->id) }}" target="_blank">
                                {{ $booking->tourDate->tour->title }}
                            </a>
                        </td>
                        <td>{{ $booking->user->email }}</td>
                        <td>
                            {{ $booking->tourDate->start_date->format('d.m.Y') }}<br>
                            {{ $booking->tourDate->end_date->format('d.m.Y') }}
                        </td>
                        <td>
                            Взрослых: {{ $booking->adults_count }}<br>
                            Детей: {{ $booking->children_count }}
                        </td>
                        <td>{{ number_format($booking->total_price, 0, ',', ' ') }} руб</td>
                        <td>
                                <span class="status status-{{ $booking->status->name }}">
                                    {{ $booking->status->name }}
                                </span>
                        </td>
                        <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn-info" onclick="showBookingDetails({{ $booking->id }})">
                                    Детали
                                </button>
                                <div class="status-actions">
                                    <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="status-form">
                                        @csrf
                                        @method('PUT')
                                        <select name="status_id" onchange="this.form.submit()">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}" {{ $booking->booking_status_id == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $bookings->links() }}
        @else
            <div class="no-bookings">
                <p>Бронирования не найдены</p>
            </div>
        @endif
    </div>

    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="bookingDetails"></div>
        </div>
    </div>
@endsection
