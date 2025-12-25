@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU PENERIMA ================= --}}
@section('sidebar-menu')
    <a href="{{ route('penerima.dashboard') }}"
       class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i>
        Dashboard
    </a>

<a href="#"
   class="list-group-item list-group-item-action disabled d-flex align-items-center">
    <i class="fa-solid fa-id-card fa-fw me-3"></i>
    Verifikasi Data
    <span class="badge bg-secondary ms-auto">dody</span>
</a>

    <a href="{{ route('penerima.riwayat') }}"
       class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-clock-rotate-left fa-fw me-3"></i>
        Riwayat
    </a>
@endsection


{{-- ================= KONTEN RIWAYAT ================= --}}
@section('content')

{{-- HEADER HALAMAN --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center">
        <i class="fa-solid fa-clock-rotate-left fa-lg text-primary me-3"></i>
        <div>
            <h5 class="mb-1">Riwayat Pengajuan</h5>
            <small class="text-muted">
                Daftar pengajuan bantuan yang pernah Anda ajukan
            </small>
        </div>
    </div>
</div>


{{-- ================= LIST RIWAYAT ================= --}}
<div class="row g-4">

    <div class="col-12">
        <div class="card shadow-sm">

            {{-- HEADER STATUS --}}
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Status Pengajuan</span>
                <span class="badge bg-warning text-dark px-3 py-2">
                    Proses
                </span>
            </div>

            <div class="card-body">

                {{-- ================= DATA UTAMA ================= --}}
                <div class="row gy-3 mb-4">

                    <div class="col-md-6">
                        <strong>Nama Penerima</strong>
                        <div class="text-muted">Rizman</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Kategori Bantuan</strong>
                        <div class="text-muted">Kehilangan Pekerjaan</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Nomor Telepon</strong>
                        <div class="text-muted">08123456789</div>
                    </div>

                    <div class="col-md-6">
                        <strong>NIK</strong>
                        <div class="text-muted">3210xxxxxxxxxxxx</div>
                    </div>

                    <div class="col-12">
                        <strong>Alamat</strong>
                        <div class="text-muted">
                            Stabat, Langkat, Medan, Sumatera Utara
                        </div>
                    </div>

                    <div class="col-12">
                        <strong>Deskripsi Pengajuan</strong>
                        <div class="text-muted">
                            Kehilangan pekerjaan akibat penutupan tempat kerja dan
                            membutuhkan bantuan pangan untuk kebutuhan harian keluarga.
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                {{-- ================= DOKUMEN ================= --}}
                <h6 class="mb-3">Dokumen Pendukung</h6>

                <div class="row g-3">

                    {{-- FOTO KTP --}}
                    <div class="col-12 col-md-4">
                        <div class="card h-100">
                            <img src="{{ asset('gambar/balita.jpg') }}"
                                 class="card-img-top"
                                 alt="Foto KTP">
                            <div class="card-body text-center small fw-semibold">
                                Foto KTP
                            </div>
                        </div>
                    </div>

                    {{-- FOTO SELFIE + KTP --}}
                    <div class="col-12 col-md-4">
                        <div class="card h-100">
                            <img src="{{ asset('gambar/balita.jpg') }}"
                                 class="card-img-top"
                                 alt="Foto Selfie + KTP">
                            <div class="card-body text-center small fw-semibold">
                                Foto Selfie + KTP
                            </div>
                        </div>
                    </div>

                    {{-- FOTO KK --}}
                    <div class="col-12 col-md-4">
                        <div class="card h-100">
                            <img src="{{ asset('gambar/balita.jpg') }}"
                                 class="card-img-top"
                                 alt="Foto KK">
                            <div class="card-body text-center small fw-semibold">
                                Foto Kartu Keluarga
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

@endsection
