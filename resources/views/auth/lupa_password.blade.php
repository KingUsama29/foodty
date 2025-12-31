<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password | FoodTY</title>
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

        <!-- HEADER -->
        <div class="text-center mb-4">
            <img src="{{ asset('gambar/logo_foodty.png') }}" class="auth-logo mb-2" alt="FoodTY">
            <h5 class="fw-bold mb-1">Lupa Password</h5>
            <p class="text-muted small mb-0">Pulihkan akses akun Anda</p>
        </div>

        <!-- STEP 1 -->
        <div id="step-email">
            <p class="small text-muted mb-3">
                Masukkan email terdaftar untuk menerima kode OTP.
            </p>

            <input type="email" class="form-control mb-4" placeholder="Email Terdaftar">

            <button class="btn btn-primary w-100" onclick="goToOTP()">
                Kirim Kode OTP
            </button>
        </div>

        <!-- STEP 2 -->
        <div id="step-otp" style="display:none;">
            <p class="small text-muted mb-3">
                Masukkan kode OTP yang dikirim ke email Anda.
            </p>

            <input type="text" class="form-control text-center mb-4" placeholder="Kode OTP">

            <button class="btn btn-primary w-100" onclick="goToPassword()">
                Verifikasi OTP
            </button>
        </div>

        <!-- STEP 3 -->
        <div id="step-password" style="display:none;">
            <p class="small text-muted mb-3">
                Buat password baru untuk akun Anda.
            </p>

            <div class="input-group mb-3">
                <input id="newPassword" type="password" class="form-control" placeholder="Password Baru">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword','eye3')">
                    <i id="eye3" class="bi bi-eye"></i>
                </button>
            </div>

            <div class="input-group mb-4">
                <input id="confirmPassword" type="password" class="form-control" placeholder="Konfirmasi Password">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword','eye4')">
                    <i id="eye4" class="bi bi-eye"></i>
                </button>
            </div>

            <button class="btn btn-primary w-100">
                Simpan Password Baru
            </button>
        </div>

        <!-- BACK -->
        <div class="text-center small mt-3">
            <a href="/login">Kembali ke Login</a>
        </div>

    </div>
</div>

<script>
function goToOTP() {
    document.getElementById('step-email').style.display = 'none';
    document.getElementById('step-otp').style.display = 'block';
}

function goToPassword() {
    document.getElementById('step-otp').style.display = 'none';
    document.getElementById('step-password').style.display = 'block';
}

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
