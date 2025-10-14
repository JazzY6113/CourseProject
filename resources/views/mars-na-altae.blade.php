@extends('layouts.app')

@section('title', 'Марс на Алтае - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/mars-na-altae.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div>
            <p>Марс на Алтае</p>
        </div>
        <div class="cards">
            <div class="image-container">
                <div class="img">
                    <img src="img/mars-back.png" alt="mars">
                </div>
                <div>
                    <img src="img/mars1.png" alt="mars1">
                    <img src="img/mars2.png" alt="mars2">
                    <img src="img/mars3.png" alt="mars3">
                    <img src="img/mars4.png" alt="mars4">
                </div>
            </div>
            <div class="text-container">
                <p>В Кош-Агачском районе республики<br>
                    Алтай есть свой собственный Марс, и<br>
                    не один, а целых три. Необычные<br>
                    цветные горы с неофициальными<br>
                    названиями «Марс-1», «Марс-2» и<br>
                    «Марс-3» находятся в 5–7 километрах<br>
                    от Чуйского тракта в долинах рек<br>
                    Кызыл-Чин и Чаган-Узун, рядом с<br>
                    селами Ортолык и Бельтир. Холмистая <br>
                    местность радует глаз<br>
                    яркими красками теплых тонов.</p>
            </div>
            <div class="price-container">
                <p>От 42000руб<br><br>До 62000руб</p>
                <a href="">Выбрать</a>
            </div>
        </div>
        <div class="forms">
            <form>
                <div>
                    <div>
                        <input type="tel" id="tel" placeholder="Контактный телефон">
                        <input type="text" id="text" placeholder="ФИО">
                        <input type="text" id="text2" placeholder="Дата путешествия">
                        <input type="email" id="email" placeholder="Email">
                    </div>
                    <div>
                        <img src="img/form-img.png" alt="form">
                    </div>
                </div>
                <div>
                    <a href="">Отправить</a>
                    <p>Нажимая на кнопку, вы даете согласие на обработку своих персональных данных соглашаетесь <a href="">с политикой конфиденциальности.</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection
