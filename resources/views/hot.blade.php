@extends('layouts.app')

@section('title', 'Горящие туры - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/hot.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div>
            <p>ГОРЯЩИЕ ТУРЫ</p>
        </div>
        <div class="cards">
            <div class="container1">
                <div class="image-container1">
                    <p>В долину Чулышман<br>Урочищу Ак-Курум</p>
                </div>
                <p>Насладитесь красотами хвойных<br>
                    лесов и ощутите силу полноводных<br>
                    рек. Прокатитесь по самым<br>
                    живописным перевалам,<br>
                    поднявшись на высоту горных<br>
                    массивов и почувствуете дуновение<br>
                    свежего ветра и лучи солнца.<br>
                    Увидите величие гор и водопадов.</p>
                <div>
                    <p>15 ноября</p>
                    <p>47 000руб</p>
                </div>
                <a href="{{ url('/v-dolinu-chulishman-urochishu-ak-kurum') }}">СМОТРЕТЬ ТУР</a>
            </div>
            <div class="container2">
                <div class="image-container2">
                    <p>Марс на Алтае</p>
                </div>
                <p>В Кош-Агачском районе республики<br>
                    Алтай есть свой собственный Марс—<br>
                    и не один, а целых три. Необычные<br>
                    цветные горы с неофициальными<br>
                    названиями «Марс-1», «Марс-2» и<br>
                    «Марс-3» находятся в 5–7<br>
                    километрах от Чуйского тракта в<br>
                    долинах рек Кызыл-Чин и Чаган-Узу.<br>
                </p>
                <div>
                    <p>
                        19 октября
                    </p>
                    <p>50 000руб</p>
                </div>
                <a href="{{ url('/mars-na-altae') }}">СМОТРЕТЬ ТУР</a>
            </div>
            <div class="container3">
                <div class="image-container3">
                    <p>Горы Алтая</p>
                </div>
                <p>Прогуляетесь по местам силы Алтая,<br>
                    в уединении с близкими людьми или<br>
                    с самим собой. Пройдёте по мосту в<br>
                    самом глубоком месте реки Катунь,<br>
                    поднимитесь к смотровой площадке<br>
                    и посетите долину горных духов, где<br>
                    сможете услышать, как с вами<br>
                    говорит природа.<br>
                </p>
                <div>
                    <p>
                        29 декабря
                    </p>
                    <p>
                        65 000руб
                    </p>
                </div>
                <a href="{{ url('/gori-altaya') }}">СМОТРЕТЬ ТУР</a>
            </div>
        </div>
    </div>
@endsection
