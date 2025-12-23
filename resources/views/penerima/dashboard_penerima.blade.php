<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Penerima | FoodTY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/css/penerima_dashboard.css', 'resources/js/app.js'])
</head>
<body>

@php
    $isVerified = false; // dummy
@endphp

<!-- ================= HEADER ================= -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('gambar/logo_foodty.png') }}" height="55">
        </a>
    </div>
</nav>

<!-- ================= DASHBOARD ================= -->
<main class="dashboard-penerima py-4">
    <div class="container">

        <!-- CARD SAMBUTAN -->
        <div class="card card-sambutan mb-4">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="avatar">👤</div>
                <div>
                    <h6 class="mb-0 fw-semibold">Selamat Datang [user]</h6>
                    <small class="text-muted">Penerima</small>
                </div>
            </div>
        </div>

        <!-- ALUR AJUKAN -->
        <h6 class="fw-semibold mb-3">Alur Ajukan Bantuan</h6>

        <div class="d-flex flex-column gap-3 mb-4 alur-wrapper">

            <div class="card card-alur alur-item">
                <div class="card-body d-flex gap-3">
                    <div class="alur-icon">🔘</div>
                    <div>
                        <p class="mb-1 fw-semibold">Klik tombol Ajukan</p>
                        <small>Mulai pengajuan bantuan pangan.</small>
                    </div>
                </div>
            </div>

            <div class="card card-alur alur-item">
                <div class="card-body d-flex gap-3">
                    <div class="alur-icon">📝</div>
                    <div>
                        <p class="mb-1 fw-semibold">Isi Formulir</p>
                        <small>Lengkapi data sesuai kondisi.</small>
                    </div>
                </div>
            </div>

            <div class="card card-alur alur-item">
                <div class="card-body d-flex gap-3">
                    <div class="alur-icon">⏳</div>
                    <div>
                        <p class="mb-1 fw-semibold">Menunggu Verifikasi</p>
                        <small>Petugas akan memverifikasi pengajuan.</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- ACTION BUTTON -->
        <div class="d-flex gap-3">
            <a href="/penerima/riwayat_penerima"
               class="btn btn-light flex-fill rounded-pill fw-semibold">
                Riwayat
            </a>

            @if($isVerified)
                <button class="btn btn-warning flex-fill rounded-pill fw-semibold">
                    Ajukan
                </button>
            @else
                <button class="btn btn-warning flex-fill rounded-pill fw-semibold">
                    Verifikasi
                </button>
            @endif
        </div>

    </div>
</main>

<!-- ================= FOOTER ================= -->
<footer class="bg-secondary text-white pt-4 pb-3 mt-5">
    <div class="container text-center small">
        © {{ date('Y') }} FoodTY. All rights reserved.
    </div>
</footer>

<!-- ================= ANIMATION SCRIPT ================= -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.alur-item');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                entry.target.style.transitionDelay = `${index * 150}ms`;
                entry.target.classList.add('show');
            }
        });
    }, { threshold: 0.2 });

    items.forEach(item => observer.observe(item));
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
