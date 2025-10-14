@extends('layouts.app')

@section('title', 'Контакты - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div>
            <p>КОНТАКТЫ</p>
        </div>
        <div class="contacts">
            <div class="first-line">
                <div>
                    <img src="img/geoposition.svg" alt="geo">
                </div>
            </div>
            <div class="last-line">
                <div>
                    <p>
                        Контакты центрального офиса:<br>
                        Москва, ул. Двенцев, 12, к1Б<br>
                        Пн-Пт: 9:00 - 19:00<br>
                        Сб, Вс: Закрыто
                    </p>
                    <div>
                        <img src="img/phone.svg" alt="phone">
                        <p>+7(800)555-35-35</p>
                    </div>
                    <div>
                        <img src="img/email.svg" alt="email">
                        <p>moscow@nomadic-tour.com</p>
                    </div>
                </div>
                <div>
                    <p>
                        Контакты филлиала в Томске:<br>
                        Томск, ул. Елизаровых, 16<br>
                        Пн-Пт: 10:00 - 19:00<br>
                        Сб, Вс: Закрыто
                    </p>
                    <div>
                        <img src="img/phone.svg" alt="phone">
                        <p>+7(800)555-26-26</p>
                    </div>
                    <div>
                        <img src="img/email.svg" alt="email">
                        <p>tomsk@nomadic-tour.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
