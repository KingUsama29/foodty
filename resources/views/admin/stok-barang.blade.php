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

    <a href="{{ route('admin.penyaluran') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-fw me-3"></i>
        Hasil Penyaluran
    </a>
@endsection


{{-- ================= KONTEN STOK BARANG ================= --}}
@section('content')

{{-- HEADER --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-lg text-primary me-3"></i>
        <div>
            <h5 class="mb-1">Stok Barang</h5>
            <small class="text-muted">
                Data stok bantuan berdasarkan daerah
            </small>
        </div>
    </div>
</div>

{{-- TABEL DAERAH --}}
<div class="card shadow-sm">
    <div class="card-body">

        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Daerah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>Medan</td>
                    <td>
                        <a href="{{ route('admin.stok.detail', 'medan') }}"
                           class="btn btn-warning btn-sm rounded-pill px-3">
                            Lihat
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>Yogyakarta</td>
                    <td>
                        <a href="{{ route('admin.stok.detail', 'yogyakarta') }}"
                           class="btn btn-warning btn-sm rounded-pill px-3">
                            Lihat
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>Jakarta</td>
                    <td>
                        <a href="{{ route('admin.stok.detail', 'jakarta') }}"
                           class="btn btn-warning btn-sm rounded-pill px-3">
                            Lihat
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>Padang</td>
                    <td>
                        <a href="{{ route('admin.stok.detail', 'padang') }}"
                           class="btn btn-warning btn-sm rounded-pill px-3">
                            Lihat
                        </a>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
</div>

@endsection
