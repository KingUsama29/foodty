@include('partials.headerPublik')

<!-- ================= HERO ================= -->
<section class="hero-wrap position-relative"
    style="
        background-image: url('{{ asset('gambar/orang_memberi_makanan.png') }}');
        background-size: cover;
        background-position: 50% 70%;
        height: 550px;
        width: 100%;
    ">
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="container h-100 d-flex align-items-center">
        <div class="col-lg-6 reveal">
            <h1 class="fw-bold display-2 mb-3 hero-title">
                Platform Digital<br>
                Penyaluran Bantuan Pangan
            </h1>

            <p class="lead mb-3">
                FoodTY membantu proses pendataan, verifikasi, pengelolaan donasi, dan penyaluran bantuan
                agar lebih cepat, rapi, dan tepat sasaran.
            </p>

            <div class="d-flex flex-wrap gap-2 mt-3">
                <a href="/login" class="btn btn-warning text-white btn-anim px-4">
                    Mulai Sekarang
                </a>
                <button type="button" class="btn btn-outline-dark btn-anim px-4" data-bs-toggle="modal"
                    data-bs-target="#tentangKamiModal">
                    Pelajari
                </button>
            </div>

            <div class="d-flex flex-wrap gap-3 mt-4 text-muted small">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-shield-halved"></i> Data lebih terstruktur
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-check"></i> Verifikasi penerima
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-bolt"></i> Proses lebih cepat
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= STATISTIK (PENDUKUNG) ================= -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 reveal">
                <div class="p-4 rounded-4 border bg-white shadow-sm h-100">
                    <div class="display-6 fw-bold text-warning">24+</div>
                    <div class="text-muted">Program Aktif</div>
                </div>
            </div>
            <div class="col-md-3 reveal">
                <div class="p-4 rounded-4 border bg-white shadow-sm h-100">
                    <div class="display-6 fw-bold text-warning">1.2K+</div>
                    <div class="text-muted">Penerima Terdata</div>
                </div>
            </div>
            <div class="col-md-3 reveal">
                <div class="p-4 rounded-4 border bg-white shadow-sm h-100">
                    <div class="display-6 fw-bold text-warning">350+</div>
                    <div class="text-muted">Donasi Tercatat</div>
                </div>
            </div>
            <div class="col-md-3 reveal">
                <div class="p-4 rounded-4 border bg-white shadow-sm h-100">
                    <div class="display-6 fw-bold text-warning">100%</div>
                    <div class="text-muted">Terpantau Sistem</div>
                </div>
            </div>
        </div>

        <div class="d-flex border border-secondary opacity-25 mt-5 w-50 mx-auto"></div>
    </div>
    </div>
</section>

<!-- ================= CARA KERJA ================= -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <h4 class="fw-bold mb-2">Cara Kerja FoodTY</h4>
            <p class="text-muted mb-0">Alur sederhana, jelas, dan terdokumentasi.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6 reveal">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge text-bg-warning rounded-pill px-3 py-2">1</span>
                        <h6 class="fw-bold mb-0">Pendataan</h6>
                    </div>
                    <p class="text-muted small mb-0">Penerima mengisi data kebutuhan & kondisi.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 reveal">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge text-bg-warning rounded-pill px-3 py-2">2</span>
                        <h6 class="fw-bold mb-0">Verifikasi</h6>
                    </div>
                    <p class="text-muted small mb-0">Petugas mengecek kelayakan penerima secara sistematis.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 reveal">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge text-bg-warning rounded-pill px-3 py-2">3</span>
                        <h6 class="fw-bold mb-0">Pengelolaan Donasi</h6>
                    </div>
                    <p class="text-muted small mb-0">Donasi dicatat, dikelompokkan, dan siap disalurkan.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 reveal">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge text-bg-warning rounded-pill px-3 py-2">4</span>
                        <h6 class="fw-bold mb-0">Penyaluran</h6>
                    </div>
                    <p class="text-muted small mb-0">Distribusi tercatat dan dapat dipantau perkembangannya.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= PROGRAM ================= -->
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 reveal">
            <h4 class="fw-bold mb-0">Program Bantuan Pangan Terbaru</h4>
            <span class="badge text-bg-warning text-white px-3 py-2">Update Program</span>
        </div>

        <div class="row g-4">

            <div class="col-lg-4 col-md-6 reveal">
                <div class="card h-100 shadow-sm card-anim">
                    <img src="{{ asset('gambar/warga_banjir.jpeg') }}" class="card-img-top program-img"
                        alt="Bantuan Banjir">
                    <div class="card-body">
                        <p class="fw-semibold mb-1">Bantuan Pangan untuk Korban Banjir</p>
                        <p class="text-muted small mb-0">Distribusi bantuan untuk wilayah terdampak banjir.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 reveal">
                <div class="card h-100 shadow-sm card-anim">
                    <img src="{{ asset('gambar/lansia.jpg') }}" class="card-img-top program-img" alt="Bantuan Lansia">
                    <div class="card-body">
                        <p class="fw-semibold mb-1">Bantuan Sembako untuk Lansia</p>
                        <p class="text-muted small mb-0">Paket sembako untuk mendukung kebutuhan lansia.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 reveal">
                <div class="card h-100 shadow-sm card-anim">
                    <img src="{{ asset('gambar/balita.jpg') }}" class="card-img-top program-img" alt="Bantuan Balita">
                    <div class="card-body">
                        <p class="fw-semibold mb-1">Bantuan untuk Ibu Bayi & Balita</p>
                        <p class="text-muted small mb-0">Dukungan pangan dan nutrisi untuk keluarga rentan.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= KENAPA FOODTY ================= -->
