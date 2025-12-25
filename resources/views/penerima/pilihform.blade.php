@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU FORM ================= --}}
@section('sidebar-menu')

    {{-- DASHBOARD --}}
    <a href="{{ route('penerima.dashboard') }}"
       class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i>
        Dashboard
    </a>

    {{-- FORM (HALAMAN INI) --}}
    <a href="{{ route('form.pilih') }}"
       class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-file-pen fa-fw me-3"></i>
        Pengajuan Bantuan
    </a>

    {{-- RIWAYAT --}}
    <a href="{{ route('penerima.riwayat') }}"
       class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-clock-rotate-left fa-fw me-3"></i>
        Riwayat
    </a>

@endsection


@section('content')

{{-- ================= HEADER ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center gap-2">
        <i class="fa-solid fa-file-pen fa-lg text-primary"></i>
        <div>
            <h5 class="mb-1">Form Pengajuan Bantuan</h5>
            <small class="text-muted">Lengkapi data sesuai ketentuan</small>
        </div>
    </div>
</div>

{{-- ================= FORM ================= --}}
<div class="card shadow-lg border-0 w-100" style="border-radius:28px;">
    <div class="card-body p-4 p-md-5">

        <form method="POST" action="/pengajuan" enctype="multipart/form-data" class="row g-3">
            @csrf

            {{-- INPUT DATA --}}
            <div class="col-12 col-md-6">
                <input type="text" class="form-control rounded-pill shadow-sm"
                       placeholder="Nama (sesuai KTP)">
            </div>

            <div class="col-12 col-md-6">
                <input type="tel" class="form-control rounded-pill shadow-sm"
                       placeholder="No Telepon Aktif">
            </div>

            <div class="col-12 col-md-6">
                <input type="text" class="form-control rounded-pill shadow-sm"
                       placeholder="NIK">
            </div>

            <div class="col-12 col-md-6">
                <select class="form-select rounded-pill shadow-sm">
                    <option>Pilih Salah Satu</option>
                    <option>Lansia</option>
                    <option>Ibu Bayi / Balita</option>
                    <option>Bencana Alam</option>
                    <option>Kehilangan Pekerjaan</option>
                    <option>Yatim Piatu</option>
                    <option>Tunawisma</option>
                </select>
            </div>

            <div class="col-12">
                <textarea class="form-control rounded-4 shadow-sm"
                          rows="3"
                          placeholder="Alamat"></textarea>
            </div>

            <div class="col-12">
                <textarea class="form-control rounded-4 shadow-sm"
                          rows="3"
                          placeholder="Deskripsi (Opsional)"></textarea>
            </div>

            {{-- TOMBOL AJUKAN --}}
            <div class="col-12">
                <button type="submit"
                        class="btn btn-primary w-100 rounded-pill fw-semibold py-2">
                    Ajukan
                </button>
            </div>

            <div class="col-12">
                <hr class="my-4">
            </div>

            {{-- FOTO KTP --}}
            <div class="col-12 col-md-4 text-center">
                <label class="form-label fw-semibold">Foto KTP</label>
                <input type="file" class="form-control" accept="image/*"
                       onchange="previewImage(this, 'previewKtp')">
                <img id="previewKtp"
                     class="img-fluid rounded shadow-sm mt-2 d-none"
                     style="max-height:180px;">
            </div>

            {{-- SELFIE + KTP --}}
            <div class="col-12 col-md-4 text-center">
                <label class="form-label fw-semibold">Selfie + KTP</label>
                <input type="file" class="form-control" accept="image/*"
                       onchange="previewImage(this, 'previewSelfie')">
                <img id="previewSelfie"
                     class="img-fluid rounded shadow-sm mt-2 d-none"
                     style="max-height:180px;">
            </div>

            {{-- KK --}}
            <div class="col-12 col-md-4 text-center">
                <label class="form-label fw-semibold">Kartu Keluarga (KK)</label>
                <input type="file" class="form-control" accept="image/*"
                       onchange="previewImage(this, 'previewKk')">
                <img id="previewKk"
                     class="img-fluid rounded shadow-sm mt-2 d-none"
                     style="max-height:180px;">
            </div>

        </form>

    </div>
</div>

{{-- ================= JS PREVIEW ================= --}}
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
