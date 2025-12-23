<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landingPage');
});

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
});
Route::post('/login',[AuthController::class, 'login'])->name('login.logic');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.logic');

Route::get('/lupa_password', function () {
    return view('auth.lupa_password');
})->name('lupa_password');

// Admin Route
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

  Route::get('/manajemen-petugas', function () {
        return view('admin.manajemen-petugas');
    });

    Route::get('/manajemen-petugas/detail', function () {
        return view('admin.manajemen-petugas-detail');
    });

    Route::get('/penerima', function () {
        return view('admin.penerima');
    });

    Route::get('/penerima/detail', function () {
        return view('admin.penerima-detail');
    });

    Route::get('/cabang', function () {
        return view('admin.cabang');
    });

    Route::get('/barang', function () {
        return view('admin.barang');
    });

    Route::get('/barang/detail', function () {
        return view('admin.barang-detail');
    });

    Route::prefix('admin')->group(function () {
    Route::get('/salurkan', fn() => view('admin.salurkan'));
    Route::get('/salurkan/form', fn() => view('admin.salurkan-form'));
    Route::get('/salurkan/ringkasan', fn() => view('admin.salurkan-ringkasan'));
    Route::get('/salurkan/riwayat', fn() => view('admin.salurkan-riwayat'));
    });
