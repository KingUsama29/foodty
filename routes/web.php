<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Auth Routes

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/lupa_password', function () {
    return view('auth.lupa_password');
})->name('lupa_password');

Route::post('/register',[AuthController::class, 'register']);

