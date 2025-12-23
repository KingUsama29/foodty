<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pengajuan | FoodTY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/css/penerima_dashboard.css', 'resources/js/app.js'])
</head>
<body>

<!-- ================= HEADER ================= -->
<nav class="navbar navbar-light bg-light shadow-sm sticky-top">
    <div class="container d-flex justify-content-between align-items-center">

        <img src="{{ asset('img/logofoodty.png') }}" height="45">

        <!-- ================= KEMBALI ================= -->
        <a href="/dashboard_penerima"
            class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Kembali
        </a>

    </div>
</nav>

<!-- ================= RIWAYAT ================= -->
<main class="dashboard-penerima py-4">
    <div class="container">

        <h5 class="fw-bold mb-4">Riwayat Pengajuan</h5>

        <div class="card card-alur mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-semibold mb-0">
                        Bantuan Sembako Lansia
                    </h6>

                    <span class="badge bg-warning text-dark">
                        Menunggu Verifikasi
                    </span>
                </div>

                <div class="row small mb-3">
                    <div class="col-md-6 mb-2">
                        <strong>Nama</strong><br>
                        Siti Aminah
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>No. Telepon</strong><br>
                        081234567890
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>NIK</strong><br>
                        3404xxxxxxxxxxxx
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Kategori</strong><br>
                        Lansia
                    </div>

                    <div class="col-12 mb-2">
                        <strong>Alamat</strong><br>
                        Jl. Magelang No. 123, Sleman, Yogyakarta
                    </div>

                    <div class="col-12">
                        <strong>Deskripsi</strong><br>
                        Membutuhkan bantuan sembako karena tinggal sendiri.
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4 text-center">
                        <strong class="small">Foto KTP</strong>
                        <img src="{{ asset('img/logofoodty.png') }}"
                             class="img-fluid rounded mt-1">
                    </div>

                    <div class="col-md-4 text-center">
                        <strong class="small ">Selfie + KTP</strong>
                        <img src="{{ asset('img/logofoodty.png') }}"
                             class="img-fluid rounded mt-1">
                    </div>

                    <div class="col-md-4 text-center">
                        <strong class="small">Foto KK</strong>
                        <img src="{{ asset('img/logofoodty.png') }}"
                             class="img-fluid rounded mt-1">
                    </div>
                </div>

            </div>
        </div>

        <div class="text-center text-muted mt-5">
            <i class="fa-solid fa-folder-open fs-2 mb-2"></i>
            <p class="mb-0">Pengajuan lainnya akan muncul di sini</p>
        </div>

    </div>
</main>

<!-- ================= FOOTER ================= -->
<footer class="bg-secondary text-white py-3 mt-5">
    <div class="container text-center small">
        © {{ date('Y') }} FoodTY. All rights reserved.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
