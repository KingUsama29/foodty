<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar | FoodTY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/auth.css'])
</head>

<body>

<div class="auth-wrapper">
    <div class="card auth-card p-4 p-md-5">

        {{-- BACKEND NOTIF BIARIN --}}
        @if (session('success'))
            <div class="alert alert-success small">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger small">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- HEADER -->
        <div class="text-center mb-4">
            <img src="{{ asset('gambar/logo_foodty.png') }}" class="auth-logo mb-2" alt="FoodTY">
            <h5 class="fw-bold mb-1">Buat Akun Baru</h5>
            <p class="text-muted small mb-0">Lengkapi data untuk mendaftar</p>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('register.logic') }}">
            @csrf

            <div class="mb-3">
                <input name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <input name="nik" class="form-control" placeholder="NIK" maxlength="16" value="{{ old('nik') }}" required>
            </div>

            <div class="mb-3">
                <input name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <input name="no_telp" class="form-control" placeholder="Nomor Telepon Aktif" value="{{ old('no_telp') }}" required>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
                <div class="input-group">
                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password','eye1')">
                        <i id="eye1" class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="mb-4">
                <div class="input-group">
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Konfirmasi Password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation','eye2')">
                        <i id="eye2" class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button class="btn btn-primary w-100 mb-3">
                Daftar
            </button>
        </form>

        <!-- LINK -->
        <div class="text-center small">
            Sudah punya akun?
            <a href="/login" class="fw-semibold">Login</a>
        </div>

    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = "password";
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>

</body>
</html>
