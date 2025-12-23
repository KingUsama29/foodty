@extends('admin.layout')

@section('title', 'Form Penyaluran')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <h4 class="fw-semibold mb-4">Isi Formulir Penyaluran Barang</h4>

        <div class="mx-auto rounded-5 p-5"
             style="max-width:560px; background:#7fc4da;">

            <!-- NAMA PENGAJU -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Pengaju</label>
                <input type="text" class="form-control rounded-3"
                       value="Rizman">
            </div>

            <!-- NO TELEPON -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor Telepon</label>
                <input type="text" class="form-control rounded-3"
                       value="08516879788">
            </div>

            <!-- NIK -->
            <div class="mb-3">
                <label class="form-label fw-semibold">NIK</label>
                <input type="text" class="form-control rounded-3"
                       value="3308190123456789">
            </div>

            <!-- KATEGORI -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <input type="text" class="form-control rounded-3"
                       value="Bencana Alam">
            </div>

            <!-- ALAMAT -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat</label>
                <textarea class="form-control rounded-3" rows="3">
Stabat, Langkat, Medan, Sumatera Utara
                </textarea>
            </div>

            <!-- BARANG -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Barang Yang Diberikan</label>
                <textarea class="form-control rounded-3" rows="3">
Beras 10kg, Minyak 5L, Air Minum 1 Kotak
                </textarea>
            </div>

            <!-- AKSI -->
            <div class="text-center">
                <a href="{{ url('/admin/salurkan/ringkasan') }}"
                   class="btn btn-warning rounded-pill px-5">
                    Kirim
                </a>
            </div>

        </div>

    </div>
</main>
@endsection
