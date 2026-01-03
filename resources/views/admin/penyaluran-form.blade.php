@extends('layouts.dashboard')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i> Dashboard
    </a>
    <a href="{{ route('admin.pengajuan') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-file-circle-check fa-fw me-3"></i> Ajuan Bantuan
    </a>
    <a href="{{ route('admin.petugas') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-users-gear fa-fw me-3"></i> Data Petugas
    </a>
    <a href="{{ route('admin.cabang') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-location-dot fa-fw me-3"></i> Cabang Lokasi
    </a>
    <a href="{{ route('admin.stok') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-fw me-3"></i> Stok Barang
    </a>
    <a href="{{ route('admin.penyaluran') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-truck fa-fw me-3"></i> Hasil Penyaluran
    </a>
@endsection

@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-1">Isi Formulir Penyaluran Barang</h5>
        <small class="text-muted">Daerah: Medan</small>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <input type="text" class="form-control mb-3" value="Rizman" readonly>
        <input type="text" class="form-control mb-3" value="08123456789" readonly>
        <input type="text" class="form-control mb-3" value="327401xxxxxx" readonly>
        <input type="text" class="form-control mb-3" value="Bencana Alam" readonly>

        <textarea class="form-control mb-3" rows="3" readonly>
Stabat, Langkat, Medan
        </textarea>

        <textarea class="form-control mb-4" rows="3" readonly>
Beras, minyak, air minum
        </textarea>

        <a href="{{ route('admin.penyaluran.ringkasan') }}"
           class="btn btn-warning rounded-pill px-4">
            Kirim
        </a>

    </div>
</div>

@endsection
