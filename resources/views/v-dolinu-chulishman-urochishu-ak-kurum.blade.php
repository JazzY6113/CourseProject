@extends('layouts.app')

@section('title', 'В долину Чулышман к Урочищу Ак-Курум - Nomadic Tour')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/v-dolinu-chulishman-urochishu-ak-kurum.css') }}">
@endsection

@section('content')
    <div class="main-wrapper">
        <div>
            <p>В долину Чулышман<br>к Урочищу Ак-Курум</p>
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
                <p>В путешествии насладитесь<br>
                    красотами хвойных лесов и ощутите<br>
                    силу полноводных рек. Прокатитесь<br>
                    по самым живописным перевалам,<br>
                    поднявшись на высоту горных<br>
                    массивов. Прочувствуете величие гор<br>
                    и насадитесь каскадами водопадов.<br>
                    Понаблюдаете за безмятежностью<br>
                    озер, чистых как слеза. Прогуляетесь<br>
                    по таинственным пещерам и<br>
                    безлюдным тропам.</p>
            </div>
            <div class="price-container">
                <p>От 47000руб<br><br>До 62000руб</p>
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
