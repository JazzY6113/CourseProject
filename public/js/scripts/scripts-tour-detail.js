document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('mainTourImage');

    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function() {
            const imageUrl = this.getAttribute('data-image');
            mainImage.src = imageUrl;

            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    const dateItems = document.querySelectorAll('.date-item');
    const selectedDateInput = document.getElementById('selectedTourDateId');
    const currentPriceElement = document.getElementById('currentPrice');
    const guestsCountSelect = document.getElementById('guests_count');
    const totalPriceElement = document.getElementById('totalPrice');
    const bookButton = document.getElementById('bookButton');
    const bookingForm = document.getElementById('bookingForm');

    let selectedDate = null;

    dateItems.forEach(item => {
        item.addEventListener('click', function() {
            dateItems.forEach(d => d.classList.remove('active'));
            this.classList.add('active');

            selectedDate = {
                id: this.getAttribute('data-date-id'),
                price: parseFloat(this.getAttribute('data-price')),
                seats: parseInt(this.getAttribute('data-seats'))
            };

            selectedDateInput.value = selectedDate.id;
            currentPriceElement.textContent = selectedDate.price.toLocaleString('ru-RU');
            updateTotalPrice();
            updateBookButton();
        });
    });

    if (dateItems.length > 0) {
        dateItems[0].click();
    }

    guestsCountSelect.addEventListener('change', function() {
        updateTotalPrice();
        updateBookButton();
    });

    function updateTotalPrice() {
        if (selectedDate && guestsCountSelect.value) {
            const guestsCount = parseInt(guestsCountSelect.value);
            const totalPrice = selectedDate.price * guestsCount;
            totalPriceElement.textContent = totalPrice.toLocaleString('ru-RU') + ' руб';
        } else {
            totalPriceElement.textContent = '0 руб';
        }
    }

    function updateBookButton() {
        if (selectedDate && guestsCountSelect.value) {
            const guestsCount = parseInt(guestsCountSelect.value);
            if (guestsCount <= selectedDate.seats && guestsCount > 0) {
                bookButton.disabled = false;
                bookButton.textContent = 'Забронировать';
            } else {
                bookButton.disabled = true;
                bookButton.textContent = 'Недостаточно мест';
            }
        } else {
            bookButton.disabled = true;
            bookButton.textContent = 'Забронировать';
        }
    }

    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!selectedDate) {
                alert('Пожалуйста, выберите дату тура');
                return;
            }

            bookButton.disabled = true;
            bookButton.textContent = 'Бронируем...';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Ошибка сервера');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('successModal').style.display = 'block';
                    bookingForm.reset();
                    updateTotalPrice();

                    const selectedDateElement = document.querySelector('.date-item.active');
                    if (selectedDateElement) {
                        const newSeats = selectedDate.seats - parseInt(guestsCountSelect.value);
                        selectedDateElement.setAttribute('data-seats', newSeats);
                        selectedDateElement.querySelector('.seats-available').textContent =
                            'Осталось мест: ' + newSeats;
                        selectedDate.seats = newSeats;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка: ' + error.message);
                })
                .finally(() => {
                    updateBookButton();
                });
        });
    }

    const modal = document.getElementById('successModal');
    const closeModal = document.getElementById('closeModal');
    const span = document.getElementsByClassName('close')[0];

    if (closeModal) {
        closeModal.onclick = function() {
            modal.style.display = 'none';
        }
    }

    if (span) {
        span.onclick = function() {
            modal.style.display = 'none';
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
