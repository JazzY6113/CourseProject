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
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('home')->with('success', 'Пароль успешно изменён!')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
