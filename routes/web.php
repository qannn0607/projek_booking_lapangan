<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController; // Pindahkan ke atas biar rapi
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// HAPUS route /dashboard yang lama (yang hanya return view)
// Kita gunakan yang di bawah ini karena sudah terhubung ke Controller

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard sekarang dikelola oleh BookingController
    Route::get('/dashboard', [BookingController::class, 'index'])->name('dashboard');
    
    // Simpan booking baru
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    
    // Profile routes (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Route Tampilan Dashboard
    Route::get('/dashboard', [BookingController::class, 'index'])->name('dashboard');
    
    // Route Simpan Booking
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    
    // TAMBAHKAN INI: Route untuk Hapus Booking
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});
require __DIR__.'/auth.php';