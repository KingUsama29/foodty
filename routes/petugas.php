<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\Petugas\DonasiController;
use App\Http\Controllers\Petugas\ProfileController;

Route::prefix('petugas')->middleware('role:petugas')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
    Route::get('/data-penerima', [DonasiController::class, 'index'])->name('petugas.data-penerima');
    Route::get('/data-donasi', [DonasiController::class, 'index'])->name('petugas.data-donasi');
    Route::get('/profil-petugas', [ProfileController::class, 'index'])->name('petugas.profil-petugas');
});
