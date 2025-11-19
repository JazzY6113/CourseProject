<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\HotTourController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tour', [TourController::class, 'index'])->name('tour');
Route::get('/hot', [HotTourController::class, 'index'])->name('hot');
Route::get('/aboutus', [PageController::class, 'aboutus'])->name('aboutus');
Route::get('/reviews', [PageController::class, 'reviews'])->name('reviews');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/tours/{id}', [TourController::class, 'show'])->name('tour.detail');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/')->with('success', 'Email успешно подтвержден!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])
        ->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/tours', [TourController::class, 'adminIndex'])->name('admin.tours');
    Route::get('/admin/tours/create', [TourController::class, 'create'])->name('admin.tours.create');
    Route::post('/admin/tours', [TourController::class, 'store'])->name('admin.tours.store');
    Route::get('/admin/tours/{id}/edit', [TourController::class, 'edit'])->name('admin.tours.edit');
    Route::put('/admin/tours/{id}', [TourController::class, 'update'])->name('admin.tours.update');
    Route::delete('/admin/tours/{id}', [TourController::class, 'destroy'])->name('admin.tours.delete');
});

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::middleware('auth')->group(function () {
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/reviews', [ReviewController::class, 'adminIndex'])->name('admin.reviews');
    Route::post('/admin/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::post('/admin/reviews/{id}/reject', [ReviewController::class, 'reject'])->name('admin.reviews.reject');
    Route::delete('/admin/reviews/{id}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/api/bookings', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::put('/api/bookings/{id}/cancel', [App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
});
