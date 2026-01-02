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
});
