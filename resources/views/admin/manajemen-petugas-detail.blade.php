{{-- resources/views/admin/manajemen-petugas-detail.blade.php --}}
@extends('layouts.dashboard')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3" style="color:#6c757d;"></i> Dashboard
    </a>

    <a href="{{ route('admin.pengajuan') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-file-circle-check fa-fw me-3" style="color:#6c757d;"></i> Ajuan Bantuan
    </a>

    <a href="{{ route('admin.petugas') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-users-gear fa-fw me-3" style="color:#6c757d;"></i> Data Petugas
    </a>

    <a href="{{ route('admin.cabang') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-location-dot fa-fw me-3" style="color:#6c757d;"></i> Cabang Lokasi
    </a>

    <a href="{{ route('admin.stok') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-fw me-3" style="color:#6c757d;"></i> Stok Barang
    </a>

    <a href="{{ route('admin.penyaluran') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-fw me-3" style="color:#6c757d;"></i> Hasil Penyaluran
    </a>
@endsection

@section('content')
    @php
        $profile = $user->petugas ?? null;
        $photo = $profile?->file_path ? asset('storage/' . $profile->file_path) : null;

        $active = (bool) ($profile?->is_active ?? 0);
        $statusText = $active ? 'Aktif' : 'Non-Aktif';
        $statusBadge = $active ? 'success' : 'secondary';
        $statusIcon = $active ? 'fa-circle-check' : 'fa-circle-minus';

        $telp = $profile?->no_telp ?? ($user->no_telp ?? '-');
        $alamat = $profile?->alamat ?? ($user->alamat ?? '-');
        $cabang = $profile?->cabang?->name ?? '-';

        $nik = $user->nik ?? '-';
        $email = $user->email ?? '-';

        $created = $user->created_at?->format('d M Y, H:i') ?? '-';
        $verified = $user->email_verified_at
            ? \Carbon\Carbon::parse($user->email_verified_at)->format('d M Y, H:i')
            : '-';
    @endphp

    {{-- HEADER (clean, tanpa bg hitam) --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-user-shield" style="color:#6c757d;"></i>
                </div>
                <div>
                    <h5 class="mb-1">Detail Petugas</h5>
                    <small class="text-muted">Informasi lengkap petugas penyaluran (read-only)</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.petugas') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1" style="color:#fff;"></i> Kembali
                </a>

                <a href="{{ route('admin.petugas.edit', $user->id) }}"
                    class="btn btn-info btn-sm rounded-pill px-3 text-white">
                    <i class="fa-solid fa-pen-to-square me-1" style="color:#fff;"></i> Edit
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-4">
            <i class="fa-solid fa-circle-check me-1" style="color:#198754;"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm border-0 rounded-4">
            <i class="fa-solid fa-circle-xmark me-1" style="color:#dc3545;"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row g-4">
        {{-- LEFT: PROFILE RINGKAS --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    @if ($photo)
                        <img src="{{ $photo }}" class="rounded-circle mb-3 shadow-sm"
                            style="width:120px;height:120px;object-fit:cover">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width:120px;height:120px;">
                            <i class="fa-solid fa-user fa-2xl" style="color:#6c757d;"></i>
                        </div>
                    @endif

                    <h4 class="mb-1">{{ $user->name ?? '-' }}</h4>
                    <div class="text-muted small mb-3">
                        <i class="fa-regular fa-envelope me-1" style="color:#6c757d;"></i>{{ $email }}
                    </div>

                    <span class="badge bg-{{ $statusBadge }} rounded-pill px-4 py-2">
                        <i class="fa-solid {{ $statusIcon }} me-1" style="color:#fff;"></i> {{ $statusText }}
                    </span>

                    <div class="text-muted small mt-3">
                        <i class="fa-regular fa-clock me-1" style="color:#6c757d;"></i> Dibuat: {{ $created }}
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: DETAIL --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="fw-semibold">
                            <i class="fa-solid fa-id-card me-1" style="color:#6c757d;"></i> Informasi Detail
                        </div>
                        <span class="text-muted small">
                            <i class="fa-solid fa-lock me-1" style="color:#6c757d;"></i> Read-only
                        </span>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">NIK</label>
                            <input class="form-control rounded-pill" value="{{ $nik }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">No Telepon</label>
                            <input class="form-control rounded-pill" value="{{ $telp }}" disabled>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Cabang</label>
                            <input class="form-control rounded-pill" value="{{ $cabang }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Email Verified</label>
                            <input class="form-control rounded-pill" value="{{ $verified }}" disabled>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small text-muted">Alamat</label>
                        <textarea class="form-control rounded-4" rows="3" disabled>{{ $alamat }}</textarea>
                    </div>
                </div>
            </div>

            <div class="text-muted small mt-3">
                <i class="fa-solid fa-circle-info me-1" style="color:#6c757d;"></i>
                Informasi di atas bersifat read-only. Untuk mengubah data petugas, silakan klik tombol "Edit".
            </div>
        </div>
    </div>
@endsection
