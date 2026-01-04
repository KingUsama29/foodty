<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\RecipientVerificationController;
use App\Http\Controllers\FoodRequestController;
use App\Http\Controllers\RiwayatPengajuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenyaluranController;

use App\Models\FoodRequest;

Route::prefix('penerima')->middleware('role:penerima')->group(function () {

    Route::get('/dashboard', [PenerimaController::class, 'index'])->name('penerima.dashboard');

    // verifikasi penerima
    Route::get('/verifikasi', [RecipientVerificationController::class, 'index'])->name('verifikasi');
    Route::post('/verifikasi', [RecipientVerificationController::class, 'store'])->name('verifikasi.logic');
    // halaman pengajuan
    Route::get('/pengajuan', [FoodRequestController::class, 'index'])->name('penerima.pengajuan.index');
    Route::post('/pengajuan', [FoodRequestController::class, 'store'])->name('penerima.pengajuan.store');

    // riwayat
    Route::get('/penerima/riwayat', [RiwayatPengajuanController::class, 'index'])->name('penerima.riwayat');
    Route::get('/penerima/riwayat/{id}', [RiwayatPengajuanController::class, 'show'])->name('penerima.riwayat.show');

     Route::get('/penyaluran', [PenyaluranController::class, 'index'])->name('penerima.penyaluran');
    Route::get('/penyaluran/{distribution}', [PenyaluranController::class, 'show'])->name('penerima.penyaluran.show');

    Route::get('/profile', [ProfileController::class, 'show'])->name('penerima.profile');
});
