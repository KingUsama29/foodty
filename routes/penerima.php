<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\RecipientVerificationController;

Route::prefix('penerima')->middleware('role:user')->group(function () {

    Route::get('/dashboard', [PenerimaController::class, 'index'])->name('penerima.dashboard');

    // verifikasi penerima
    Route::get('/verifikasi', [RecipientVerificationController::class, 'index'])->name('verifikasi');
    Route::post('/verifikasi', [RecipientVerificationController::class, 'store'])->name('verifikasi.logic');

    // riwayat
    Route::get('/riwayat', function () {
        return view('penerima.riwayat');
    })->name('penerima.riwayat');

    // halaman pengajuan
    Route::get('/pengajuan', function () {
        return view('penerima.pengajuan');
    })->name('pengajuan');

    // submit pengajuan
    Route::post('/pengajuan', function () {
        return back();
    })->name('form.pengajuan');
});
