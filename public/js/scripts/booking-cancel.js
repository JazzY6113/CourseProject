function cancelBooking(bookingId) {
    if (!confirm('Вы уверены, что хотите отменить бронирование?')) {
        return;
    }

    const form = document.getElementById(`cancelForm-${bookingId}`);
    const button = form.querySelector('.cancel-btn');
    const originalText = button.textContent;

    button.disabled = true;
    button.textContent = 'Отменяем...';

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
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
