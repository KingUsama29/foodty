<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password | FoodTY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/auth.css'])
</head>

<body>
    <div class="auth-wrapper">
        <div class="card auth-card p-4 p-md-5">

            @if ($errors->any())
                <div class="alert alert-danger small">{{ $errors->first() }}</div>
            @endif

            <div class="text-center mb-4">
                <img src="{{ asset('gambar/logo_foodty.png') }}" class="auth-logo mb-2" alt="FoodTY">
                <h5 class="fw-bold mb-1">Reset Password</h5>
                <p class="text-muted small mb-0">Buat password baru untuk akun kamu</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <input type="hidden" name="email" class="form-control" placeholder="Email"
                        value="{{ old('email', $email) }}" required>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <input id="password" name="password" type="password" class="form-control"
                            placeholder="Password Baru" minlength="8" required>
                        <button class="btn btn-outline-secondary" type="button"
                            onclick="togglePassword('password','eye1')">
                            <i id="eye1" class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="input-group">
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="form-control" placeholder="Konfirmasi Password" minlength="8" required>
                        <button class="btn btn-outline-secondary" type="button"
                            onclick="togglePassword('password_confirmation','eye2')">
                            <i id="eye2" class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button class="btn btn-primary w-100">Simpan Password Baru</button>
            </form>

            <div class="text-center small mt-3">
                <a href="/login">Kembali ke Login</a>
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
