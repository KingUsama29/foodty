@extends('layouts.dashboard')

@section('sidebar-menu')
   <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center">
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

    <a href="{{ route('admin.stok') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-fw me-3"></i>
        Stok Barang
    </a>

    <a href="{{ route('admin.penyaluran') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-fw me-3"></i>
        Hasil Penyaluran
    </a>
@endsection

@section('content')

<div class="card shadow-sm text-center">
    <div class="card-body py-5">
        <h4 class="fw-bold mb-2">Penyaluran Berhasil!!</h4>
        <p class="mb-1">Kode Penyaluran : <strong>#34</strong></p>
        <p class="text-muted mb-4">
            Menunggu petugas mengantarkan barang
        </p>

        <a href="{{ route('admin.penyaluran.riwayat') }}"
           class="btn btn-warning rounded-pill w-100 py-2">
            Lihat
        </a>
    </div>
</div>

@endsection
