<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Подтверждение бронирования</title>
    <link rel="stylesheet" href="{{ asset('css/emails/booking-confirmation.css') }}">
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Nomadic Tour</h1>
        <h2>Подтверждение бронирования</h2>
    </div>

    <div class="content">
        <p>Уважаемый(ая) {{ $booking->user->first_name }} {{ $booking->user->last_name }},</p>

        <p>Ваше бронирование успешно создано! Вот детали:</p>

        <div class="booking-details">
            <div class="detail-item">
                <strong>Номер брони:</strong> {{ $booking->booking_number }}
            </div>
            <div class="detail-item">
                <strong>Тур:</strong> {{ $booking->tourDate->tour->title }}
            </div>
            <div class="detail-item">
                <strong>Даты:</strong> {{ $booking->tourDate->start_date->format('d.m.Y') }} - {{ $booking->tourDate->end_date->format('d.m.Y') }}
            </div>
            <div class="detail-item">
                <strong>Участники:</strong> {{ $booking->adults_count }} взрослых, {{ $booking->children_count }} детей
            </div>
            <div class="detail-item">
                <strong>Общая стоимость:</strong> {{ number_format($booking->total_price, 0, ',', ' ') }} руб
            </div>
            <div class="detail-item">
                <strong>Статус:</strong> Ожидание подтверждения
            </div>
        </div>

        <p>Мы свяжемся с вами в ближайшее время для подтверждения бронирования.</p>

        <p>С уважением,<br>Команда Nomadic Tour</p>
    </div>

    <div class="footer">
        <p>© 2025 Nomadic Tour. Все права защищены.</p>
    </div>
</div>
</body>
</html>
