<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Rules\CyrillicName;
use App\Rules\StrongPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => ['required', 'string', 'max:255', new CyrillicName],
            'last_name'     => ['required', 'string', 'max:255', new CyrillicName],
            'patronymic'    => ['nullable', 'string', 'max:255', 'regex:/^[А-ЯЁ][а-яё]{0,29}$|^$/u'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults(), new StrongPassword],
        ], [
            'first_name.required'   => 'Введите имя.',
            'last_name.required'    => 'Введите фамилию.',
            'email.required'        => 'Введите e-mail.',
            'email.email'           => 'Введите корректный e-mail.',
            'email.unique'          => 'Такой e-mail уже зарегистрирован.',
            'password.required'     => 'Введите пароль.',
            'password.confirmed'    => 'Пароли не совпадают.',
            'patronymic.regex'      => 'Отчество должно содержать только кириллические символы и начинаться с заглавной буквы.',
        ]);

        $role = Role::firstOrCreate(['role_name' => 'user']);

        $user = User::create([
            'role_id'          => $role->id,
            'first_name'       => $validated['first_name'],
            'last_name'        => $validated['last_name'],
            'patronymic'       => $validated['patronymic'] ?? null,
            'email'            => $validated['email'],
            'password_hash'    => Hash::make($validated['password']),
            'is_email_verified'=> false,
        ]);

        event(new Registered($user));

        return redirect()->route('verification.notice')
            ->with('status', 'Проверьте почту для подтверждения e-mail.');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'password'  => ['required', 'string'],
        ], [
            'email.required'    => 'Введите e-mail.',
            'email.email'       => 'Неверный формат e-mail.',
            'email.regex'       => 'Введите корректный e-mail адрес.',
            'password.required' => 'Введите пароль.',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password_hash)) {
            throw ValidationException::withMessages([
                'email' => 'Неверный e-mail или пароль.',
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            Auth::login($user);
            return redirect()->route('verification.notice')
                ->with('status', 'Подтвердите e-mail, чтобы продолжить.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'Добро пожаловать!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Вы вышли из аккаунта.');
    }

    public function showVerificationNotice()
    {
        return view('auth.verify-email');
    }

    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Ссылка для подтверждения повторно отправлена!');
    }
}
