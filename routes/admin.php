<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PetugasController as AdminPetugasController;
use App\Http\Controllers\Admin\CabangController as AdminCabangController;
use App\Http\Controllers\Admin\FoodRequestApprovalController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // ================= PENGAJUAN (VIEW STATIS) =================
    Route::get('/pengajuan', function () {
        return view('admin.pengajuan-admin');
    })->name('admin.pengajuan');

    Route::get('/pengajuan/detail/{id}', function ($id) {
        return view('admin.pengajuan-detail');
    })->name('admin.pengajuan.detail');

    // ================= FOOD REQUESTS (APPROVAL) =================
    Route::get('/food-requests', [FoodRequestApprovalController::class, 'index'])
        ->name('admin.food-requests.index');

    Route::get('/food-requests/{id}', [FoodRequestApprovalController::class, 'show'])
        ->name('admin.food-requests.show');

    Route::patch('/food-requests/{id}/status', [FoodRequestApprovalController::class, 'updateStatus'])
        ->name('admin.food-requests.updateStatus');


    // ================= PETUGAS (CRUD MANUAL - TANPA RESOURCE) =================
    Route::get('/petugas', [AdminPetugasController::class, 'index'])->name('admin.petugas');

    Route::get('/petugas/create', [AdminPetugasController::class, 'create'])->name('admin.petugas.create');
    Route::post('/petugas', [AdminPetugasController::class, 'store'])->name('admin.petugas.store');

    Route::get('/petugas/{user}', [AdminPetugasController::class, 'show'])->name('admin.petugas.detail');

    Route::get('/petugas/{user}/edit', [AdminPetugasController::class, 'edit'])->name('admin.petugas.edit');
    Route::put('/petugas/{user}', [AdminPetugasController::class, 'update'])->name('admin.petugas.update');

    Route::delete('/petugas/{user}', [AdminPetugasController::class, 'destroy'])->name('admin.petugas.destroy');

    Route::patch('/petugas/{user}/toggle-status', [AdminPetugasController::class, 'toggleStatus'])
        ->name('admin.petugas.toggle-status');


    // ================= CABANG =================
    /**
     * Kamu sebelumnya ada 2 versi:
     * 1) CabangController (resource)
     * 2) route view statis /cabang -> admin.cabang-lokasi
     *
     * Karena kamu minta jangan pakai resource, gue rapihin jadi route manual.
     * Kalau cabang kamu masih statis view doang, biarin route view ini.
     * Kalau cabang sudah CRUD beneran di controller, tinggal uncomment blok controller di bawah.
     */

    // --- CABANG (VIEW STATIS) ---
    Route::get('/cabang', function () {
        return view('admin.cabang-lokasi');
    })->name('admin.cabang');

    // --- CABANG (CRUD MANUAL - kalau kamu sudah siap pake controller) ---
    /*
    Route::get('/cabang', [AdminCabangController::class, 'index'])->name('admin.cabang');
    Route::get('/cabang/create', [AdminCabangController::class, 'create'])->name('admin.cabang.create');
    Route::post('/cabang', [AdminCabangController::class, 'store'])->name('admin.cabang.store');
    Route::get('/cabang/{cabang}', [AdminCabangController::class, 'show'])->name('admin.cabang.detail');
    Route::get('/cabang/{cabang}/edit', [AdminCabangController::class, 'edit'])->name('admin.cabang.edit');
    Route::put('/cabang/{cabang}', [AdminCabangController::class, 'update'])->name('admin.cabang.update');
    Route::delete('/cabang/{cabang}', [AdminCabangController::class, 'destroy'])->name('admin.cabang.destroy');

    Route::patch('/cabang/{cabang}/toggle-status', [AdminCabangController::class, 'toggleStatus'])
        ->name('admin.cabang.toggle-status');
    */

    // ================= STOK (VIEW STATIS) =================
    Route::get('/stok', function () {
        return view('admin.stok-barang');
    })->name('admin.stok');

    Route::get('/stok/{daerah}', function ($daerah) {
        return view('admin.stok-barang-detail', compact('daerah'));
    })->name('admin.stok.detail');

    // ================= PENYALURAN (VIEW STATIS) =================
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
