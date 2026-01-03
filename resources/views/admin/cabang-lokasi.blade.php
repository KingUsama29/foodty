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

    <a href="{{ route('admin.cabang') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
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


{{-- ================= KONTEN CABANG LOKASI ================= --}}
@section('content')

{{-- HEADER (LOGO + JUDUL, KONSISTEN) --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center">
        <i class="fa-solid fa-location-dot fa-lg text-primary me-3"></i>
        <div>
            <h5 class="mb-1">Cabang Lokasi</h5>
            <small class="text-muted">
                Informasi cabang penyaluran bantuan
            </small>
        </div>
    </div>
</div>

{{-- TABEL CABANG --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Cabang</th>
                    <th>Total Petugas</th>
                    <th>Menangani</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Medan</td>
                    <td>46</td>
                    <td>31 Daerah</td>
                </tr>
                <tr>
                    <td>Yogyakarta</td>
                    <td>32</td>
                    <td>17 Daerah</td>
                </tr>
                <tr>
                    <td>Jakarta</td>
                    <td>41</td>
                    <td>24 Daerah</td>
                </tr>
                <tr>
                    <td>Padang</td>
                    <td>43</td>
                    <td>34 Daerah</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
