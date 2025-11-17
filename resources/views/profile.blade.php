@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <script src="{{ asset('js/validation.js') }}"></script>
    <script src="{{ asset('js/scripts/avatar.js') }}"></script>
@endsection

@section('content')
    <div class="main-wrapper profile-container">
        <h2 class="profile-title">Личный кабинет</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/profile/update') }}" enctype="multipart/form-data" class="profile-form">
            @csrf
            <fieldset class="form-fieldset">
                <div class="avatar-section">
                    <div class="avatar-container">
                        <img src="{{ $user->avatar_url }}" alt="Аватар" class="avatar-image" id="avatarPreview">

                        @if($user->has_custom_avatar)
                            <div class="avatar-actions">
                                <button type="button" onclick="document.getElementById('deleteAvatarForm').submit();" class="delete-avatar-btn">
                                    Удалить аватар
                                </button>
                            </div>
                        @else
                            <div class="default-avatar-label">
                                Стандартный аватар
                            </div>
                        @endif
                    </div>

                    <div class="avatar-upload">
                        <label for="avatar" class="upload-label">Загрузить новый аватар:</label>
                        <input type="file" name="avatar" id="avatar" accept="image/*" onchange="previewAvatar(this)" class="file-input">
                        @error('avatar')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                        <div class="upload-hint">
                            Поддерживаемые форматы: JPG, PNG. Максимальный размер: 2MB
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="first_name" class="form-label">Имя:</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}"
                           placeholder="Имя" required class="form-input">
                    @error('first_name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label">Фамилия:</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}"
                           placeholder="Фамилия" required class="form-input">
                    @error('last_name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="patronymic" class="form-label">Отчество:</label>
                    <input type="text" name="patronymic" id="patronymic" value="{{ old('patronymic', $user->patronymic) }}"
                           placeholder="Отчество" class="form-input">
                    @error('patronymic')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           placeholder="E-mail" required class="form-input readonly-input" readonly>
                    @error('email')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-button">
                    Сохранить изменения
                </button>
            </fieldset>
        </form>

        <form id="deleteAvatarForm" action="{{ route('profile.avatar.delete') }}" method="POST" class="hidden-form">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
