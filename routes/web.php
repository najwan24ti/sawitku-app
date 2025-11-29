<?php

use Illuminate\Support\Facades\Route;

// Import semua Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Guest\CatatanKeuanganController;
use App\Http\Controllers\Guest\ForgotPasswordController;
// Controller Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN DEPAN (Landing Page)
Route::get('/', function () {
    return view('home'); 
})->name('home');


// 2. RUTE UNTUK TAMU (Belum Login)
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Lupa Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});


// 3. RUTE UNTUK USER (Sudah Login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Petani (Controller Guest)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('guest.dashboard');

    // CRUD Catatan Keuangan
    Route::resource('catatan-keuangan', CatatanKeuanganController::class);
    
    // Laporan Keuangan
    Route::get('/laporan', [CatatanKeuanganController::class, 'laporan'])->name('catatan-keuangan.laporan');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


// 4. RUTE KHUSUS ADMIN
// Hanya bisa diakses jika login DAN role = admin
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen User (CRUD User)
    Route::resource('users', UserController::class);

    // Manajemen Event Mitra (Jika nanti dibutuhkan)
    // Route::resource('events', EventController::class);
});