<section class="bg-light py-5">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <h4 class="fw-bold mb-2">Kenapa FoodTY?</h4>
            <p class="text-muted mb-0">Lebih terstruktur, transparan, dan tepat sasaran.</p>
        </div>

        <div class="row text-center g-4">

            <div class="col-lg-4 reveal">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <img src="{{ asset('gambar/Tepat_sasaran.png') }}" height="140" class="feature-anim"
                        alt="Tepat Sasaran">
                    <p class="fw-semibold mt-3 mb-1">Tepat Sasaran</p>
                    <p class="text-muted small mb-0">Penerima melalui proses pendataan & verifikasi.</p>
                </div>
            </div>

            <div class="col-lg-4 reveal">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <img src="{{ asset('gambar/transparan.png') }}" height="140" class="feature-anim"
                        alt="Transparan">
                    <p class="fw-semibold mt-3 mb-1">Transparan</p>
                    <p class="text-muted small mb-0">Alur tercatat sehingga dapat dipantau dengan jelas.</p>
                </div>
            </div>

            <div class="col-lg-4 reveal">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <img src="{{ asset('gambar/berbasis_digital.png') }}" height="140" class="feature-anim"
                        alt="Berbasis Digital">
                    <p class="fw-semibold mt-3 mb-1">Berbasis Digital</p>
                    <p class="text-muted small mb-0">Pengelolaan data lebih cepat, rapi, dan terintegrasi.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= TESTIMONI (PENDUKUNG) ================= -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <h4 class="fw-bold mb-2">Apa Kata Mereka?</h4>
            <p class="text-muted mb-0">Contoh testimoni untuk membuat landing page terasa “ramai”.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 reveal">
                <div class="p-4 rounded-4 border bg-white shadow-sm h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center"
                            style="width:44px;height:44px;">
                            <i class="fa-solid fa-user text-warning"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Donatur</div>
                            <div class="text-muted small">Lebih jelas alurnya</div>
                        </div>
                    </div>
                    <p class="text-muted mb-0">“Saya suka karena prosesnya tercatat, jadi lebih yakin bantuan
                        tersalur.”</p>
                </div>
            </div>

            <div class="col-lg-4 reveal">
                <div class="p-4 rounded-4 border bg-white shadow-sm h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                            style="width:44px;height:44px;">
                            <i class="fa-solid fa-user-shield text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Petugas</div>
                            <div class="text-muted small">Data lebih terkendali</div>
                        </div>
                    </div>
                    <p class="text-muted mb-0">“Semua data donasi kami salurkan dengan penuh tanggung jawab.”</p>
                </div>
            </div>

            <div class="col-lg-4 reveal">
                <div class="p-4 rounded-4 border bg-white shadow-sm h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center"
                            style="width:44px;height:44px;">
                            <i class="fa-solid fa-hand-holding-heart text-success"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Penerima</div>
                            <div class="text-muted small">Lebih cepat</div>
                        </div>
                    </div>
                    <p class="text-muted mb-0">“Proses pengajuan jelas dan saya bisa tahu statusnya.”</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= FAQ (PENDUKUNG) ================= -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4 reveal">
            <h4 class="fw-bold mb-2">FAQ</h4>
            <p class="text-muted mb-0">Pertanyaan yang sering ditanyakan.</p>
        </div>

        <div class="accordion reveal" id="faqAcc">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq1">
                        Apakah penerima bantuan harus diverifikasi?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAcc">
                    <div class="accordion-body text-muted">
                        Iya. FoodTY memprioritaskan penyaluran tepat sasaran melalui proses pendataan dan verifikasi
                        oleh petugas.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq2">
                        Bagaimana alur penyalurannya?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                    <div class="accordion-body text-muted">
                        Data masuk → diverifikasi → donasi dikelola → penyaluran dicatat dan dipantau.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq3">
                        Apakah data tersimpan aman?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                    <div class="accordion-body text-muted">
                        Sistem dirancang agar data lebih terstruktur dan aksesnya sesuai peran (admin/petugas/penerima).
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA ================= -->
<section class="py-5">
    <div class="container">
        <div class="p-5 rounded-4 text-white shadow-sm reveal"
            style="background: linear-gradient(135deg, #ffb703 0%, #fb8500 45%, #023047 100%);">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h4 class="fw-bold mb-2">Siap bantu sesama lewat FoodTY?</h4>
                    <p class="mb-0" style="opacity:.9;">
                        Masuk sekarang untuk mulai proses pendataan, verifikasi, dan pengelolaan penyaluran bantuan
                        pangan.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="/login" class="btn btn-light btn-anim px-4 py-2 fw-semibold">
                        Masuk & Mulai
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.footerPublik')
@include('partials.tentangKami')
