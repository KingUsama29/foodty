<?php

//  JANGAN BERANTAKAN ROUTENYA

use Illuminate\Support\Facades\Route;
// ini adalah controller global broo
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
// ini adalah controller admin broo
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PetugasController as AdminPetugasController; 
use App\Http\Controllers\Admin\CabangController as AdminCabangController; 
use App\Http\Controllers\Admin\FoodRequestApprovalController as FoodRequestApprovalController; 
// ini adalah controller petugas bro
use App\Http\Controllers\PetugasController;
// ini adalah controller penerima broo
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\RecipientVerificationController;

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

// ini berarti route yang cuma bisa diakses kalau user udah login, ingat kalo ada halaman yang bisa diakses tanpa perlu user login jangan letakkan disitu
Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    // ini adalah prefix admin yang dimana route khusus halaman admin aja
    Route::prefix('admin')->middleware('role:admin')->group(function(){
        // route dashboard admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        // route admin untuk ngurus data petugas
        Route::resource('petugas', AdminPetugasController::class);
        Route::patch('petugas/{id}/toggle-status', [AdminPetugasController::class, 'toggleStatus'])->name('admin.petugas.toggle-status');
        // route admin untuk ngurus data cabang
        Route::resource('cabang', AdminCabangController::class);
        Route::patch('cabang/{id}/toggle-status', [AdminCabangController::class, 'toggleStatus'])->name('cabang.toggle-status');
        // ini adalah route untuk mengubah status pengajuan donasi bro
        Route::get('/food-requests', [FoodRequestApprovalController::class, 'index'])->name('admin.food-requests.index');
        Route::get('/food-requests/{id}', [FoodRequestApprovalController::class, 'show'])->name('admin.food-requests.show');
        Route::patch('/food-requests/{id}/status', [FoodRequestApprovalController::class, 'updateStatus'])->name('admin.food-requests.updateStatus');
    });
    // ini adalah prefix petugas yang dimana route khusus halaman petugas aja
    Route::prefix('petugas')->middleware('role:petugas')->group(function(){
        Route::get('/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
    });

    // ini adalah prefix penerima yang dimana route khusus halaman penerima aja
    Route::prefix('penerima')->middleware('role:user')->group(function(){
        Route::get('/dashboard', [PenerimaController::class, 'index'])->name('penerima.dashboard');
        Route::get('/verifikasi', [RecipientVerificationController::class, 'index'])->name('verifikasi');
        Route::post('/verifikasi', [RecipientVerificationController::class, 'store'])->name('verifikasi.logic');
    });
    Route::prefix('penerima')->middleware('role:user')->group(function () {
        Route::get('/riwayat', function () {
            return view('penerima.riwayat');
        })->name('penerima.riwayat');
    });

<<<<<<< HEAD
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});
=======
// tampilkan halaman form
Route::get('/pilihform', function () {
    return view('penerima.pilihform');
})->name('form.pilih');

// submit form
Route::post('/pengajuan', function () {
    return back();
})->name('form.pengajuan');

// tampilkan halaman verifikasi
Route::get('/pilihform', function () {
    return view('penerima.pilihform');
})->name('form.pilih');

// tampilkan halaman pengajuan
Route::get('/pengajuan', function () {
    return view('penerima.pengajuan');
})->name('pengajuan');

// submit pengajuan
Route::post('/pengajuan', function () {
    return back();
})->name('form.pengajuan');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
}); 
Route::post('/verifikasi', [RecipientVerificationController::class], 'store')->middleware('auth')->name('verifikasi.store');

>>>>>>> origin/main
