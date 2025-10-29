@extends('layouts.app')

@section('title', 'Управление турами - Nomadic Tour')

@section('styles')
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 30px;
        }

        .admin-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .create-btn {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .create-btn:hover {
            background: #0056b3;
        }

        .tours-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .tours-table th,
        .tours-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .tours-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .tour-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .status-active {
            color: #28a745;
            font-weight: 600;
        }

        .status-inactive {
            color: #dc3545;
            font-weight: 600;
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        .edit-btn {
            background: #ffc107;
            color: #212529;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .delete-form {
            display: inline;
        }

        .no-tours {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
@endsection

@section('content')
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Управление турами</h1>
            <a href="{{ route('admin.tours.create') }}" class="create-btn">+ Создать тур</a>
        </div>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($tours->count() > 0)
            <table class="tours-table">
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
                                     alt="{{ $tour->title }}" class="tour-image">
                            @else
                                <img src="{{ asset('img/default-tour.jpg') }}"
                                     alt="No image" class="tour-image">
                            @endif
                        </td>
                        <td>{{ $tour->title }}</td>
                        <td>{{ number_format($tour->price, 0, ',', ' ') }} руб</td>
                        <td>
                            @if($tour->is_active)
                                <span class="status-active">Активен</span>
                            @else
                                <span class="status-inactive">Неактивен</span>
                            @endif
                        </td>
                        <td>
                            @if($tour->tourDates->count() > 0)
                                {{ $tour->tourDates->count() }} дат
                            @else
                                Нет дат
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.tours.edit', $tour->id) }}" class="edit-btn">Редактировать</a>
                                <form action="{{ route('admin.tours.delete', $tour->id) }}" method="POST" class="delete-form"
                                      onsubmit="return confirm('Вы уверены, что хотите удалить этот тур?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="no-tours">
                <p>Пока нет созданных туров</p>
                <a href="{{ route('admin.tours.create') }}" class="create-btn">Создать первый тур</a>
            </div>
        @endif
    </div>
@endsection
