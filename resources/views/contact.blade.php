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
                <div style="position:relative;overflow:hidden;">
                    <a href="https://yandex.ru/maps/67/tomsk/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Томск</a>
                    <a href="https://yandex.ru/maps/67/tomsk/house/ulitsa_yelizarovykh_18/bE0Yfw9iTUYGQFtsfXh0eH1mYA==/?ll=84.982441%2C56.459021&utm_medium=mapframe&utm_source=maps&z=20.47" style="color:#eee;font-size:12px;position:absolute;top:14px;">Улица Елизаровых, 18 — Яндекс Карты</a>
                    <iframe src="https://yandex.ru/map-widget/v1/?ll=84.982441%2C56.459021&mode=whatshere&whatshere%5Bpoint%5D=84.982297%2C56.459117&whatshere%5Bzoom%5D=17&z=20.47" width="700" height="500" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
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
                        Томск, ул. Елизаровых, 18<br>
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
