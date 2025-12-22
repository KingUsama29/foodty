@include('kelompok.headerPublik')

<!-- ================= HERO ================= -->
<section
    style="
        background-image: url('{{ asset('gambar/orang_memberi_makanan.png') }}');
        background-size: cover;
        background-position: 50% 70%;
        height: 600px;
        width: 100%;
    "
>
    <div class="container h-100 d-flex align-items-center">
        <div class="col-lg-6">
            <h1 class="fw-bold display-2 mb-3">
                Platform Digital<br>
                Penyaluran Bantuan Pangan
            </h1>

            <p class="lead mb-1">
                Ayo bersama membantu teman kita yang kelaparan dan jangan biarkan teman kita kelaparan, berbagi itu indah.
            </p>
        </div>
    </div>
</section>

<!-- ================= PROGRAM ================= -->
<section class="py-5">
    <div class="container">
        <h4 class="fw-bold mb-4">Program Bantuan Pangan Terbaru</h4>

        <div class="row g-4">

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('gambar/warga_banjir.jpeg') }}" class="card-img-top">
                    <div class="card-body">
                        <p class="fw-semibold mb-0">
                            Bantuan Pangan untuk Korban Banjir
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('gambar/lansia.jpg') }}" class="card-img-top">
                    <div class="card-body">
                        <p class="fw-semibold mb-0">
                            Bantuan Sembako untuk Lansia
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('gambar/balita.jpg') }}" class="card-img-top">
                    <div class="card-body">
                        <p class="fw-semibold mb-0">
                            Bantuan untuk Ibu Bayi & Balita
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= KENAPA FOODTY ================= -->
<section class="bg-light py-5">
    <div class="container">
        <h4 class="fw-bold mb-5">Kenapa FoodTY?</h4>

        <div class="row text-center">

            <div class="col-lg-4 mb-4">
                <img src="{{ asset('gambar/Tepat_sasaran.png') }}" height="150">
                <p class="fw-semibold">Tepat Sasaran</p>
            </div>

            <div class="col-lg-4 mb-4">
                <img src="{{ asset('gambar/transparan.png') }}" height="150">
                <p class="fw-semibold">Transparan</p>
            </div>

            <div class="col-lg-4 mb-4">
                <img src="{{ asset('gambar/berbasis_digital.png') }}" height="150">
                <p class="fw-semibold">Berbasis Digital</p>
            </div>

        </div>
    </div>
</section>

@include('kelompok.footerPublik')
@include('kelompok.tentangKami')