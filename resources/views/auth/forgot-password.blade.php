<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lupa Password | FoodTY</title>
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

            @if (session('status'))
                <div class="alert alert-success small">{{ session('status') }}</div>
            @endif

            <div class="text-center mb-4">
                <img src="{{ asset('gambar/logo_foodty.png') }}" class="auth-logo mb-2" alt="FoodTY">
                <h5 class="fw-bold mb-1">Lupa Password</h5>
                <p class="text-muted small mb-0">Masukkan email terdaftar untuk menerima link reset</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-4">
                    <input type="email" name="email" class="form-control" placeholder="Email Terdaftar"
                        value="{{ old('email') }}" required>
                </div>

                <button class="btn btn-primary w-100">Kirim Link Reset</button>
            </form>

            <div class="text-center small mt-3">
                <a href="/login">Kembali ke Login</a>
            </div>

        </div>
    </div>
</body>

</html>
