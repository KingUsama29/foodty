<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipientVerificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\Admin\PetugasController as AdminPetugasController; 
use App\Http\Controllers\PenerimaController;
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


Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::prefix('admin')->middleware('role:admin')->group(function(){
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('petugas', AdminPetugasController::class);
        Route::patch('petugas/{id}/toggle-status', [AdminPetugasController::class, 'toggleStatus'])->name('admin.petugas.toggle-status');
    });
    Route::prefix('petugas')->middleware('role:petugas')->group(function(){
        Route::get('/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
    });
    Route::prefix('penerima')->middleware('role:user')->group(function(){
        Route::get('/dashboard', [PenerimaController::class, 'index'])->name('penerima.dashboard');
    });

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
Route::post('/verifikasi', [RecipientVerificationController::class], 'store')->middleware('auth')->name('verifikasi.store');

