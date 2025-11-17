@extends('layouts.app')

@section('title', 'Создание тура - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/create.css') }}">
    <script src="{{ asset('js/scripts/image-preview.js') }}"></script>
@endsection

@section('content')
    <div class="form-container">
        <a href="{{ route('admin.tours') }}" class="back-link">← Назад к списку туров</a>
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
                <label class="form-label">Дедлайн бронирования *</label>
                <input type="date" name="booking_deadline" class="form-input" value="{{ old('booking_deadline') }}" required>
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
                <label class="form-label">Изображения тура (до 5 изображений) *</label>
                <input type="file" name="images[]" class="form-input file-input" multiple accept="image/*" required>
                <small class="file-hint">Выберите до 5 изображений для тура</small>
                <div class="image-preview" id="imagePreview"></div>
            </div>

            <button type="submit" class="form-submit">Создать тур</button>
        </form>
    </div>
@endsection
