@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <div class="main-wrapper" style="max-width:600px;margin:auto;">
        <h2>Личный кабинет</h2>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom:20px;">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Аватар" style="width:120px;height:120px;border-radius:50%;">
                @else
                    <img src="{{ asset('img/default-avatar.png') }}" alt="Аватар" style="width:120px;height:120px;border-radius:50%;">
                @endif
            </div>

            <input type="file" name="avatar">

            <input type="text" name="first_name" value="{{ $user->first_name }}" placeholder="Имя" required>
            <input type="text" name="last_name" value="{{ $user->last_name }}" placeholder="Фамилия" required>
            <input type="text" name="patronymic" value="{{ $user->patronymic }}" placeholder="Отчество">
            <input type="email" name="email" value="{{ $user->email }}" placeholder="E-mail" required>

            <button type="submit" style="margin-top:10px;">Сохранить изменения</button>
        </form>
    </div>
@endsection
