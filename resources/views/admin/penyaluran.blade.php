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

    <a href="{{ route('admin.stok') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-fw me-3"></i>
        Stok Barang
    </a>

    <a href="{{ route('admin.penyaluran') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-fw me-3"></i>
        Hasil Penyaluran
    </a>
@endsection


{{-- ================= KONTEN PENYALURAN ================= --}}
@section('content')

{{-- HEADER (HANYA TAMBAH LOGO, DESAIN TETAP) --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-lg text-primary me-3"></i>
        <div>
            <h5 class="mb-1">Penyaluran Bantuan</h5>
            <small class="text-muted">
                Pilih petugas untuk menyalurkan bantuan
            </small>
        </div>
    </div>
</div>

{{-- TABEL PETUGAS --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Petugas</th>
                    <th style="width: 140px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach (['Medan','Yogyakarta','Jakarta','Padang'] as $daerah)
                <tr>
                    <td>{{ $daerah }}</td>
                    <td>
                        <a href="{{ route('admin.penyaluran.form', $daerah) }}"
                           class="btn btn-warning btn-sm rounded-pill px-3">
                            Klik
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
