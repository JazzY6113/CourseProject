class FormValidator {
    constructor() {
        this.patterns = {
            cyrillic: /^[А-ЯЁ][а-яё]{1,29}$/,
            email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
            phone: /^\+7\s?\(?\d{3}\)?\s?\d{3}[\s-]?\d{2}[\s-]?\d{2}$/
        };

        this.messages = {
            cyrillic: 'Только кириллица, первая заглавная (2-30 символов)',
            email: 'Введите корректный email адрес',
            phone: 'Введите телефон в формате +7 (XXX) XXX-XX-XX',
            required: 'Это поле обязательно для заполнения'
        };
    }

    init() {
        this.setupFormValidation();
    }

    setupFormValidation() {
        const forms = document.querySelectorAll('form[data-validate]');

        forms.forEach(form => {
            this.setupRealTimeValidation(form);
            this.setupSubmitValidation(form);
        });
    }

    setupRealTimeValidation(form) {
        const inputs = form.querySelectorAll('input[data-validate], textarea[data-validate]');

        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearError(input));
        });
    }

    setupSubmitValidation(form) {
        form.addEventListener('submit', (e) => {
            if (!this.validateForm(form)) {
                e.preventDefault();
                this.showFormError(form, 'Пожалуйста, исправьте ошибки в форме.');
            }
        });
    }

    validateForm(form) {
        const inputs = form.querySelectorAll('input[data-validate], textarea[data-validate]');
        let isValid = true;

        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        const validations = field.dataset.validate.split(' ');
        let isValid = true;

        this.clearError(field);

        for (const validation of validations) {
            switch (validation) {
                case 'required':
                    if (!value) {
                        this.showError(field, this.messages.required);
                        isValid = false;
                    }
                    break;

                case 'cyrillic':
                    if (value && !this.patterns.cyrillic.test(value)) {
                        this.showError(field, this.messages.cyrillic);
                        isValid = false;
                    }
                    break;

                case 'email':
                    if (value && !this.patterns.email.test(value)) {
                        this.showError(field, this.messages.email);
                        isValid = false;
                    }
                    break;

                case 'phone':
                    if (value && !this.patterns.phone.test(value)) {
                        this.showError(field, this.messages.phone);
                        isValid = false;
                    }
                    break;
            }

            if (!isValid) break;
        }

        if (isValid) {
            this.showSuccess(field);
        }

        return isValid;
    }

    showError(field, message) {
        this.clearError(field);

        const errorElement = document.createElement('span');
        errorElement.className = 'error-message';
        errorElement.textContent = message;

        field.classList.add('error');
        field.parentNode.appendChild(errorElement);

        field.focus({ preventScroll: true });
    }

    showSuccess(field) {
        field.classList.remove('error');
        field.classList.add('success');
    }

    clearError(field) {
        field.classList.remove('error', 'success');

        const errorElement = field.parentNode.querySelector('.error-message');
        if (errorElement) {
            errorElement.remove();
        }
    }

    showFormError(form, message) {
        const existingAlert = form.querySelector('.form-alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alert = document.createElement('div');
        alert.className = 'form-alert error-message';
        alert.style.cssText = `
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        `;
        alert.textContent = message;

        form.insertBefore(alert, form.firstChild);

        setTimeout(() => alert.remove(), 5000);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new FormValidator().init();
});
