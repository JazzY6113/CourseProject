@extends('layouts.app')

@section('title', 'Управление турами - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection

@section('content')
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Управление турами</h1>
            <div class="admin-actions">
                <a href="{{ route('admin.reviews') }}" class="admin-btn admin-btn-secondary">Модерация отзывов</a>
                <a href="{{ route('admin.bookings') }}" class="admin-btn admin-btn-secondary">Управление бронированиями</a>
                <a href="{{ route('admin.tours.create') }}" class="admin-btn admin-btn-primary">Создать тур</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($tours->count() > 0)
            <table class="admin-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Изображение</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Статус</th>
                    <th>Даты</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tours as $tour)
                    <tr>
                        <td>{{ $tour->id }}</td>
                        <td>
                            @if($tour->images->count() > 0)
                                <img src="{{ asset('storage/' . $tour->images->first()->image_path) }}"
                                     alt="{{ $tour->title }}"
                                     class="tour-image"
                                     loading="lazy" width="140" height="140">
                            @else
                                <img src="{{ asset('img/default-tour.jpg') }}"
                                     alt="No image"
                                     class="tour-image"
                                     loading="lazy">
                            @endif
                        </td>
                        <td>{{ $tour->title }}</td>
                        <td>{{ number_format($tour->base_price, 0, ',', ' ') }} руб</td>
                        <td>
                            @if($tour->is_active)
                                <span class="status-badge status-active">Активен</span>
                            @else
                                <span class="status-badge status-inactive">Неактивен</span>
                            @endif
                        </td>
                        <td>
                            @if($tour->tourDates->count() > 0)
                                {{ $tour->tourDates->count() }} дат(ы)
                            @else
                                <span class="text-muted">Нет дат</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.tours.edit', $tour->id) }}"
                                   class="action-btn action-btn-edit">
                                    Редактировать
                                </a>
                                <form action="{{ route('admin.tours.delete', $tour->id) }}"
                                      method="POST"
                                      class="delete-form"
                                      onsubmit="return confirm('Вы уверены, что хотите удалить этот тур?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-delete">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="admin-empty-state">
                <p>Пока нет созданных туров</p>
                <a href="{{ route('admin.tours.create') }}" class="admin-btn admin-btn-primary">
                    Создать первый тур
                </a>
            </div>
        @endif
    </div>
@endsection
