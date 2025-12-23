<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pengajuan | FoodTY</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #cfe4dc;
        }

        /* CARD FORM */
        .form-card {
            background-color: #6fbad6;
            border-radius: 25px;
            max-height: 85vh;
            overflow-y: auto;
        }

        /* CUSTOM SCROLL */
        .form-card::-webkit-scrollbar {
            width: 6px;
        }
        .form-card::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,.3);
            border-radius: 10px;
        }

        .btn-submit {
            background-color: #f4c27a;
            font-weight: 600;
        }

        .preview-img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 10px;
            display: none;
            margin-top: 8px;
        }
    </style>
</head>
<body>

<!-- ================= HEADER ================= -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">FoodTY</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <div class="ms-auto d-flex gap-2 mt-3 mt-lg-0">
                <a href="#" class="btn btn-outline-warning">Tentang Kami</a>
                <a href="/login" class="btn btn-warning text-white">Masuk</a>
            </div>
        </div>
    </div>
</nav>

<!-- ================= FORM ================= -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 col-12">

            <div class="card shadow border-0 form-card">
                <div class="card-body p-4">

                    <h5 class="text-center fw-bold mb-4">
                        Form Pengajuan Bantuan
                    </h5>

                    <form method="POST" action="#" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <input type="text" class="form-control rounded-3"
                                   placeholder="Nama (sesuai KTP)" required>
                        </div>

                        <div class="mb-3">
                            <input type="tel" class="form-control rounded-3"
                                   placeholder="No Telepon Aktif" required>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control rounded-3"
                                   placeholder="NIK" maxlength="16" required>
                        </div>

                        <!-- KATEGORI -->
                        <div class="mb-3">
                            <select class="form-select rounded-3" required>
                                <option value="">Pilih Kategori Penerima</option>
                                <option>Bencana Alam</option>
                                <option>Kehilangan Pekerjaan</option>
                                <option>Yatim Piatu</option>
                                <option>Tunawisma</option>
                                <option>Lansia</option>
                                <option>Ibu Bayi / Balita</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <textarea class="form-control rounded-3"
                                      rows="3"
                                      placeholder="Alamat" required></textarea>
                        </div>

                        <!-- UPLOAD KTP -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto KTP</label>
                            <input type="file" class="form-control"
                                   accept="image/*"
                                   onchange="previewImage(this,'ktpPreview')" required>
                            <img id="ktpPreview" class="preview-img">
                        </div>

                        <!-- SELFIE KTP -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Selfie + KTP</label>
                            <input type="file" class="form-control"
                                   accept="image/*"
                                   onchange="previewImage(this,'selfiePreview')" required>
                            <img id="selfiePreview" class="preview-img">
                        </div>

                        <!-- KK -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kartu Keluarga</label>
                            <input type="file" class="form-control"
                                   accept="image/*"
                                   onchange="previewImage(this,'kkPreview')" required>
                            <img id="kkPreview" class="preview-img">
                        </div>

                        <div class="mb-4">
                            <textarea class="form-control rounded-3"
                                      rows="3"
                                      placeholder="Deskripsi (Opsional)"></textarea>
                        </div>

                        <button type="submit"
                                class="btn btn-submit w-100 rounded-pill">
                            Ajukan
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- ================= FOOTER ================= -->
<footer class="bg-secondary text-white pt-5 pb-4 mt-5">
    <div class="container text-center small">
        © 2025 FoodTY. All rights reserved.
    </div>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>

</body>
</html>
