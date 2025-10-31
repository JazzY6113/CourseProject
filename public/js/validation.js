// Валидация имени/фамилии (кириллица, первая заглавная)
function validateCyrillicName(name) {
    const regex = /^[А-ЯЁ][а-яё]{1,29}$/;
    return regex.test(name);
}

// Валидация отчества (может быть пустым)
function validatePatronymic(patronymic) {
    if (patronymic === '') return true;
    const regex = /^[А-ЯЁ][а-яё]{0,29}$/;
    return regex.test(patronymic);
}

// Валидация email
function validateEmail(email) {
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return regex.test(email);
}

// Валидация пароля
function validatePassword(password) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
    return regex.test(password);
}

// Показ ошибок
function showError(field, message) {
    let errorElement = field.nextElementSibling;
    if (!errorElement || !errorElement.classList.contains('error-message')) {
        errorElement = document.createElement('span');
        errorElement.className = 'error-message';
        errorElement.style.cssText = 'color: red; font-size: 12px; display: block; margin-top: 5px;';
        field.parentNode.insertBefore(errorElement, field.nextSibling);
    }
    errorElement.textContent = message;
    field.style.borderColor = 'red';
}

// Скрытие ошибок
function hideError(field) {
    const errorElement = field.nextElementSibling;
    if (errorElement && errorElement.classList.contains('error-message')) {
        errorElement.remove();
    }
    field.style.borderColor = '';
}

// Валидация поля в реальном времени
function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let message = '';

    switch(field.name) {
        case 'first_name':
        case 'last_name':
            if (!validateCyrillicName(value)) {
                isValid = false;
                message = 'Должно содержать только кириллические символы, начинаться с заглавной буквы (2-30 символов)';
            }
            break;
        case 'patronymic':
            if (!validatePatronymic(value)) {
                isValid = false;
                message = 'Должно содержать только кириллические символы и начинаться с заглавной буквы';
            }
            break;
        case 'email':
            if (!validateEmail(value)) {
                isValid = false;
                message = 'Введите корректный email адрес';
            }
            break;
        case 'password':
            if (document.querySelector('form').action.includes('register') && !validatePassword(value)) {
                isValid = false;
                message = 'Пароль должен содержать минимум 8 символов, включая заглавные и строчные буквы, а также цифры';
            }
            break;
    }

    if (!isValid && value !== '') {
        showError(field, message);
    } else {
        hideError(field);
    }

    return isValid;
}

// Инициализация валидации
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');

        // Валидация при уходе с поля
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });

            // Очистка ошибки при вводе
            input.addEventListener('input', function() {
                hideError(this);
            });
        });

        // Валидация перед отправкой
        form.addEventListener('submit', function(e) {
            let isFormValid = true;

            inputs.forEach(input => {
                if (!validateField(input)) {
                    isFormValid = false;
                }
            });

            if (!isFormValid) {
                e.preventDefault();
                alert('Пожалуйста, исправьте ошибки в форме.');
            }
        });
    });
});
