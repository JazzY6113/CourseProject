@extends('layouts.app')

@section('title', 'Горы Алтая - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/gori-altaya.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div>
            <p>Горы Алтая</p>
        </div>
        <div class="cards">
            <div class="image-container">
                <div class="img">
                    <img src="img/mars-back.png" alt="mars">
                </div>
                <div>
                    <img src="img/vdchkuak1.png" alt="vdchkuak1">
                    <img src="img/vdchkuak2.png" alt="vdchkuak2">
                    <img src="img/vdchkuak3.png" alt="vdchkuak3">
                    <img src="img/vdchkuak4.png" alt="vdchkuak4">
                </div>
            </div>
            <div class="text-container">
                <p>Путешествие к местам вдали от суеты<br>
                    и волнений. Мы создали это<br>
                    путешествие для тех, кто любит<br>
                    природу, неспешные прогулки без<br>
                    лишней беготни и толп туристов.<br>
                    Прогуляетесь по местам силы Алтая, в<br>
                    уединении с близкими людьми или с<br>
                    самим собой. Пройдете по горным<br>
                    безлюдным тропам, увидите<br>
                    водопады долины и горные массивы<br>
                    со снежными вершинами. Пройдёте<br>
                    по мосту на самом глубоком месте<br>
                    реки Катунь, поднимитесь к<br>
                    смотровой и посетите долину горных<br>
                    духов, где можно услышать как с вами<br>
                    говорит природа.</p>
            </div>
            <div class="price-container">
                <p>От 60000руб<br><br>До 70000руб</p>
                <a href="">Выбрать</a>
            </div>
        </div>
        <div class="forms">
            <form>
                <div>
                    <div>
                        <input type="tel" name="" id="tel" placeholder="Контактный телефон">
                        <input type="text" name="" id="text" placeholder="ФИО">
                        <input type="text" name="" id="text2" placeholder="Дата путешествия">
                        <input type="email" name="" id="email" placeholder="Email">
                    </div>
                    <div>
                        <img src="img/form-img.png" alt="form">
                    </div>
                </div>
                <div>
                    <a href="">Отправить</a>
                    <p>Нажимая на кнопку, вы даете согласие на обработку своих персональных данных <br>
                        соглашаетесь <a href="">с политикой конфиденциальности.</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection
