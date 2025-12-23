<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landingPage');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (PUNYA TEMANMU)
|--------------------------------------------------------------------------
*/
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

Route::get('/pilihform', function () {
    return view('penerima2.pilihform');
});
