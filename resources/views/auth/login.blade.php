<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | FoodTY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Vite -->
    @vite([
        'resources/css/auth.css',
        'resources/js/app.js'
    ])
</head>
<body>

<!-- FULL PAGE WRAPPER -->
<div class="login-page d-flex align-items-center justify-content-center">

    <!-- PANEL UTAMA -->
    <div class="login-panel w-100 text-center">

        <!-- HEADER (LOGO + TITLE) -->
        <div class="login-header mb-3">
            <img
                src="{{ asset('img/logofoodty.png') }}"
                alt="FoodTY"
                class="login-logo"
            >

            <h2 class="app-title mb-0">FoodTY</h2>
        </div>

        <!-- CARD LOGIN -->
        <div class="login-card mx-auto">

            <form method="POST" action="#">
                @csrf

                <div class="mb-3">
                    <input
                        type="text"
                        class="form-control login-input"
                        placeholder="Masukkan nama pengguna"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-4">
                    <input
                        type="password"
                        class="form-control login-input"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <button type="submit" class="btn login-btn w-100">
                    Masuk
                </button>
            </form>

            <p class="register-text text-center">
                 Lupa Password ?
                <a href="{{ route('lupa_password') }}">klik disini</a>
            </p>

            <p class="register-text text-center">
                Belum punya akun?
                <a href="{{ route('register') }}">daftar disini</a>
            </p>

        </div>

    </div>
</div>

</body>
</html>
