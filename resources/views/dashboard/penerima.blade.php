@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU PENERIMA ================= --}}
@section('sidebar-menu')
    <a href="{{ route('penerima.dashboard') }}"
       class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i>
        Dashboard
    </a>

    <a href="{{ route('form.pilih') }}"
       class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-id-card fa-fw me-3"></i>
        Verifikasi Data
    </a>

    <a href="{{ route('penerima.riwayat') }}"
       class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-clock-rotate-left fa-fw me-3"></i>
        Riwayat
    </a>
@endsection


{{-- ================= KONTEN DASHBOARD PENERIMA ================= --}}
@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fa-solid fa-house fa-lg text-primary me-3"></i>
            <div>
                <h5 class="mb-1">Dashboard Penerima</h5>
                <small class="text-muted">
                    Ringkasan status pengajuan bantuan pangan
                </small>
            </div>
        </div>
    </div>


    <div class="row g-3">

        {{-- VERIFIKASI --}}
        <div class="col-12 col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="fa-solid fa-id-card fa-2x text-primary mb-3"></i>
                    <h6>Verifikasi Data Diri</h6>
                    <p class="small text-muted">
                        Lengkapi verifikasi data diri seperti foto KTP dan data pendukung lainnya.
                    </p>
                    <a href="{{ route('form.pilih') }}"
                       class="btn btn-primary mt-2">
                        Verifikasi Sekarang
                    </a>
                </div>
            </div>
        </div>

        
        {{-- RIWAYAT --}}
        <div class="col-12 col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="fa-solid fa-clock-rotate-left fa-2x text-primary mb-3"></i>
                    <h6>Riwayat Pengajuan</h6>
                    <p class="small text-muted">
                        Lihat riwayat pengajuan dan status bantuan yang pernah diajukan.
                    </p>
                        <a href="{{ route('penerima.riwayat') }}"
                            class="btn btn-outline-primary mt-2">
                            Lihat Riwayat
                        </a>
                </div>
            </div>
        </div>

    </div>
@endsection
