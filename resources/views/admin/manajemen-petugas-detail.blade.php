@extends('admin.layout')

@section('title', 'Detail Petugas')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <h4 class="fw-semibold mb-4">Detail Petugas</h4>

        <div class="mx-auto rounded-5 p-5"
             style="max-width:520px; background:#7fc4da;">

            <div class="mb-4">
                <label class="form-label fw-semibold">Nama Petugas</label>
                <input type="text" class="form-control rounded-3" value="Usamba" readonly>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Nomor Telepon</label>
                <input type="text" class="form-control rounded-3" value="08516879888" readonly>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Cabang</label>
                <input type="text" class="form-control rounded-3" value="Medan" readonly>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Kategori</label>
                <input type="text" class="form-control rounded-3" value="Bencana Alam" readonly>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Alamat</label>
                <textarea class="form-control rounded-3" rows="3" readonly>
Stabat, Langkat, Medan, Sumatera Utara
                </textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Barang Yang Diberi</label>
                <textarea class="form-control rounded-3" rows="3" readonly>
Roti 40 bungkus, air minum 40 dus, beras 40 karung,
minyak 40 bungkus, telur 200 pcs, mie instan 240 pcs
                </textarea>
            </div>

            <div class="text-center mt-4">
                <a href="{{ url('/admin/manajemen-petugas') }}"
                   class="btn btn-light rounded-pill px-5">
                    Kembali
                </a>
            </div>

        </div>

    </div>
</main>
@endsection
