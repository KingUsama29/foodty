@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU PETUGAS ================= --}}
@section('sidebar-menu')
    <a href="#" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i>
        Dashboard
    </a>

    <a href="{{ route('petugas.data-penerima') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-list-check fa-fw me-3"></i>
        Data Penerima
    </a>

    <a href="{{ route('petugas.data-donasi') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-list-check fa-fw me-3"></i>
        Data Donasi
    </a>

    <a href="{{ route('petugas.profil-petugas') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-id-badge fa-fw me-3"></i>
        Profil Petugas
    </a>
@endsection


{{-- ================= KONTEN DASHBOARD PETUGAS ================= --}}
@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fa-solid fa-house fa-lg text-primary me-3"></i>
            <div>
                <h5 class="mb-1">Dashboard Petugas</h5>
                <small class="text-muted">
                    Kelola dan verifikasi pengajuan bantuan dari masyarakat
                </small>
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- DAFTAR TUGAS --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-list-check fa-2x text-primary mb-3"></i>
                    <h6>Daftar Tugas</h6>
                    <p class="small text-muted">
                        Daftar tugas penyaluran dan verifikasi bantuan yang harus dikerjakan.
                    </p>
                </div>
            </div>
        </div>

        {{-- RIWAYAT TUGAS --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-clock-rotate-left fa-2x text-primary mb-3"></i>
                    <h6>Riwayat Tugas</h6>
                    <p class="small text-muted">
                        Riwayat tugas yang telah diselesaikan oleh petugas.
                    </p>
                </div>
            </div>
        </div>

        {{-- PROFIL PETUGAS --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-id-badge fa-2x text-primary mb-3"></i>
                    <h6>Profil Petugas</h6>
                    <p class="small text-muted">
                        Informasi data petugas seperti cabang, nomor telepon, dan detail lainnya.
                    </p>
                </div>
            </div>
        </div>

    </div>
@endsection
