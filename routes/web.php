<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Публичные страницы
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tour', [PageController::class, 'tour'])->name('tour');
Route::get('/hot', [PageController::class, 'hot'])->name('hot');
Route::get('/aboutus', [PageController::class, 'aboutus'])->name('aboutus');
Route::get('/reviews', [PageController::class, 'reviews'])->name('reviews');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Аутентификация
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification Routes
Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/')->with('success', 'Email успешно подтвержден!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

// Дополнительные страницы
Route::get('/mars-na-altae', [PageController::class, 'marsNaAltae'])->name('mars-na-altae');
Route::get('/v-dolinu-chulishman-urochishu-ak-kurum', [PageController::class, 'vDolinuChulishman'])->name('v-dolinu-chulishman');
Route::get('/gori-altaya', [PageController::class, 'goriAltaya'])->name('gori-altaya');
