<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// controller penerima (buat include penerima.php butuh classnya di sana)
Route::get('/', function () {
    return view('landingPage');
});

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login.logic');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.logic');



Route::middleware('guest')->group(function () {

    // tampilkan form "lupa password"
    Route::get('/lupa_password', function () {
        return view('auth.forgot-password'); // view baru (lihat bawah)
    })->name('lupa_password');

    // kirim email link reset
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset password sudah dikirim ke email kamu.')
            : back()->withErrors(['email' => 'Email tidak ditemukan atau gagal mengirim link reset.']);
    })->name('password.email');

    // halaman reset password dari link email
    Route::get('/reset-password/{token}', function (string $token, Request $request) {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    })->name('password.reset');

    // simpan password baru
    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('success', 'Password berhasil direset. Silakan login.')
            : back()->withErrors(['email' => 'Token tidak valid / sudah expired. Coba request ulang.']);
    })->name('password.update');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    require __DIR__.'/admin.php';
    require __DIR__.'/petugas.php';
    require __DIR__.'/penerima.php';

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});