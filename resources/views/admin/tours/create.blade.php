@extends('layouts.app')

@section('title', 'Создание тура - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/tours/create.css') }}">
    <script src="{{ asset('js/scripts/image-preview.js') }}" defer></script>
@endsection

@section('content')
    <div class="form-container">
        <h1 class="form-title">Создание нового тура</h1>

        @if($errors->any())
            <div class="error-container">
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="tour-form">
            @csrf

            <div class="form-group">
                <label class="form-label">Название тура *</label>
                <input type="text" name="title" class="form-input" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Краткое описание *</label>
                <textarea name="short_description" class="form-textarea" required>{{ old('short_description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Полное описание *</label>
                <textarea name="full_description" class="form-textarea" rows="5" required>{{ old('full_description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Цена (руб) *</label>
                <input type="number" name="price" class="form-input" step="0.01" min="0" value="{{ old('price') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Длительность (дней) *</label>
                <input type="number" name="duration_days" class="form-input" min="1" value="{{ old('duration_days') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Макс. размер группы *</label>
                <input type="number" name="max_group_size" class="form-input" min="1" value="{{ old('max_group_size') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Мин. размер группы</label>
                <input type="number" name="min_group_size" class="form-input" min="1" value="{{ old('min_group_size', 1) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Дней до дедлайна бронирования</label>
                <input type="number" name="booking_deadline_days" class="form-input" min="1" value="{{ old('booking_deadline_days', 7) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Что включено (каждый пункт с новой строки)</label>
                <textarea name="included" class="form-textarea" rows="3" placeholder="Проживание
Питание
Трансфер">{{ old('included') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Что не включено (каждый пункт с новой строки)</label>
                <textarea name="not_included" class="form-textarea" rows="3" placeholder="Авиабилеты
Личные расходы">{{ old('not_included') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Требования к участникам (каждый пункт с новой строки)</label>
                <textarea name="requirements" class="form-textarea" rows="3" placeholder="Спортивная форма
Возраст от 18 лет">{{ old('requirements') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Изображения тура (до 5 изображений) *</label>
                <input type="file" name="images[]" class="form-input file-input" multiple accept="image/*" required>
                <small class="file-hint">Выберите до 5 изображений для тура</small>
                <div class="image-preview" id="imagePreview"></div>
            </div>

            <button type="submit" class="form-submit">Создать тур</button>
        </form>
    </div>
@endsection
