class BookingForm {
    constructor() {
        this.form = document.getElementById('bookingForm');
        this.adultsSelect = document.getElementById('adults_count');
        this.childrenSelect = document.getElementById('children_count');
        this.bookButton = document.getElementById('bookButton');

        if (this.form) {
            this.init();
        }
    }

    init() {
        this.adultPrice = parseFloat(this.form.dataset.adultPrice);
        this.availableSeats = parseInt(this.form.dataset.availableSeats);
        this.childPrice = this.adultPrice * 0.7;

        this.setupEventListeners();
        this.updatePrice();
    }

    setupEventListeners() {
        this.adultsSelect.addEventListener('change', () => this.updatePrice());
        this.childrenSelect.addEventListener('change', () => this.updatePrice());
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    updatePrice() {
        const adults = parseInt(this.adultsSelect.value) || 0;
        const children = parseInt(this.childrenSelect.value) || 0;
        const totalParticipants = adults + children;

        const adultsTotal = adults * this.adultPrice;
        const childrenTotal = children * this.childPrice;
        const total = adultsTotal + childrenTotal;

        this.updatePriceDisplay(adultsTotal, childrenTotal, total);

        this.updateButtonState(adults, totalParticipants);

        this.generateParticipantFields(adults, children);
    }

    updatePriceDisplay(adultsTotal, childrenTotal, total) {
        const formatPrice = (price) => price.toLocaleString('ru-RU') + ' руб';

        document.getElementById('adultsPrice').textContent = formatPrice(adultsTotal);
        document.getElementById('childrenPrice').textContent = formatPrice(childrenTotal);
        document.getElementById('totalPrice').textContent = formatPrice(total);
    }

    updateButtonState(adults, totalParticipants) {
        const isDisabled = adults === 0 || totalParticipants > this.availableSeats;

        this.bookButton.disabled = isDisabled;

        if (isDisabled) {
            this.bookButton.textContent = totalParticipants > this.availableSeats
                ? 'Недостаточно мест'
                : 'Выберите количество участников';
        } else {
            this.bookButton.textContent = 'Забронировать';
        }
    }

    generateParticipantFields(adults, children) {
        const adultsFields = document.getElementById('adultsFields');
        const childrenFields = document.getElementById('childrenFields');
        const participantsInfo = document.getElementById('participantsInfo');

        adultsFields.innerHTML = this.generateAdultFields(adults);
        childrenFields.innerHTML = this.generateChildrenFields(children);

        participantsInfo.style.display = (adults + children) > 0 ? 'block' : 'none';
    }

    generateAdultFields(count) {
        let html = '';
        for (let i = 1; i <= count; i++) {
            html += `
                <div class="participant-field">
                    <h6>Взрослый ${i}</h6>
                    <div class="field-row">
                        <input type="text" name="participants[adult_${i}][first_name]"
                               placeholder="Имя" required
                               data-validate="cyrillic">
                        <input type="text" name="participants[adult_${i}][last_name]"
                               placeholder="Фамилия" required
                               data-validate="cyrillic">
                    </div>
                    <input type="date" name="participants[adult_${i}][birth_date]"
                           placeholder="Дата рождения" class="form-input">
                </div>
            `;
        }
        return html;
    }

    generateChildrenFields(count) {
        let html = '';
        for (let i = 1; i <= count; i++) {
            html += `
                <div class="participant-field">
                    <h6>Ребенок ${i}</h6>
                    <div class="field-row">
                        <input type="text" name="participants[child_${i}][first_name]"
                               placeholder="Имя" required
                               data-validate="cyrillic">
                        <input type="text" name="participants[child_${i}][last_name]"
                               placeholder="Фамилия" required
                               data-validate="cyrillic">
                    </div>
                    <input type="date" name="participants[child_${i}][birth_date]"
                           placeholder="Дата рождения" required class="form-input">
                </div>
            `;
        }
        return html;
    }

    async handleSubmit(e) {
        e.preventDefault();

        const originalText = this.bookButton.textContent;

        this.bookButton.disabled = true;
        this.bookButton.textContent = 'Бронируем...';

        try {
            const formData = this.prepareFormData();
            const response = await this.submitBooking(formData);

            if (response.success) {
                this.showSuccess(response.message);
                setTimeout(() => {
                    window.location.href = '/my-bookings';
                }, 2000);
            } else {
                throw new Error(response.message);
            }
        } catch (error) {
            this.showError(error.message);
            this.bookButton.disabled = false;
            this.bookButton.textContent = originalText;
        }
    }

    prepareFormData() {
        const formData = new FormData(this.form);
        const participants = this.collectParticipantsData();

        formData.append('participants', JSON.stringify(participants));
        return formData;
    }

    collectParticipantsData() {
        const participants = {};
        const adults = parseInt(this.adultsSelect.value);
        const children = parseInt(this.childrenSelect.value);

        for (let i = 1; i <= adults; i++) {
            participants[`adult_${i}`] = {
                first_name: document.querySelector(`[name="participants[adult_${i}][first_name]"]`).value,
                last_name: document.querySelector(`[name="participants[adult_${i}][last_name]"]`).value,
                birth_date: document.querySelector(`[name="participants[adult_${i}][birth_date]"]`).value || null
            };
        }

        for (let i = 1; i <= children; i++) {
            participants[`child_${i}`] = {
                first_name: document.querySelector(`[name="participants[child_${i}][first_name]"]`).value,
                last_name: document.querySelector(`[name="participants[child_${i}][last_name]"]`).value,
                birth_date: document.querySelector(`[name="participants[child_${i}][birth_date]"]`).value
            };
        }

        return participants;
    }

    async submitBooking(formData) {
        const response = await fetch(this.form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if (!response.ok) {
            throw new Error('Ошибка сети');
        }

        return await response.json();
    }

    showSuccess(message) {
        this.showNotification(message, 'success');
    }

    showError(message) {
        this.showNotification(message, 'error');
    }

    showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-family: "Montserrat-Medium", sans-serif;
            z-index: 10000;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;

        notification.style.background = type === 'success'
            ? 'linear-gradient(135deg, #28a745, #20c997)'
            : 'linear-gradient(135deg, #dc3545, #c82333)';

        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new BookingForm();
});
