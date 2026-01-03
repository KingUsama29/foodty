@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU ADMIN ================= --}}
@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i>
        Dashboard
    </a>

    <a href="{{ route('admin.pengajuan') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-file-circle-check fa-fw me-3"></i>
        Ajuan Bantuan
    </a>

    <a href="{{ route('admin.petugas') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-users-gear fa-fw me-3"></i>
        Data Petugas
    </a>

    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-location-dot fa-fw me-3"></i>
        Cabang Lokasi
    </a>

    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-fw me-3"></i>
        Stok Barang
    </a>

    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-fw me-3"></i>
        Hasil Penyaluran
    </a>
@endsection


{{-- ================= KONTEN DETAIL AJUAN ================= --}}
@section('content')

{{-- HEADER --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center">
        <i class="fa-solid fa-file-lines fa-lg text-primary me-3"></i>
        <div>
            <h5 class="mb-1">Detail Pengajuan Bantuan</h5>
            <small class="text-muted">
                Data pengajuan (read-only)
            </small>
        </div>
    </div>
</div>

{{-- FORM DETAIL --}}
<div class="card shadow-sm">
    <div class="card-body">

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control rounded-pill"
                       value="Rizman" disabled>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control rounded-pill"
                       value="08123456789" disabled>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control rounded-pill"
                       value="327401xxxxxx" disabled>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control rounded-pill"
                       value="Bencana Alam" disabled>
            </div>
        </div>

        <div class="mb-3">
            <textarea class="form-control rounded-4" rows="3" disabled>
Stabat, Langkat, Medan, Sumatera Utara
            </textarea>
        </div>

        <div class="mb-4">
            <textarea class="form-control rounded-4" rows="4" disabled>
Diminta bantuan karena terdampak banjir dan kehilangan sumber penghasilan.
            </textarea>
        </div>

        <a href="{{ route('admin.pengajuan') }}"
           class="btn btn-secondary rounded-pill px-4">
            Kembali
        </a>

    </div>
</div>

@endsection
