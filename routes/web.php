<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\PasswordResetController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SocialAuthController;
use App\Http\Controllers\User\AdminController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MyReservationsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('auth.dashboard');
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('auth.reservations');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings/store-step1', [ListingController::class, 'storeStep1'])->name('listings.store-step1');
    Route::get('/listings/create-step2/{id}', [ListingController::class, 'createStep2'])->name('listings.create-step2');
    Route::post('/listings/store-step2/{id}', [ListingController::class, 'storeStep2'])->name('listings.store-step2');
    Route::get('/listings/{id}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{id}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{id}', [ListingController::class, 'destroy'])->name('listings.destroy');
    Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');
    Route::get('/my-reservations', [MyReservationsController::class, 'index'])->name('my.reservations');
    Route::post('/reservations/{id}/confirm', [AdminController::class, 'confirmReservation'])->name('admin.reservations.confirm');
    Route::post('/reservations/{id}/refuse', [AdminController::class, 'refuseReservation'])->name('admin.reservations.refuse');
});