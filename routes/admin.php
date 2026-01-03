<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PetugasController as AdminPetugasController;
use App\Http\Controllers\Admin\CabangController as AdminCabangController;
use App\Http\Controllers\Admin\FoodRequestApprovalController;

Route::prefix('admin')->middleware('role:admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('petugas', AdminPetugasController::class);
    Route::patch('petugas/{id}/toggle-status', [AdminPetugasController::class, 'toggleStatus'])
        ->name('admin.petugas.toggle-status');

    Route::resource('cabang', AdminCabangController::class);
    Route::patch('cabang/{id}/toggle-status', [AdminCabangController::class, 'toggleStatus'])
        ->name('cabang.toggle-status');

    Route::get('/food-requests', [FoodRequestApprovalController::class, 'index'])
        ->name('admin.food-requests.index');
    Route::get('/food-requests/{id}', [FoodRequestApprovalController::class, 'show'])
        ->name('admin.food-requests.show');
    Route::patch('/food-requests/{id}/status', [FoodRequestApprovalController::class, 'updateStatus'])
        ->name('admin.food-requests.updateStatus');
        Route::get('/pengajuan', function () {
        return view('admin.pengajuan-admin');
        })->name('admin.pengajuan');

        Route::get('/pengajuan/detail/{id}', function ($id) {
        return view('admin.pengajuan-detail');
        })->name('admin.pengajuan.detail');

        Route::get('/petugas', function () {
        return view('admin.manajemen-petugas');
        })->name('admin.petugas');

        Route::get('/petugas/detail/{id}', function ($id) {
        return view('admin.manajemen-petugas-detail');
        })->name('admin.petugas.detail');

        Route::get('/cabang', function () {
        return view('admin.cabang-lokasi');
        })->name('admin.cabang');

        Route::get('/stok', function () {
        return view('admin.stok-barang');
        })->name('admin.stok');

        Route::get('/stok/{daerah}', function ($daerah) {
        return view('admin.stok-barang-detail', compact('daerah'));
        })->name('admin.stok.detail');

        Route::get('/penyaluran', function () {
        return view('admin.penyaluran');
        })->name('admin.penyaluran');

        Route::get('/penyaluran/form/{daerah}', function ($daerah) {
        return view('admin.penyaluran-form', compact('daerah'));
        })->name('admin.penyaluran.form');

        Route::get('/penyaluran/ringkasan', function () {
        return view('admin.penyaluran-ringkasan');
        })->name('admin.penyaluran.ringkasan');

        Route::get('/penyaluran/riwayat', function () {
        return view('admin.penyaluran-riwayat');
        })->name('admin.penyaluran.riwayat');
});
