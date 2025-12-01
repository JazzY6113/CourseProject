class BookingCancel {
    constructor() {
        this.cancelForms = document.querySelectorAll('.cancel-form');
        this.init();
    }

    init() {
        this.cancelForms.forEach(form => {
            this.setupCancelHandler(form);
        });
    }

    setupCancelHandler(form) {
        const button = form.querySelector('.cancel-btn');
        if (button) {
            button.addEventListener('click', () => {
                this.handleCancelClick(form);
            });
        }
    }

    async handleCancelClick(form) {
        if (!confirm('Вы уверены, что хотите отменить бронирование?')) {
            return;
        }

        const button = form.querySelector('.cancel-btn');
        const originalText = button.textContent;

        button.disabled = true;
        button.textContent = 'Отменяем...';

        try {
            const response = await this.submitCancel(form);

            if (response.success) {
                this.showSuccess(response.message);
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                throw new Error(response.message);
            }
        } catch (error) {
            this.showError(error.message);
            button.disabled = false;
            button.textContent = originalText;
        }
    }

    async submitCancel(form) {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
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

function cancelBooking(bookingId) {
    const form = document.getElementById(`cancelForm-${bookingId}`);
    if (form) {
        new BookingCancel().handleCancelClick(form);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new BookingCancel();
});
