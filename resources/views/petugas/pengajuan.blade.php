@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'pengajuan'])
@endsection

@section('content')
    {{-- HEADER --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <span class="badge text-bg-primary rounded-3 p-3 me-3">
                    <i class="fa-solid fa-file-circle-plus fa-lg"></i>
                </span>
                <div>
                    <h5 class="mb-1">Data Pengajuan Bantuan</h5>
                    <small class="text-muted">Daftar pengajuan bantuan dari penerima (Food Requests)</small>
                </div>
            </div>

            <form method="GET" class="d-flex gap-2">
                <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm"
                    placeholder="Cari nama / kategori / alasan...">
                <button class="btn btn-primary btn-sm rounded-pill px-3">
                    Cari
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-4">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Penerima</th>
                            <th>Pengajuan</th>
                            <th>Kebutuhan</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($requests as $r)
                            @php
                                $badgeClass = match ($r->status) {
                                    'approved' => 'text-bg-success',
                                    'rejected' => 'text-bg-danger',
                                    default => 'text-bg-warning',
                                };

                                $statusText = match ($r->status) {
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                    default => 'Pending',
                                };

                                $statusIcon = match ($r->status) {
                                    'approved' => 'fa-circle-check',
                                    'rejected' => 'fa-circle-xmark',
                                    default => 'fa-clock',
                                };
                            @endphp

                            <tr>
                                {{-- PENERIMA --}}
                                <td style="min-width: 240px;">
                                    <div class="fw-semibold">
                                        <i class="fa-solid fa-user me-1 text-muted"></i>
                                        {{ $r->user->name ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fa-regular fa-envelope me-1"></i>{{ $r->user->email ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fa-solid fa-fingerprint me-1"></i>NIK: {{ $r->user->nik ?? '-' }}
                                    </div>
                                </td>

                                {{-- PENGAJUAN --}}
                                <td style="min-width: 210px;">
                                    <div class="fw-semibold text-capitalize">
                                        <i class="fa-solid fa-tags me-1 text-muted"></i>
                                        {{ $r->category ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fa-regular fa-calendar me-1"></i>
                                        {{ $r->created_at?->format('Y-m-d H:i') }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fa-solid fa-hashtag me-1"></i>ID: {{ $r->id }}
                                    </div>
                                </td>

                                {{-- KEBUTUHAN --}}
                                <td style="min-width: 260px;">
                                    <div class="fw-semibold">
                                        <i class="fa-solid fa-basket-shopping me-1 text-muted"></i>
                                        {{ $r->main_needs ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fa-regular fa-comment-dots me-1"></i>
                                        {{ \Illuminate\Support\Str::limit($r->reason ?? '-', 70) }}
                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td style="min-width: 170px;">
                                    <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
                                        <i class="fa-solid {{ $statusIcon }} me-1"></i> {{ $statusText }}
                                    </span>

                                    @if ($r->reviewed_at)
                                        <div class="text-muted small mt-1">
                                            <i class="fa-regular fa-clock me-1"></i>
                                            Reviewed: {{ \Carbon\Carbon::parse($r->reviewed_at)->format('Y-m-d H:i') }}
                                        </div>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="text-end" style="min-width: 120px;">
                                    <a href="{{ route('petugas.pengajuan.detail', $r->id) }}"
                                        class="btn btn-warning btn-sm rounded-pill px-3">
                                        <i class="fa-solid fa-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada data pengajuan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
@endsection
