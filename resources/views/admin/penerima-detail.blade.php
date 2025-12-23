@extends('admin.layout')

@section('title', 'Detail Pengajuan Penerima')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <h4 class="fw-semibold mb-4">Detail Pengajuan Bantuan</h4>

        <!-- CARD FORM -->
        <div class="mx-auto rounded-5 p-5"
             style="max-width:560px; background:#7fc4da;">

            <!-- NAMA -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama (sesuai KTP)</label>
                <input type="text" class="form-control rounded-3"
                       value="Rizman" readonly>
            </div>

            <!-- NO TELP -->
            <div class="mb-3">
                <label class="form-label fw-semibold">No Telepon Aktif</label>
                <input type="text" class="form-control rounded-3"
                       value="08516879788" readonly>
            </div>

            <!-- NIK -->
            <div class="mb-3">
                <label class="form-label fw-semibold">NIK</label>
                <input type="text" class="form-control rounded-3"
                       value="3308190123456789" readonly>
            </div>

            <!-- KATEGORI -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori Pengajuan</label>
                <input type="text" class="form-control rounded-3"
                       value="Ibu Bayi / Balita" readonly>
            </div>

            <!-- ALAMAT -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat</label>
                <textarea class="form-control rounded-3" rows="3" readonly>
Stabat, Langkat, Medan, Sumatera Utara
                </textarea>
            </div>

            <!-- FOTO KTP -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Foto KTP</label>
                <div class="bg-white rounded-3 p-3 text-center">
                    <img src="https://via.placeholder.com/300x180?text=Foto+KTP"
                         class="img-fluid rounded-3"
                         alt="Foto KTP">
                </div>
            </div>

            <!-- SELFIE + KTP -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Selfie + KTP</label>
                <div class="bg-white rounded-3 p-3 text-center">
                    <img src="https://via.placeholder.com/300x180?text=Selfie+%2B+KTP"
                         class="img-fluid rounded-3"
                         alt="Selfie KTP">
                </div>
            </div>

            <!-- KARTU KELUARGA -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Kartu Keluarga</label>
                <div class="bg-white rounded-3 p-3 text-center">
                    <img src="https://via.placeholder.com/300x180?text=Kartu+Keluarga"
                         class="img-fluid rounded-3"
                         alt="Kartu Keluarga">
                </div>
            </div>

            <!-- KETERANGAN -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea class="form-control rounded-3" rows="4" readonly>
Rumah terendam banjir selama 3 hari, tidak ada persediaan makanan,
membutuhkan bantuan segera untuk keluarga.
                </textarea>
            </div>

            <!-- KEMBALI -->
            <div class="text-center mt-4">
                <a href="{{ url('/admin/penerima') }}"
                   class="btn btn-light rounded-pill px-5">
                    Kembali
                </a>
            </div>

        </div>
    </div>
</main>
@endsection
