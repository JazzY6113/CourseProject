document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    const adultsSelect = document.getElementById('adults_count');
    const childrenSelect = document.getElementById('children_count');

    const adultPrice = parseFloat(bookingForm.dataset.adultPrice);
    const availableSeats = parseInt(bookingForm.dataset.availableSeats);
    const childPrice = adultPrice * 0.7;

    function updatePrice() {
        const adults = parseInt(adultsSelect.value) || 0;
        const children = parseInt(childrenSelect.value) || 0;
        const totalParticipants = adults + children;

        const adultsTotal = adults * adultPrice;
        const childrenTotal = children * childPrice;
        const total = adultsTotal + childrenTotal;

        document.getElementById('adultsPrice').textContent = adultsTotal.toLocaleString('ru-RU') + ' руб';
        document.getElementById('childrenPrice').textContent = childrenTotal.toLocaleString('ru-RU') + ' руб';
        document.getElementById('totalPrice').textContent = total.toLocaleString('ru-RU') + ' руб';

        const bookButton = document.getElementById('bookButton');
        bookButton.disabled = adults === 0 || totalParticipants > availableSeats;

        if (bookButton.disabled) {
            bookButton.textContent = totalParticipants > availableSeats ?
                'Недостаточно мест' : 'Выберите количество участников';
        } else {
            bookButton.textContent = 'Забронировать';
        }

        generateParticipantFields(adults, children);
    }

    function generateParticipantFields(adults, children) {
        const adultsFields = document.getElementById('adultsFields');
        const childrenFields = document.getElementById('childrenFields');

        adultsFields.innerHTML = '';
        childrenFields.innerHTML = '';

        for (let i = 1; i <= adults; i++) {
            adultsFields.innerHTML += `
                <div class="participant-field">
                    <h6>Взрослый ${i}</h6>
                    <div class="field-row">
                        <input type="text" name="participants[adult_${i}][first_name]"
                               placeholder="Имя" required>
                        <input type="text" name="participants[adult_${i}][last_name]"
                               placeholder="Фамилия" required>
                    </div>
                    <input type="date" name="participants[adult_${i}][birth_date]"
                           placeholder="Дата рождения">
                </div>
            `;
        }

        for (let i = 1; i <= children; i++) {
            childrenFields.innerHTML += `
                <div class="participant-field">
                    <h6>Ребенок ${i}</h6>
                    <div class="field-row">
                        <input type="text" name="participants[child_${i}][first_name]"
                               placeholder="Имя" required>
                        <input type="text" name="participants[child_${i}][last_name]"
                               placeholder="Фамилия" required>
                    </div>
                    <input type="date" name="participants[child_${i}][birth_date]"
                           placeholder="Дата рождения" required>
                </div>
            `;
        }

        const participantsInfo = document.getElementById('participantsInfo');
        participantsInfo.style.display = (adults + children) > 0 ? 'block' : 'none';
    }

    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const bookButton = document.getElementById('bookButton');
        const originalText = bookButton.textContent;

        bookButton.disabled = true;
        bookButton.textContent = 'Бронируем...';

        const participants = {};
        const adultFields = document.querySelectorAll('[name^="participants[adult_"]');
        const childFields = document.querySelectorAll('[name^="participants[child_"]');

        for (let i = 1; i <= parseInt(adultsSelect.value); i++) {
            participants[`adult_${i}`] = {
                first_name: document.querySelector(`[name="participants[adult_${i}][first_name]"]`).value,
                last_name: document.querySelector(`[name="participants[adult_${i}][last_name]"]`).value,
                birth_date: document.querySelector(`[name="participants[adult_${i}][birth_date]"]`).value || null
            };
        }

        for (let i = 1; i <= parseInt(childrenSelect.value); i++) {
            participants[`child_${i}`] = {
                first_name: document.querySelector(`[name="participants[child_${i}][first_name]"]`).value,
                last_name: document.querySelector(`[name="participants[child_${i}][last_name]"]`).value,
                birth_date: document.querySelector(`[name="participants[child_${i}][birth_date]"]`).value
            };
        }

        const formData = new FormData(bookingForm);
        formData.append('participants', JSON.stringify(participants));

        fetch(bookingForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.href = '/my-bookings';
                } else {
                    alert('Ошибка: ' + data.message);
                    bookButton.disabled = false;
                    bookButton.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при бронировании');
                bookButton.disabled = false;
                bookButton.textContent = originalText;
            });
    });

    adultsSelect.addEventListener('change', updatePrice);
    childrenSelect.addEventListener('change', updatePrice);

    updatePrice();
});
