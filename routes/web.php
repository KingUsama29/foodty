<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// controller penerima (buat include penerima.php butuh classnya di sana)
Route::get('/', function () {
    return view('landingPage');
});

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login.logic');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.logic');

Route::get('/lupa_password', function () {
    return view('auth.lupa_password');
})->name('lupa_password');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    require __DIR__.'/admin.php';
    require __DIR__.'/petugas.php';
    require __DIR__.'/penerima.php';

    //tambahan
            Route::get('/riwayat', function () {
            return view('penerima.riwayat');
        })->name('penerima.riwayat');
    //tambahan


    // tampilkan halaman form
Route::get('/pilihform', function () {
    return view('penerima.pilihform');
})->name('form.pilih');

// submit form
Route::post('/pengajuan', function () {
    return back();
})->name('form.pengajuan');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
