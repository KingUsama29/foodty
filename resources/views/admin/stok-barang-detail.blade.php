@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU ADMIN ================= --}}
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

    {{-- ACTIVE --}}
    <a href="{{ route('admin.stok') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-fw me-3"></i>
        Stok Barang
    </a>

    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-fw me-3"></i>
        Hasil Penyaluran
    </a>
@endsection


{{-- ================= KONTEN DETAIL STOK ================= --}}
@section('content')

{{-- HEADER --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-lg text-primary me-3"></i>
        <div>
            <h5 class="mb-1">Stok Barang</h5>
            <small class="text-muted">
                Informasi stok bantuan pangan
            </small>
        </div>
    </div>
</div>

{{-- TABEL --}}
<div class="card shadow-sm">
    <div class="card-body p-0">

        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Barang</th>
                    <th class="text-end pe-4">Stok</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ps-4">Beras 10 kg</td>
                    <td class="text-end pe-4 fw-semibold">107</td>
                </tr>
                <tr>
                    <td class="ps-4">Minyak 5 Liter</td>
                    <td class="text-end pe-4 fw-semibold">168</td>
                </tr>
                <tr>
                    <td class="ps-4">Air Minum 1 Kotak</td>
                    <td class="text-end pe-4 fw-semibold">109</td>
                </tr>
                <tr>
                    <td class="ps-4">Roti Kering</td>
                    <td class="text-end pe-4 fw-semibold">248</td>
                </tr>
                <tr>
                    <td class="ps-4">Susu Bayi</td>
                    <td class="text-end pe-4 fw-semibold">158</td>
                </tr>
            </tbody>
        </table>

        {{-- TOMBOL KEMBALI (TETAP) --}}
        <div class="p-3">
            <a href="{{ route('admin.stok') }}"
               class="btn btn-secondary rounded-pill px-4">
                Kembali
            </a>
        </div>

    </div>
</div>

@endsection
