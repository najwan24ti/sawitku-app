<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guest\CatatanKeuanganController;
use App\Http\Controllers\Guest\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN DEPAN (Landing Page)
// Lokasi: resources/views/pages/guest/home.blade.php
Route::get('/', function () {
    return view('home');  // <-- Cukup panggil 'home' saja
})->name('home');


// 2. RUTE UNTUK TAMU (Belum Login)
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // LUPA PASSWORD
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // RESET PASSWORD (Form Baru)
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});


// 3. RUTE UNTUK USER (Sudah Login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard (PENTING: Controller kamu mengarah ke nama 'guest.dashboard')
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('guest.dashboard');

    // CRUD Catatan Keuangan
    Route::resource('catatan-keuangan', CatatanKeuanganController::class);
    
    // Laporan
    Route::get('/laporan', [CatatanKeuanganController::class, 'laporan'])->name('catatan-keuangan.laporan');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});