<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password | FoodTY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/auth.css'])
</head>
<body>

<div class="login-page d-flex align-items-center justify-content-center">
    <div class="login-panel w-100 text-center">

        <!-- HEADER -->
        <div class="login-header mb-3">
            <img src="{{ asset('img/logofoodty.png') }}" class="login-logo" alt="FoodTY">
            <h2 class="app-title mb-0">FoodTY</h2>
        </div>

        <div class="login-card mx-auto">

            <!-- ================= STEP 1: EMAIL ================= -->
            <div id="step-email">
                <p class="mb-4" style="font-size:14px;">
                    Masukkan email yang terdaftar untuk menerima kode OTP.
                </p>

                <div class="mb-4">
                    <input
                        type="email"
                        class="form-control login-input"
                        placeholder="Email Terdaftar"
                    >
                </div>

                <!-- 🔴 BACKEND NANTI: kirim OTP -->
                <button
                    type="button"
                    class="btn login-btn w-100"
                    onclick="goToOTP()"
                >
                    Kirim Kode OTP
                </button>
            </div>

            <!-- ================= STEP 2: OTP ================= -->
            <div id="step-otp" style="display:none;">
                <p class="mb-4" style="font-size:14px;">
                    Masukkan kode OTP yang dikirim ke email Anda.
                </p>

                <div class="mb-4">
                    <input
                        type="text"
                        class="form-control login-input text-center"
                        placeholder="Kode OTP"
                    >
                </div>

                <!-- 🔴 BACKEND NANTI: verifikasi OTP -->
                <button
                    type="button"
                    class="btn login-btn w-100"
                    onclick="goToPassword()"
                >
                    Verifikasi OTP
                </button>
            </div>

            <!-- ================= STEP 3: PASSWORD ================= -->
            <div id="step-password" style="display:none;">
                <p class="mb-4" style="font-size:14px;">
                    OTP valid. Silakan buat password baru.
                </p>

                <div class="mb-3">
                    <input
                        type="password"
                        class="form-control login-input"
                        placeholder="Password Baru"
                    >
                </div>

                <div class="mb-4">
                    <input
                        type="password"
                        class="form-control login-input"
                        placeholder="Konfirmasi Password"
                    >
                </div>

                <!-- 🔴 BACKEND NANTI: simpan password -->
                <button type="button" class="btn login-btn w-100">
                    Simpan Password Baru
                </button>
            </div>

            <p class="register-text text-center">
                <a href="/login">Kembali ke Login</a>
            </p>

        </div>
    </div>
</div>

<!-- ================= UI ONLY SCRIPT ================= -->
<script>
function goToOTP() {
    document.getElementById('step-email').style.display = 'none';
    document.getElementById('step-otp').style.display = 'block';
}

function goToPassword() {
    document.getElementById('step-otp').style.display = 'none';
    document.getElementById('step-password').style.display = 'block';
}
</script>

</body>
</html>
