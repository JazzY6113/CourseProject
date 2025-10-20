<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    // Форма запроса сброса пароля
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Отправка письма со ссылкой
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Ссылка для сброса пароля отправлена на почту!')
            : back()->withErrors(['email' => __($status)]);
    }

    // Форма для ввода нового пароля
    public function showResetForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Обновление пароля
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // У тебя в БД поле называется password_hash, а не password
                $user->forceFill([
                    'password_hash' => \Illuminate\Support\Facades\Hash::make($password),
                ])->save();

                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        if ($status == \Illuminate\Support\Facades\Password::PASSWORD_RESET) {
            // После успешной смены — на страницу входа
            return redirect()
                ->route('login')
                ->with('success', 'Пароль успешно изменён! Теперь вы можете войти.');
        }

        // Если что-то пошло не так — вернём обратно с ошибкой
        return back()->withErrors(['email' => __($status)]);
    }
}
