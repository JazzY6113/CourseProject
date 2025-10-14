@extends('layouts.app')

@section('title', 'О нас - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/aboutus.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div>
            <p>О НАС<br>расскажут цифры</p>
        </div>
        <div class="statistics">
            <div class="statist1">
                <p>100%</p>
                <p>путешественников<br>возвращаются к нам</p>
            </div>
            <div class="statist2">
                <p>24/7</p>
                <p>осуществляем<br>поддержку наших<br>клиентов</p>
            </div>
            <div class="statist3">
                <p>БОЛЕЕ 5</p>
                <p>лет организуем туры<br>по Алтаю</p>
            </div>
        </div>
        <div class="about">
            <div class="o-nas1">
                <div>
                    <img src="img/o-nas-1.png" alt="1">
                </div>
                <p>Опытная команда<br>гид-экскурсоводов</p>
            </div>
            <div class="o-nas2">
                <div>
                    <img src="img/o-nas-2.png" alt="2">
                </div>
                <p>Только проверенные<br>маршруты</p>
            </div>
            <div class="o-nas3">
                <div>
                    <img src="img/o-nas-3.png" alt="3">
                </div>
                <p>Сочетание комфорта и<br>атмосферы в туре</p>
            </div>
        </div>
    </div>
@endsection
