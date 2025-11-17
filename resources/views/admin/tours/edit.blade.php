@extends('layouts.app')

@section('title', 'Редактирование тура - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/tours/edit.css') }}">
@endsection

@section('content')
    <div class="form-container">
        <a href="{{ route('admin.tours') }}" class="back-link">← Назад к списку туров</a>
        <h1 class="form-title">Редактирование тура: {{ $tour->title }}</h1>

        @if($errors->any())
            <div class="error-container">
                <ul class="error-list">
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
                       value="1" {{ old('is_active', $tour->is_active) ? 'checked' : '' }} id="is_active">
                <label class="form-label" for="is_active">Активный тур</label>
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
                    <small class="image-hint">Старые изображения будут заменены при загрузке новых</small>
                @else
                    <small class="image-hint">Нет загруженных изображений</small>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label">Новые изображения (до 5 изображений)</label>
                <input type="file" name="images[]" class="form-input file-input" multiple accept="image/*">
                <small class="file-hint">Оставьте пустым, чтобы сохранить текущие изображения</small>
            </div>

            <button type="submit" class="form-submit">Обновить тур</button>
        </form>
    </div>
@endsection
