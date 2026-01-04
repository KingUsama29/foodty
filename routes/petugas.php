<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\Petugas\DonasiController;
use App\Http\Controllers\Petugas\ProfileController;
use App\Http\Controllers\Petugas\PenerimaManageController;
use App\Http\Controllers\Petugas\DonorController;
use App\Http\Controllers\Petugas\FoodRequestManageController;

Route::prefix('petugas')->middleware('role:petugas')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
    Route::get('/penerima', [PenerimaManageController::class, 'index'])->name('petugas.data-penerima');
    Route::get('/penerima/{verification}', [PenerimaManageController::class, 'show'])->name('petugas.penerima-detail');

    Route::patch('/penerima/{verification}/approve', [PenerimaManageController::class, 'approve'])->name('penerima.approve');
    Route::patch('/penerima/{verification}/reject', [PenerimaManageController::class, 'reject'])->name('penerima.reject');
    Route::get('/data-donasi', [DonasiController::class, 'index'])->name('petugas.data-donasi');
    Route::get('/profil-petugas', [ProfileController::class, 'index'])->name('petugas.profil-petugas');


    Route::get('/donatur', [DonorController::class, 'index'])->name('petugas.data-donatur');
    Route::get('/donatur/create', [DonorController::class, 'create'])->name('petugas.donatur.create');
    Route::post('/donatur', [DonorController::class, 'store'])->name('petugas.donatur.store');
    Route::get('/donatur/{donor}/edit', [DonorController::class, 'edit'])->name('petugas.donatur.edit');
    Route::put('/donatur/{donor}', [DonorController::class, 'update'])->name('petugas.donatur.update');
    Route::delete('/donatur/{donor}', [DonorController::class, 'destroy'])->name('petugas.donatur.destroy');
    Route::get('/donatur/search', [DonorController::class, 'search'])->name('petugas.donatur.search');


    Route::get('/data-donasi', [DonasiController::class, 'index'])->name('petugas.data-donasi');
    Route::get('/data-donasi/create', [DonasiController::class, 'create'])->name('petugas.donasi.create');
    Route::post('/data-donasi', [DonasiController::class, 'store'])->name('petugas.donasi.store');
    Route::get('data-donasi/item-suggest', [DonasiController::class, 'itemSuggest'])->name('petugas.donasi.item-suggest');
    Route::get('/data-donasi/{donation}', [DonasiController::class, 'show'])->name('petugas.donasi.detail');
    Route::delete('/data-donasi/{donation}', [DonasiController::class, 'destroy'])->name('petugas.donasi.destroy');
    Route::post('/data-donasi/{donation}/cancel', [DonasiController::class, 'cancel'])->name('petugas.donasi.cancel');


    Route::get('/petugas/pengajuan', [FoodRequestManageController::class, 'index'])->name('petugas.data-pengajuan');
    Route::get('/petugas/pengajuan/{foodRequest}', [FoodRequestManageController::class, 'show'])->name('petugas.pengajuan.detail');

    Route::get('/profil-petugas', [ProfileController::class, 'index'])->name('petugas.profil-petugas');
    Route::patch('/profil-petugas', [ProfileController::class, 'update'])->name('petugas.profil-petugas.update');
    Route::delete('/profil-petugas/photo', [ProfileController::class, 'deletePhoto'])->name('petugas.profil-petugas.photo.delete');


    Route::get('/penyaluran', [\App\Http\Controllers\Petugas\PenyaluranController::class, 'index'])
    ->name('petugas.data-penyaluran');
    Route::get('/penyaluran/requests', [\App\Http\Controllers\Petugas\PenyaluranController::class, 'requests'])
    ->name('petugas.penyaluran.requests');
    
    Route::get('/penyaluran/create', [\App\Http\Controllers\Petugas\PenyaluranController::class, 'create'])
        ->name('petugas.penyaluran-create');

    Route::post('/penyaluran', [\App\Http\Controllers\Petugas\PenyaluranController::class, 'store'])
        ->name('petugas.penyaluran.store');

    Route::get('/penyaluran/{distribution}', [\App\Http\Controllers\Petugas\PenyaluranController::class, 'show'])
        ->name('petugas.penyaluran.show');

    Route::post('/penyaluran/{distribution}/cancel', [\App\Http\Controllers\Petugas\PenyaluranController::class, 'cancel'])
        ->name('petugas.penyaluran.cancel');




});
