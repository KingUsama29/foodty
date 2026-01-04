@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU ADMIN ================= --}}
@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i>
        Dashboard
    </a>

    <a href="{{ route('admin.pengajuan') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-file-circle-check fa-fw me-3"></i>
        Ajuan Bantuan
    </a>

    <a href="{{ route('admin.petugas') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-users-gear fa-fw me-3"></i>
        Data Petugas
    </a>

    <a href="{{ route('admin.cabang') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-location-dot fa-fw me-3"></i>
        Cabang Lokasi
    </a>

    <a href="{{ route('admin.stok-barang') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-fw me-3"></i>
        Stok Barang
    </a>

    <a href="{{ route('admin.penyaluran') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-fw me-3"></i>
        Hasil Penyaluran
    </a>
@endsection


{{-- ================= KONTEN DASHBOARD ADMIN ================= --}}
@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fa-solid fa-house fa-lg text-primary me-3"></i>
            <div>
                <h5 class="mb-1">Dashboard Admin</h5>
                <small class="text-muted">
                    Ringkasan pengelolaan bantuan pangan FoodTY
                </small>
            </div>
        </div>
    </div>


    <div class="row g-3">

        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-file-circle-check fa-2x text-primary mb-3"></i>
                    <h6>Ajuan Bantuan</h6>
                    <p class="small text-muted">
                        Kelola pengajuan bantuan dari penerima.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-users-gear fa-2x text-primary mb-3"></i>
                    <h6>Data Petugas</h6>
                    <p class="small text-muted">
                        Kelola data petugas penyaluran.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-location-dot fa-2x text-primary mb-3"></i>
                    <h6>Cabang Lokasi</h6>
                    <p class="small text-muted">
                        Kelola lokasi cabang bantuan.
                    </p>
                </div>
            </div>
        </div>

    </div>
@endsection
