function cancelBooking(bookingId) {
    if (!confirm('Вы уверены, что хотите отменить бронирование?')) {
        return;
    }

    const form = document.getElementById('cancelForm-' + bookingId);
    const button = form.querySelector('.cancel-btn');
    const originalText = button.textContent;

    button.disabled = true;
    button.textContent = 'Отменяем...';

    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Ошибка: ' + data.message);
                button.disabled = false;
                button.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при отмене бронирования');
            button.disabled = false;
            button.textContent = originalText;
        });
}
