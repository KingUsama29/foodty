<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodTY</title>

    <!-- BOOTSTRAP ONLY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('gambar/logo_foodty.png') }}" alt="FoodTY" height="90">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <div class="ms-auto d-flex gap-2">
                <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#tentangKamiModal">
                    Tentang Kami
                </button>
                <a href="/login" class="btn btn-warning text-white">
                    Masuk
                </a>
            </div>
        </div>
    </div>
</nav>
