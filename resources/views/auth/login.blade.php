<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Masuk | FoodTY</title>
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

            {{-- ERROR BACKEND (Laravel) --}}
            @if ($errors->any())
                <div class="alert alert-danger small">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="alert alert-success small">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR (login / reset / lainnya) --}}
            @if ($errors->any())
                <div class="alert alert-danger small">
                    {{ $errors->first() }}
                </div>
            @endif


            <!-- HEADER -->
            <div class="text-center mb-4">
                <img src="{{ asset('gambar/logo_foodty.png') }}" class="auth-logo mb-2" alt="FoodTY">
                <h5 class="fw-bold mb-1">Selamat Datang</h5>
                <p class="text-muted small mb-0">Masuk untuk melanjutkan</p>
            </div>

            <!-- FORM -->
            <form method="POST" action="{{ route('login.logic') }}" novalidate>
                @csrf

                <!-- NIK -->
                <div class="mb-3">
                    <input name="nik" class="form-control" placeholder="Nomor NIK" value="{{ old('nik') }}"
                        required oninvalid="this.setCustomValidity('Nomor NIK wajib diisi')"
                        oninput="this.setCustomValidity('')">
                </div>

                <!-- EMAIL -->
                <div class="mb-3">
                    <input name="email" type="email" class="form-control" placeholder="Email"
                        value="{{ old('email') }}" required
                        oninvalid="this.setCustomValidity('Masukkan alamat email yang valid')"
                        oninput="this.setCustomValidity('')">
                </div>

                <!-- PASSWORD -->
                <div class="mb-4">
                    <div class="input-group">
                        <input id="password" name="password" type="password" class="form-control"
                            placeholder="Password" minlength="8" required
                            oninvalid="this.setCustomValidity('Password minimal 8 karakter')"
                            oninput="this.setCustomValidity('')">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                            <i id="eyeIcon" class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button class="btn btn-primary w-100 mb-3">
                    Masuk
                </button>
            </form>

            <!-- LINKS -->
            <div class="text-center small">
                <a href="{{ route('lupa_password') }}" class="d-block mb-2">Lupa password?</a>
                Belum punya akun?
                <a href="{{ route('register') }}" class="fw-semibold">Daftar</a>
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>

</body>

</html>
