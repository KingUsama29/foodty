<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | FoodTY</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/login_register.css') }}">
</head>
<body>

<div class="login-wrapper d-flex justify-content-center align-items-center">
    <div class="login-container text-center">

        <!-- Logo -->
        <div class="logo mb-3">
            <img src="{{ asset('img/logofoodty.png') }}" alt="FoodTY">
        </div>

        <!-- App Name -->
        <h2 class="app-name mb-4">FoodTY</h2>

        <!-- Card -->
        <div class="login-card">

            <form>
                <div class="mb-3">
                    <input type="text" class="form-control custom-input"
                           placeholder="Masukkan nama pengguna">
                </div>

                <div class="mb-4">
                    <input type="password" class="form-control custom-input"
                           placeholder="Masukkan Password">
                </div>

                <button type="submit" class="btn btn-primary w-100 custom-btn">
                    Login
                </button>
            </form>

            <p class="register-text mt-4">
                Belum punya akun?
                <a href="#">daftar disini ya</a>
            </p>

        </div>
    </div>
</div>

</body>
</html>
