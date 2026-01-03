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


{{-- ================= KONTEN AJUAN BANTUAN ================= --}}
@section('content')

{{-- HEADER DENGAN LOGO (SAMA SEPERTI DASHBOARD) --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center">
        <i class="fa-solid fa-file-circle-check fa-lg text-primary me-3"></i>
        <div>
            <h5 class="mb-1">Daftar Pengajuan Bantuan</h5>
            <small class="text-muted">
                Verifikasi pengajuan bantuan dari penerima
            </small>
        </div>
    </div>
</div>

{{-- TABEL PENGAJUAN --}}
<div class="card shadow-sm">
    <div class="card-body">

        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Pengaju</th>
                    <th>Detail</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>Rizman</td>

                    <td>
                        <a href="{{ route('admin.pengajuan.detail', 1) }}"
                           class="btn btn-warning btn-sm rounded-pill px-3">
                            Lihat
                        </a>
                    </td>

                    <td>
                        <button class="btn btn-success btn-sm rounded-pill px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#accModal">
                            ACC
                        </button>

                        <button class="btn btn-danger btn-sm rounded-pill px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#tolakModal">
                            Tolak
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
</div>

{{-- ================= MODAL ACC ================= --}}
<div class="modal fade" id="accModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-body text-center p-4">
                <p class="fw-semibold mb-4">
                    Apakah anda yakin akan menyetujui pengajuan ini?
                </p>
                <button class="btn btn-success rounded-pill px-4">Ya</button>
                <button class="btn btn-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">
                    Tidak
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL TOLAK ================= --}}
<div class="modal fade" id="tolakModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-body text-center p-4">
                <p class="fw-semibold mb-4">
                    Apakah anda yakin akan menolak pengajuan ini?
                </p>
                <button class="btn btn-danger rounded-pill px-4">Ya</button>
                <button class="btn btn-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">
                    Tidak
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
