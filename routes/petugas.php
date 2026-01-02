<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasController;

Route::prefix('petugas')->middleware('role:petugas')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
});
