function showBookingDetails(bookingId) {
    fetch(`/admin/bookings/${bookingId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const modal = document.getElementById('bookingModal');
            const details = document.getElementById('bookingDetails');

            // Форматируем даты
            const startDate = new Date(data.booking.tour_date.start_date).toLocaleDateString('ru-RU');
            const endDate = new Date(data.booking.tour_date.end_date).toLocaleDateString('ru-RU');
            const createdDate = new Date(data.booking.created_at).toLocaleDateString('ru-RU');

            details.innerHTML = `
                <h3>Детали бронирования #${data.booking.id}</h3>
                <div class="booking-info">
                    <p><strong>Тур:</strong> ${data.booking.tour_date.tour.title}</p>
                    <p><strong>Пользователь:</strong> ${data.booking.user.email}</p>
                    <p><strong>Даты тура:</strong> ${startDate} - ${endDate}</p>
                    <p><strong>Участники:</strong> ${data.booking.adults_count} взрослых, ${data.booking.children_count} детей</p>
                    <p><strong>Стоимость:</strong> ${data.booking.total_price.toLocaleString('ru-RU')} руб</p>
                    <p><strong>Статус:</strong> ${data.booking.status.name}</p>
                    <p><strong>Дата бронирования:</strong> ${createdDate}</p>
                    <p><strong>Контактный телефон:</strong> ${data.booking.contact_phone}</p>
                    <p><strong>Контактный email:</strong> ${data.booking.contact_email}</p>
                    ${data.booking.special_requests ? `<p><strong>Особые пожелания:</strong> ${data.booking.special_requests}</p>` : ''}
                </div>
                <div class="participants-info">
                    <h4>Информация об участниках:</h4>
                    ${renderParticipants(data.participants)}
                </div>
            `;

            modal.style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ошибка при загрузке деталей бронирования');
        });
}

function renderParticipants(participants) {
    if (!participants || Object.keys(participants).length === 0) {
        return '<p>Нет информации об участниках</p>';
    }

    let html = '';
    for (const [key, participant] of Object.entries(participants)) {
        const birthDate = participant.birth_date ?
            new Date(participant.birth_date).toLocaleDateString('ru-RU') :
            'не указана';

        html += `
            <div class="participant-card">
                <h5>${key.replace('_', ' ').toUpperCase()}</h5>
                <p><strong>Имя:</strong> ${participant.first_name}</p>
                <p><strong>Фамилия:</strong> ${participant.last_name}</p>
                <p><strong>Дата рождения:</strong> ${birthDate}</p>
            </div>
        `;
    }
    return html;
}

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('bookingModal');
    const closeBtn = document.querySelector('.close');

    if (closeBtn) {
        closeBtn.onclick = function() {
            modal.style.display = 'none';
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
