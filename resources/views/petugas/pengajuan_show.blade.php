@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'pengajuan'])
@endsection

@section('content')
    @php
        $status = $foodRequest->status ?? 'pending';

        $badgeClass = match ($status) {
            'approved' => 'text-bg-success',
            'rejected' => 'text-bg-danger',
            default => 'text-bg-warning',
        };

        $statusText = match ($status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Pending',
        };

        $statusIcon = match ($status) {
            'approved' => 'fa-circle-check',
            'rejected' => 'fa-circle-xmark',
            default => 'fa-clock',
        };

        $photo = $foodRequest->file_path ?? null;
    @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <span class="badge text-bg-primary rounded-3 p-3 me-3">
                    <i class="fa-solid fa-file-circle-plus fa-lg"></i>
                </span>
                <div>
                    <h5 class="mb-1">Detail Pengajuan Bantuan</h5>
                    <small class="text-muted">Periksa data pengajuan Pemohon</small>
                </div>
            </div>

            <a href="{{ route('petugas.data-pengajuan') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- TOP BAR INFO --}}
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 align-items-md-center mb-3">
        <div class="text-muted">
            <i class="fa-regular fa-calendar me-1"></i>
            Diajukan: <span class="fw-semibold">{{ $foodRequest->created_at?->format('d M Y, H:i') }}</span>
            <span class="mx-2">•</span>
            <i class="fa-solid fa-hashtag me-1"></i>
            ID: <span class="fw-semibold">#{{ $foodRequest->id }}</span>
        </div>

        <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
            <i class="fa-solid {{ $statusIcon }} me-1"></i> {{ $statusText }}
        </span>
    </div>

    <div class="row g-3">
        {{-- KIRI --}}
        <div class="col-lg-7">
            {{-- DATA PENERIMA --}}
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="fw-semibold">
                            <i class="fa-solid fa-user me-2 text-muted"></i> Data Pemohon
                        </div>
                        <span class="badge text-bg-light border rounded-pill px-3 py-2">
                            <i class="fa-solid fa-user-check me-1 text-muted"></i>
                            {{ $foodRequest->user->role ?? 'penerima' }}
                        </span>
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <div class="text-muted">
                                <i class="fa-regular fa-id-card me-2"></i>Nama
                            </div>
                            <div class="fw-semibold text-end">{{ $foodRequest->user->name ?? '-' }}</div>
                        </div>

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <div class="text-muted">
                                <i class="fa-solid fa-fingerprint me-2"></i>NIK
                            </div>
                            <div class="fw-semibold text-end">{{ $foodRequest->user->nik ?? '-' }}</div>
                        </div>

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <div class="text-muted">
                                <i class="fa-regular fa-envelope me-2"></i>Email
                            </div>
                            <div class="fw-semibold text-end">{{ $foodRequest->user->email ?? '-' }}</div>
                        </div>

                        @if (!empty($foodRequest->user->no_telp))
                            <div class="list-group-item px-0 d-flex justify-content-between">
                                <div class="text-muted">
                                    <i class="fa-solid fa-phone me-2"></i>No. Telp
                                </div>
                                <div class="fw-semibold text-end">{{ $foodRequest->user->no_telp }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- DATA PENGAJUAN --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="fw-semibold mb-3">
                        <i class="fa-solid fa-clipboard-list me-2 text-muted"></i> Data Pengajuan
                    </div>

                    {{-- 3 box ringkas (bootstrap only) --}}
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-4">
                            <div class="border rounded-4 p-3 bg-light h-100">
                                <div class="text-muted small mb-1">
                                    <i class="fa-solid fa-tags me-1"></i>Kategori
                                </div>
                                <div class="fw-semibold text-capitalize">{{ $foodRequest->category ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="border rounded-4 p-3 bg-light h-100">
                                <div class="text-muted small mb-1">
                                    <i class="fa-solid fa-users me-1"></i>Tanggungan
                                </div>
                                <div class="fw-semibold">{{ $foodRequest->dependents ?? 0 }}</div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="border rounded-4 p-3 bg-light h-100">
                                <div class="text-muted small mb-1">
                                    <i class="fa-solid fa-basket-shopping me-1"></i>Kebutuhan
                                </div>
                                <div class="fw-semibold">{{ $foodRequest->main_needs ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">
                            <i class="fa-solid fa-circle-info me-1"></i>Alasan Pengajuan
                        </div>
                        <div class="border rounded-4 p-3">
                            {{ $foodRequest->reason ?? '-' }}
                        </div>
                    </div>

                    @if (!empty($foodRequest->description))
                        <div>
                            <div class="text-muted small mb-1">
                                <i class="fa-regular fa-note-sticky me-1"></i>Deskripsi Tambahan
                            </div>
                            <div class="border rounded-4 p-3">
                                {{ $foodRequest->description }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KANAN --}}
        <div class="col-lg-5">
            {{-- ALAMAT --}}
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body">
                    <div class="fw-semibold mb-2">
                        <i class="fa-solid fa-location-dot me-2 text-muted"></i>Alamat Lengkap
                    </div>

                    <div class="border rounded-4 p-3">
                        {{ $foodRequest->address_detail ?? '-' }}
                    </div>
                </div>
            </div>

            {{-- CATATAN PETUGAS --}}
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body">
                    <div class="fw-semibold mb-2">
                        <i class="fa-solid fa-message me-2 text-muted"></i>Catatan Petugas
                    </div>

                    @if (!empty($foodRequest->review_notes))
                        <div class="border rounded-4 p-3">
                            {{ $foodRequest->review_notes }}
                        </div>
                    @else
                        <div class="text-muted">Belum ada catatan.</div>
                    @endif

                    @if ($foodRequest->reviewed_at)
                        <div class="text-muted small mt-2">
                            <i class="fa-regular fa-clock me-1"></i>
                            Reviewed: {{ \Carbon\Carbon::parse($foodRequest->reviewed_at)->format('d M Y, H:i') }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- FOTO / BUKTI --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="fw-semibold mb-2">
                        <i class="fa-regular fa-image me-2 text-muted"></i>Foto / Bukti
                    </div>

                    @if (!empty($photo))
                        <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="text-decoration-none d-block">
                            <div class="border rounded-4 overflow-hidden">
                                <img src="{{ asset('storage/' . $photo) }}" class="img-fluid w-100 d-block"
                                    alt="Bukti Pengajuan">
                            </div>
                        </a>
                        <div class="text-muted small mt-2">
                            Klik gambar untuk buka ukuran penuh.
                        </div>
                    @else
                        <div class="text-muted">Tidak ada bukti yang diunggah.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
