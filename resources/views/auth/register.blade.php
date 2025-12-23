<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register | FoodTY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/auth.css'])
</head>

<body>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="login-page d-flex align-items-center justify-content-center">
        <div class="login-panel w-100 text-center">

            <!-- HEADER -->
            <div class="login-header mb-3">
                <img src="{{ asset('img/logofoodty.png') }}" alt="FoodTY" class="login-logo">
                <h2 class="app-title mb-0">FoodTY</h2>
            </div>

            <!-- CARD -->
            <div class="login-card mx-auto">

                <p class="mb-4" style="font-size:14px;">
                    Lengkapi data berikut untuk membuat akun baru.
                </p>

                <form method="POST" action="{{ route('register.logic') }}">
                    @csrf
                    <!-- Nama Pengguna -->
                    <div class="mb-3">
                        <input name="name" type="text" class="form-control login-input"
                            placeholder="Nama Pengguna" required>
                    </div>

                    <!-- NIK -->
                    <div class="mb-3">
                        <input name="nik" type="text" class="form-control login-input" placeholder="NIK"
                            maxlength="16" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <input name="email" type="email" class="form-control login-input" placeholder="Email"
                            required>
                    </div>

                    {{-- Telepon --}}
                    <div class="mb-3">
                        <input name="no_telp" type="tel" class="form-control login-input"
                            placeholder="Nomor Telepon Aktif" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <input name="password" type="password" class="form-control login-input" placeholder="Password"
                            required>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <input name="password_confirmation" type="password" class="form-control login-input"
                            placeholder="Konfirmasi Password" required>
                    </div>

                    <button type="submit" class="btn login-btn w-100">
                        Daftar
                    </button>
                </form>

                <p class="register-text text-center">
                    Sudah punya akun?
                    <a href="/login">Login di sini</a>
                </p>

            </div>
        </div>
    </div>

</body>

</html>
