<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordResetController;

// ==========================
// Публичные страницы
// ==========================
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tour', [PageController::class, 'tour'])->name('tour');
Route::get('/hot', [PageController::class, 'hot'])->name('hot');
Route::get('/aboutus', [PageController::class, 'aboutus'])->name('aboutus');
Route::get('/reviews', [PageController::class, 'reviews'])->name('reviews');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// ==========================
// Аутентификация
// ==========================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================
// Подтверждение email
// ==========================

// Уведомление "Подтвердите ваш email"
Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
    ->middleware('auth')
    ->name('verification.notice');

// Обработка перехода по ссылке из письма
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/')->with('success', 'Email успешно подтвержден!');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Повторная отправка письма подтверждения
Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// ==========================
// Дополнительные страницы
// ==========================
Route::get('/mars-na-altae', [PageController::class, 'marsNaAltae'])->name('mars-na-altae');
Route::get('/v-dolinu-chulishman-urochishu-ak-kurum', [PageController::class, 'vDolinuChulishman'])->name('v-dolinu-chulishman');
Route::get('/gori-altaya', [PageController::class, 'goriAltaya'])->name('gori-altaya');

// ==========================
// Восстановление пароля
// ==========================
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.update');

// ==========================
// Личный кабинет
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
