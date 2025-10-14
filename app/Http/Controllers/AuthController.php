<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Показать форму регистрации
     */
    public function showRegistrationForm()
    {
        return view('register');
    }

    /**
     * Обработка регистрации
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Получаем или создаем роль "user"
        $userRole = $this->getOrCreateUserRole();

        $user = User::create([
            'role_id' => $userRole->id,
            'login' => $request->email,
            'password_hash' => Hash::make($request->password),
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'patronymic' => $request->patronymic,
            'is_email_verified' => false,
        ]);

        // Отправляем email верификации
        event(new Registered($user));

        // НЕ логиним пользователя сразу - ждем подтверждения email
        // Auth::login($user);

        return redirect()->route('verification.notice');
    }

    /**
     * Получить или создать роль "user"
     */
    private function getOrCreateUserRole()
    {
        $userRole = Role::where('role_name', 'user')->first();

        if (!$userRole) {
            $userRole = Role::create([
                'role_name' => 'user'
            ]);
        }

        return $userRole;
    }

    /**
     * Показать форму входа
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Обработка входа
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            throw ValidationException::withMessages([
                'email' => ['Неверные учетные данные'],
            ]);
        }

        // Проверяем верификацию email
        if (!$user->hasVerifiedEmail()) {
            Auth::login($user); // Логиним чтобы показать страницу верификации
            return redirect()->route('verification.notice');
        }

        Auth::login($user);

        return redirect()->intended('/');
    }

    /**
     * Выход пользователя
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Показать страницу подтверждения email
     */
    public function showVerificationNotice()
    {
        return view('auth.verify-email');
    }

    /**
     * Повторная отправка письма подтверждения
     */
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Ссылка для подтверждения отправлена!');
    }
}
