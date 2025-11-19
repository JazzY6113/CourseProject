<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CyrillicName implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[А-ЯЁ][а-яё]{1,29}$/u', $value)) {
            $fail('Поле :attribute должно содержать только кириллические символы, начинаться с заглавной буквы и быть от 2 до 30 символов.');
        }
    }
}
