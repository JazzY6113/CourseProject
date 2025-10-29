@extends('layouts.app')

@section('title', 'Редактирование тура - Nomadic Tour')

@section('styles')
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }

        .tour-form {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-checkbox {
            width: 20px;
            height: 20px;
        }

        .current-images {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .current-image {
            width: 100px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .image-container {
            position: relative;
            display: inline-block;
        }

        .remove-image {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
            font-size: 12px;
        }

        .form-submit {
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        .form-submit:hover {
            background: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="form-container">
        <a href="{{ route('admin.tours') }}" class="back-link">← Назад к списку туров</a>
        <h1 class="form-title">Редактирование тура: {{ $tour->title }}</h1>

        @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <ul style="margin: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data" class="tour-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Название тура *</label>
                <input type="text" name="title" class="form-input" value="{{ old('title', $tour->title) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Краткое описание *</label>
                <textarea name="short_description" class="form-textarea" required>{{ old('short_description', $tour->short_description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Полное описание *</label>
                <textarea name="full_description" class="form-textarea" rows="5" required>{{ old('full_description', $tour->full_description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Цена (руб) *</label>
                <input type="number" name="price" class="form-input" step="0.01" min="0"
                       value="{{ old('price', $tour->price) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Дедлайн бронирования *</label>
                <input type="date" name="booking_deadline" class="form-input"
                       value="{{ old('booking_deadline', $tour->booking_deadline->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Длительность (дней) *</label>
                <input type="number" name="duration_days" class="form-input" min="1"
                       value="{{ old('duration_days', $tour->duration_days) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Макс. размер группы *</label>
                <input type="number" name="max_group_size" class="form-input" min="1"
                       value="{{ old('max_group_size', $tour->max_group_size) }}" required>
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" name="is_active" class="form-checkbox"
                       value="1" {{ old('is_active', $tour->is_active) ? 'checked' : '' }}>
                <label class="form-label">Активный тур</label>
            </div>

            <div class="form-group">
                <label class="form-label">Текущие изображения</label>
                <div class="current-images">
                    @foreach($tour->images as $image)
                        <div class="image-container">
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                 alt="Tour image" class="current-image">
                        </div>
                    @endforeach
                </div>
                @if($tour->images->count() > 0)
                    <small>Старые изображения будут заменены при загрузке новых</small>
                @else
                    <small>Нет загруженных изображений</small>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label">Новые изображения (до 5 изображений)</label>
                <input type="file" name="images[]" class="form-input file-input" multiple accept="image/*">
                <small>Оставьте пустым, чтобы сохранить текущие изображения</small>
            </div>

            <button type="submit" class="form-submit">Обновить тур</button>
        </form>
    </div>
@endsection
