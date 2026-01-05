<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController as AdminDashboardController;
use App\Http\Controllers\Admin\PetugasController as AdminPetugasController;
use App\Http\Controllers\Admin\CabangController as AdminCabangController;
use App\Http\Controllers\Admin\FoodRequestApprovalController;
use App\Http\Controllers\Admin\StockController as AdminStockController;
use App\Http\Controllers\Admin\PenyaluranController as AdminPenyaluranController;


Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // ================= PENGAJUAN (DINAMIS - FOOD REQUESTS) =================
    // Halaman yang kamu buka di sidebar: admin.pengajuan
    Route::get('/pengajuan', [FoodRequestApprovalController::class, 'index'])
        ->name('admin.pengajuan');

    // Detail pengajuan (yang kamu pakai di tabel: admin.pengajuan.detail)
    Route::get('/pengajuan/detail/{id}', [FoodRequestApprovalController::class, 'show'])
        ->name('admin.pengajuan.detail');

    // Route untuk modal ACC/Tolak (tetap dipakai form action)
    Route::patch('/food-requests/{id}/status', [FoodRequestApprovalController::class, 'updateStatus'])
        ->name('admin.food-requests.updateStatus');

    // OPTIONAL (kalau kamu masih butuh akses URL /admin/food-requests)
    // Kalau gak dipakai, aman dihapus biar gak dobel
    Route::get('/food-requests', [FoodRequestApprovalController::class, 'index'])
        ->name('admin.food-requests.index');

    Route::get('/food-requests/{id}', [FoodRequestApprovalController::class, 'show'])
        ->name('admin.food-requests.show');


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


    // ================= CABANG (CRUD MANUAL - TANPA RESOURCE) =================
    Route::get('/cabang', [AdminCabangController::class, 'index'])->name('admin.cabang');

    Route::get('/cabang/create', [AdminCabangController::class, 'create'])->name('admin.cabang.create');
    Route::post('/cabang', [AdminCabangController::class, 'store'])->name('admin.cabang.store');

    Route::get('/cabang/{cabang}/edit', [AdminCabangController::class, 'edit'])->name('admin.cabang.edit');
    Route::put('/cabang/{cabang}', [AdminCabangController::class, 'update'])->name('admin.cabang.update');

    Route::delete('/cabang/{cabang}', [AdminCabangController::class, 'destroy'])->name('admin.cabang.destroy');

    Route::patch('/cabang/{cabang}/toggle-status', [AdminCabangController::class, 'toggleStatus'])
        ->name('admin.cabang.toggle-status');


    Route::get('/stok-barang', [AdminStockController::class, 'index'])->name('admin.stok-barang');
    Route::get('/stok-barang/{cabangId}/{warehouseItemId}', [AdminStockController::class, 'show'])->name('admin.stok-barang.detail');

    Route::get('/penyaluran', [AdminPenyaluranController::class, 'index'])->name('admin.penyaluran');
    Route::get('/penyaluran/{id}', [AdminPenyaluranController::class, 'show'])->whereNumber('id')->name('admin.penyaluran.detail');

});
