@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <script src="{{ asset('js/validation.js') }}"></script>
@endsection

@section('content')
    <div class="main-wrapper" style="max-width:600px;margin:auto;">
        <h2>Личный кабинет</h2>

        @if(session('success'))
            <div class="alert alert-success" style="background:#d4edda;color:#155724;padding:10px;border-radius:5px;margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" style="background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:20px;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/profile/update') }}" enctype="multipart/form-data">
            @csrf
            <fieldset>
                <div style="margin-bottom:20px;">
                    <div style="margin-bottom:15px;text-align:center;">
                        <img src="{{ $user->avatar_url }}" alt="Аватар"
                             style="width:150px;height:150px;border-radius:50%;object-fit:cover;border:3px solid #ddd;"
                             id="avatarPreview">

                        @if($user->has_custom_avatar)
                            <div style="margin-top:10px;">
                                <button type="button" onclick="document.getElementById('deleteAvatarForm').submit();"
                                        style="background:#dc3545;color:white;border:none;padding:5px 10px;border-radius:3px;cursor:pointer;font-size:12px;">
                                    Удалить аватар
                                </button>
                            </div>
                        @else
                            <div style="margin-top:10px;font-size:12px;color:#666;">
                                Стандартный аватар
                            </div>
                        @endif
                    </div>

                    <div style="margin-bottom:15px;">
                        <label for="avatar" style="display:block;margin-bottom:5px;font-weight:bold;">Загрузить новый аватар:</label>
                        <input type="file" name="avatar" id="avatar" accept="image/*" onchange="previewAvatar(this)">
                        @error('avatar')
                        <span style="color:#dc3545;font-size:14px;">{{ $message }}</span>
                        @enderror
                        <div style="font-size:12px;color:#666;margin-top:5px;">
                            Поддерживаемые форматы: JPG, PNG. Максимальный размер: 2MB
                        </div>
                    </div>
                </div>

                <div style="margin-bottom:15px;">
                    <label for="first_name" style="display:block;margin-bottom:5px;font-weight:bold;">Имя:</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}"
                           placeholder="Имя" required style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
                    @error('first_name')
                    <span style="color:#dc3545;font-size:14px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom:15px;">
                    <label for="last_name" style="display:block;margin-bottom:5px;font-weight:bold;">Фамилия:</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}"
                           placeholder="Фамилия" required style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
                    @error('last_name')
                    <span style="color:#dc3545;font-size:14px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom:15px;">
                    <label for="patronymic" style="display:block;margin-bottom:5px;font-weight:bold;">Отчество:</label>
                    <input type="text" name="patronymic" id="patronymic" value="{{ old('patronymic', $user->patronymic) }}"
                           placeholder="Отчество" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">
                    @error('patronymic')
                    <span style="color:#dc3545;font-size:14px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom:15px;">
                    <label for="email" style="display:block;margin-bottom:5px;font-weight:bold;">E-mail:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           placeholder="E-mail" required style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;" readonly>
                    @error('email')
                    <span style="color:#dc3545;font-size:14px;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" style="background:#007bff;color:white;border:none;padding:10px 20px;border-radius:4px;cursor:pointer;width:100%;">
                    Сохранить изменения
                </button>
            </fieldset>
        </form>

        <form id="deleteAvatarForm" action="{{ route('profile.avatar.delete') }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
