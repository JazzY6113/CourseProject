<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подтверждение регистрации - Nomadic Tour</title>
    <link rel="stylesheet" href="{{ asset('css/emails/verify.css') }}">
</head>
<body style="font-family: Arial, sans-serif; background: #fafafa; padding: 30px;">
<div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #d9534f;">Nomadic Tour</h2>
    <p>Здравствуйте, {{ $user->first_name }}!</p>
    <p>Благодарим вас за регистрацию на <strong>Nomadic Tour</strong>.</p>
    <p>Для завершения регистрации, пожалуйста, подтвердите ваш адрес электронной почты, нажав на кнопку ниже:</p>
    <p style="text-align: center;">
        <a href="{{ $url }}" style="display: inline-block; background-color: #d9534f; color: #fff; padding: 12px 24px; border-radius: 25px; text-decoration: none; font-size: 16px;">
            Подтвердить Email
        </a>
    </p>
    <p>Если вы не регистрировались на нашем сайте, просто проигнорируйте это письмо.</p>
    <p style="color: #888; font-size: 12px; text-align: center;">© {{ date('Y') }} Nomadic Tour</p>
</div>
</body>
</html>
