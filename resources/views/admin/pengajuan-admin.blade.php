{{-- resources/views/admin/pengajuan-admin.blade.php --}}
@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'pengajuan'])
@endsection

@section('content')
    @php
        $q = $q ?? request('q');

        // status dari query string (boleh null/empty = semua)
        $status = $status ?? request('status'); // pending/approved/rejected/ null

        $mapBadge = fn($st) => match ($st) {
            'approved' => 'text-bg-success',
            'rejected' => 'text-bg-danger',
            default => 'text-bg-warning',
        };

        $mapText = fn($st) => match ($st) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Pending',
        };

        $mapIcon = fn($st) => match ($st) {
            'approved' => 'fa-circle-check',
            'rejected' => 'fa-circle-xmark',
            default => 'fa-clock',
        };

        // Helper buat bikin URL filter yang tetap bawa q
        $filterUrl = function ($st) use ($q) {
            $params = array_filter(
                [
                    'q' => $q,
                    'status' => $st, // null/'' = semua
                ],
                fn($v) => $v !== null && $v !== '',
            );
            return route('admin.pengajuan', $params);
        };
    @endphp

    {{-- HEADER (mirip halaman petugas) --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <span class="badge text-bg-primary rounded-3 p-3 me-3">
                    <i class="fa-solid fa-file-circle-check fa-lg" style="color:#fff;"></i>
                </span>
                <div>
                    <h5 class="mb-1">Data Pengajuan Bantuan (Admin)</h5>
                    <small class="text-muted">Verifikasi pengajuan bantuan dari penerima (Food Requests)</small>
                </div>
            </div>

            <form method="GET" class="d-flex gap-2">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm"
                    placeholder="Cari nama / kategori / alasan...">
                <button class="btn btn-primary btn-sm rounded-pill px-3">
                    Cari
                </button>
            </form>
        </div>
    </div>

    {{-- FILTER STATUS --}}
    <div class="d-flex gap-2 flex-wrap mb-3">
        <a href="{{ $filterUrl(null) }}"
            class="btn btn-sm rounded-pill px-3 {{ empty($status) ? 'btn-dark' : 'btn-outline-dark' }}">
            <i class="fa-solid fa-layer-group me-1" style="color:{{ empty($status) ? '#fff' : '#212529' }};"></i>
            Semua
        </a>

        <a href="{{ $filterUrl('pending') }}"
            class="btn btn-sm rounded-pill px-3 {{ $status === 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fa-solid fa-clock me-1" style="color:{{ $status === 'pending' ? '#fff' : '#0d6efd' }};"></i>
            Pending
        </a>

        <a href="{{ $filterUrl('approved') }}"
            class="btn btn-sm rounded-pill px-3 {{ $status === 'approved' ? 'btn-success' : 'btn-outline-success' }}">
            <i class="fa-solid fa-circle-check me-1" style="color:{{ $status === 'approved' ? '#fff' : '#198754' }};"></i>
            Disetujui
        </a>

        <a href="{{ $filterUrl('rejected') }}"
            class="btn btn-sm rounded-pill px-3 {{ $status === 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
            <i class="fa-solid fa-circle-xmark me-1" style="color:{{ $status === 'rejected' ? '#fff' : '#dc3545' }};"></i>
            Ditolak
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-4">
            <i class="fa-solid fa-circle-check me-1" style="color:#198754;"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('failed'))
        <div class="alert alert-danger shadow-sm border-0 rounded-4">
            <i class="fa-solid fa-circle-xmark me-1" style="color:#dc3545;"></i> {{ session('failed') }}
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
                                $badgeClass = $mapBadge($r->status ?? null);
                                $statusText = $mapText($r->status ?? null);
                                $statusIcon = $mapIcon($r->status ?? null);

                                $isPending = !in_array($r->status, ['approved', 'rejected'], true);
                            @endphp

                            <tr>
                                {{-- PENERIMA --}}
                                <td style="min-width: 240px;">
                                    <div class="fw-semibold">
                                        <i class="fa-solid fa-user me-1" style="color:#6c757d;"></i>
                                        {{ $r->user->name ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fa-regular fa-envelope me-1" style="color:#6c757d;"></i>
                                        {{ $r->user->email ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fa-solid fa-fingerprint me-1" style="color:#6c757d;"></i>
                                        NIK: {{ $r->user->nik ?? '-' }}
                                    </div>
                                </td>

                                {{-- PENGAJUAN --}}
                                <td style="min-width: 210px;">
                                    <div class="fw-semibold text-capitalize">
                                        <i class="fa-solid fa-tags me-1" style="color:#6c757d;"></i>
                                        {{ $r->category ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fa-regular fa-calendar me-1" style="color:#6c757d;"></i>
                                        {{ $r->created_at?->format('Y-m-d H:i') ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fa-solid fa-hashtag me-1" style="color:#6c757d;"></i>
                                        ID: {{ $r->id }}
                                    </div>
                                </td>

                                {{-- KEBUTUHAN --}}
                                <td style="min-width: 260px;">
                                    <div class="fw-semibold">
                                        <i class="fa-solid fa-basket-shopping me-1" style="color:#6c757d;"></i>
                                        {{ $r->main_needs ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fa-regular fa-comment-dots me-1" style="color:#6c757d;"></i>
                                        {{ \Illuminate\Support\Str::limit($r->reason ?? '-', 70) }}
                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td style="min-width: 190px;">
                                    <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
                                        <i class="fa-solid {{ $statusIcon }} me-1" style="color:#fff;"></i>
                                        {{ $statusText }}
                                    </span>

                                    @if (!empty($r->reviewed_at))
                                        <div class="text-muted small mt-1">
                                            <i class="fa-regular fa-clock me-1" style="color:#6c757d;"></i>
                                            Reviewed: {{ \Carbon\Carbon::parse($r->reviewed_at)->format('Y-m-d H:i') }}
                                        </div>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="text-end" style="min-width: 320px;">
                                    <div class="d-inline-flex gap-2 flex-wrap justify-content-end">
                                        <a href="{{ route('admin.pengajuan.detail', $r->id) }}"
                                            class="btn btn-warning btn-sm rounded-pill px-3">
                                            <i class="fa-solid fa-eye me-1" style="color:#fff;"></i> Detail
                                        </a>

                                        @if ($isPending)
                                            <button class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                                data-bs-target="#acc{{ $r->id }}">
                                                <i class="fa-solid fa-check me-1" style="color:#fff;"></i> ACC
                                            </button>

                                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                                data-bs-toggle="modal" data-bs-target="#tolak{{ $r->id }}">
                                                <i class="fa-solid fa-xmark me-1" style="color:#dc3545;"></i> Tolak
                                            </button>
                                        @endif
                                    </div>

                                    {{-- MODAL ACC --}}
                                    <div class="modal fade" id="acc{{ $r->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4">
                                                <div class="modal-body p-4">
                                                    <div class="text-center">
                                                        <i class="fa-solid fa-circle-check fa-2xl text-success mb-3"></i>
                                                        <div class="fw-semibold mb-1">Setujui pengajuan ini?</div>
                                                        <div class="text-muted mb-3" style="font-size: 14px;">
                                                            Status akan berubah menjadi <b>Disetujui</b>.
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-center gap-2">
                                                        <form method="POST"
                                                            action="{{ route('admin.food-requests.updateStatus', $r->id) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="approved">
                                                            <button class="btn btn-success rounded-pill px-4">
                                                                <i class="fa-solid fa-check me-1" style="color:#fff;"></i>
                                                                Ya, ACC
                                                            </button>
                                                        </form>

                                                        <button class="btn btn-secondary rounded-pill px-4"
                                                            data-bs-dismiss="modal">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- MODAL TOLAK --}}
                                    <div class="modal fade" id="tolak{{ $r->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4">
                                                <form method="POST"
                                                    action="{{ route('admin.food-requests.updateStatus', $r->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">

                                                    <div class="modal-body p-4">
                                                        <div class="text-center">
                                                            <i
                                                                class="fa-solid fa-triangle-exclamation fa-2xl text-danger mb-3"></i>
                                                            <div class="fw-semibold mb-1">Tolak pengajuan ini?</div>
                                                            <div class="text-muted mb-3" style="font-size: 14px;">
                                                                Status akan berubah menjadi <b>Ditolak</b>.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label small text-muted">Alasan Penolakan
                                                                (opsional)
                                                            </label>
                                                            <textarea name="reject_reason" class="form-control rounded-4" rows="3"
                                                                placeholder="Contoh: Data tidak lengkap / alamat tidak jelas..."></textarea>
                                                        </div>

                                                        <div class="d-flex justify-content-center gap-2">
                                                            <button class="btn btn-danger rounded-pill px-4">
                                                                <i class="fa-solid fa-xmark me-1" style="color:#fff;"></i>
                                                                Ya, Tolak
                                                            </button>

                                                            <button type="button"
                                                                class="btn btn-secondary rounded-pill px-4"
                                                                data-bs-dismiss="modal">
                                                                Batal
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fa-regular fa-folder-open me-1" style="color:#6c757d;"></i>
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
