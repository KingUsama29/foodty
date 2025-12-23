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


//penerima

Route::get('/dashboard_penerima', function () {
    return view('penerima.dashboard_penerima');
});

Route::get('/penerima/riwayat_penerima', function () {
    return view('penerima.riwayat_penerima');
});