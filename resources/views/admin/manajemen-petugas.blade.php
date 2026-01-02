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

    <a href="{{ route('admin.petugas') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
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

    <a href="{{ route('admin.penyaluran') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-fw me-3"></i>
        Hasil Penyaluran
    </a>
@endsection


{{-- ================= KONTEN DATA PETUGAS ================= --}}
@section('content')

{{-- HEADER --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center">
        <i class="fa-solid fa-users-gear fa-lg text-primary me-3"></i>
        <div>
            <h5 class="mb-1">Manajemen Petugas</h5>
            <small class="text-muted">
                Daftar petugas penyaluran bantuan
            </small>
        </div>
    </div>
</div>

{{-- TABEL PETUGAS --}}
<div class="card shadow-sm">
    <div class="card-body">

        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>No Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>Rizman</td>
                    <td>0819029301</td>
                    <td>
                        <span class="badge bg-success rounded-pill px-3">Online</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.petugas.detail', 1) }}"
                           class="btn btn-warning btn-sm rounded-pill px-3">
                            Detail
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>Andi</td>
                    <td>0821123456</td>
                    <td>
                        <span class="badge bg-secondary rounded-pill px-3">Offline</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.petugas.detail', 2) }}"
                           class="btn btn-warning btn-sm rounded-pill px-3">
                            Detail
                        </a>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
</div>

@endsection
