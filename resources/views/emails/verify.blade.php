<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подтверждение регистрации - Nomadic Tour</title>
    <link rel="stylesheet" href="{{ asset('css/emails/verify.css') }}">
</head>
<body class="email-body">
    <div class="email-container">
        <h2 class="email-title">Nomadic Tour</h2>
        <p class="email-greeting">Здравствуйте, {{ $user->first_name }}!</p>
        <p class="email-text">Благодарим вас за регистрацию на <strong>Nomadic Tour</strong>.</p>
        <p class="email-text">Для завершения регистрации, пожалуйста, подтвердите ваш адрес электронной почты, нажав на кнопку ниже:</p>
        <p class="button-container">
            <a href="{{ $url }}" class="verify-button">
                Подтвердить Email
            </a>
        </p>
        <p class="email-text">Если вы не регистрировались на нашем сайте, просто проигнорируйте это письмо.</p>
        <p class="email-footer">© {{ date('Y') }} Nomadic Tour</p>
    </div>
</body>
</html>
