<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        html, body {
            height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f6f8f7;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1; /* INI KUNCI */
        }

        .admin-header {
            background: #7fc4da;
        }

        .admin-footer {
            background: #6f777c;
            color: #ffffff;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="admin-header py-3">
    <div class="container-fluid px-5 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold text-dark">FoodTY</h5>
        <span class="badge bg-danger px-3 py-2">Admin</span>
    </div>
</header>

<!-- CONTENT (WAJIB dibungkus main) -->
<main>
    @yield('content')
</main>

<!-- FOOTER (NEMPEL BAWAH) -->
<footer class="admin-footer pt-4 pb-3">
    <div class="container-fluid px-5">
        <div class="row">

            <div class="col-md-4 mb-3">
                <h6 class="fw-semibold">FoodTY</h6>
                <p class="small mb-0">
                    Platform digital penyaluran bantuan pangan yang transparan,
                    terstruktur, dan tepat sasaran.
                </p>
            </div>

            <div class="col-md-4 mb-3">
                <h6 class="fw-semibold">Navigasi</h6>
                <ul class="list-unstyled small mb-0">
                    <li>Beranda</li>
                    <li>Masuk</li>
                    <li>Tentang Kami</li>
                </ul>
            </div>

            <div class="col-md-4 mb-3">
                <h6 class="fw-semibold">Hubungi Kami</h6>
                <ul class="list-unstyled small mb-0">
                    <li>Mojomerto, Yogyakarta</li>
                    <li>+62 831-2156-2697</li>
                    <li>info@foodty.id</li>
                </ul>
            </div>

        </div>

        <hr class="border-light my-3">

        <div class="text-center small">
            © {{ date('Y') }} FoodTY. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
