{{-- resources/views/admin/pengajuan-detail.blade.php --}}
@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'pengajuan'])
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

        $isPending = !in_array($status, ['approved', 'rejected'], true);
    @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center">
                <span class="badge text-bg-primary rounded-3 p-3 me-3">
                    <i class="fa-solid fa-file-circle-check fa-lg" style="color:#fff;"></i>
                </span>
                <div>
                    <h5 class="mb-1">Detail Pengajuan Bantuan (Admin)</h5>
                    <small class="text-muted">Periksa data pengajuan penerima</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1" style="color:#6c757d;"></i> Kembali
                </a>

                @if ($isPending)
                    <button class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal"
                        data-bs-target="#accModal">
                        <i class="fa-solid fa-check me-1" style="color:#fff;"></i> ACC
                    </button>

                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                        data-bs-target="#tolakModal">
                        <i class="fa-solid fa-xmark me-1" style="color:#dc3545;"></i> Tolak
                    </button>
                @endif
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

    {{-- TOP BAR INFO --}}
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 align-items-md-center mb-3">
        <div class="text-muted">
            <i class="fa-regular fa-calendar me-1" style="color:#6c757d;"></i>
            Diajukan: <span class="fw-semibold">{{ $foodRequest->created_at?->format('d M Y, H:i') ?? '-' }}</span>
            <span class="mx-2">•</span>
            <i class="fa-solid fa-hashtag me-1" style="color:#6c757d;"></i>
            ID: <span class="fw-semibold">#{{ $foodRequest->id }}</span>
        </div>

        <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
            <i class="fa-solid {{ $statusIcon }} me-1" style="color:#fff;"></i> {{ $statusText }}
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
                            <i class="fa-solid fa-user me-2" style="color:#6c757d;"></i> Data Penerima
                        </div>
                        <span class="badge text-bg-light border rounded-pill px-3 py-2">
                            <i class="fa-solid fa-user-check me-1" style="color:#6c757d;"></i>
                            {{ $foodRequest->user->role ?? 'penerima' }}
                        </span>
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <div class="text-muted">
                                <i class="fa-regular fa-id-card me-2" style="color:#6c757d;"></i>Nama
                            </div>
                            <div class="fw-semibold text-end">{{ $foodRequest->user->name ?? '-' }}</div>
                        </div>

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <div class="text-muted">
                                <i class="fa-solid fa-fingerprint me-2" style="color:#6c757d;"></i>NIK
                            </div>
                            <div class="fw-semibold text-end">{{ $foodRequest->user->nik ?? '-' }}</div>
                        </div>

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <div class="text-muted">
                                <i class="fa-regular fa-envelope me-2" style="color:#6c757d;"></i>Email
                            </div>
                            <div class="fw-semibold text-end">{{ $foodRequest->user->email ?? '-' }}</div>
                        </div>

                        @if (!empty($foodRequest->user->no_telp))
                            <div class="list-group-item px-0 d-flex justify-content-between">
                                <div class="text-muted">
                                    <i class="fa-solid fa-phone me-2" style="color:#6c757d;"></i>No. Telp
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
                        <i class="fa-solid fa-clipboard-list me-2" style="color:#6c757d;"></i> Data Pengajuan
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-4">
                            <div class="border rounded-4 p-3 bg-light h-100">
                                <div class="text-muted small mb-1">
                                    <i class="fa-solid fa-tags me-1" style="color:#6c757d;"></i>Kategori
                                </div>
                                <div class="fw-semibold text-capitalize">{{ $foodRequest->category ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="border rounded-4 p-3 bg-light h-100">
                                <div class="text-muted small mb-1">
                                    <i class="fa-solid fa-users me-1" style="color:#6c757d;"></i>Tanggungan
                                </div>
                                <div class="fw-semibold">{{ $foodRequest->dependents ?? 0 }}</div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="border rounded-4 p-3 bg-light h-100">
                                <div class="text-muted small mb-1">
                                    <i class="fa-solid fa-basket-shopping me-1" style="color:#6c757d;"></i>Kebutuhan
                                </div>
                                <div class="fw-semibold">{{ $foodRequest->main_needs ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">
                            <i class="fa-solid fa-circle-info me-1" style="color:#6c757d;"></i>Alasan Pengajuan
                        </div>
                        <div class="border rounded-4 p-3">
                            {{ $foodRequest->reason ?? '-' }}
                        </div>
                    </div>

                    @if (!empty($foodRequest->description))
                        <div>
                            <div class="text-muted small mb-1">
                                <i class="fa-regular fa-note-sticky me-1" style="color:#6c757d;"></i>Deskripsi Tambahan
                            </div>
                            <div class="border rounded-4 p-3">
                                {{ $foodRequest->description }}
                            </div>
                        </div>
                    @endif

                    @if (!empty($foodRequest->reject_reason))
                        <div class="mt-3">
                            <div class="text-muted small mb-1">
                                <i class="fa-solid fa-circle-xmark me-1" style="color:#6c757d;"></i>Alasan Penolakan
                            </div>
                            <div class="border rounded-4 p-3">
                                {{ $foodRequest->reject_reason }}
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
                        <i class="fa-solid fa-location-dot me-2" style="color:#6c757d;"></i>Alamat Lengkap
                    </div>

                    <div class="border rounded-4 p-3">
                        {{ $foodRequest->address_detail ?? '-' }}
                    </div>
                </div>
            </div>

            {{-- CATATAN / REVIEW --}}
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body">
                    <div class="fw-semibold mb-2">
                        <i class="fa-solid fa-message me-2" style="color:#6c757d;"></i>Catatan Review
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
                            <i class="fa-regular fa-clock me-1" style="color:#6c757d;"></i>
                            Reviewed: {{ \Carbon\Carbon::parse($foodRequest->reviewed_at)->format('d M Y, H:i') }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- FOTO / BUKTI --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="fw-semibold mb-2">
                        <i class="fa-regular fa-image me-2" style="color:#6c757d;"></i>Foto / Bukti
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

    {{-- MODAL ACC --}}
    @if ($isPending)
        <div class="modal fade" id="accModal" tabindex="-1" aria-hidden="true">
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
                                action="{{ route('admin.food-requests.updateStatus', $foodRequest->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button class="btn btn-success rounded-pill px-4">
                                    <i class="fa-solid fa-check me-1" style="color:#fff;"></i> Ya, ACC
                                </button>
                            </form>

                            <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL TOLAK (dengan alasan opsional) --}}
        <div class="modal fade" id="tolakModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4">
                    <form method="POST" action="{{ route('admin.food-requests.updateStatus', $foodRequest->id) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">

                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="fa-solid fa-triangle-exclamation fa-2xl text-danger mb-3"></i>
                                <div class="fw-semibold mb-1">Tolak pengajuan ini?</div>
                                <div class="text-muted mb-3" style="font-size: 14px;">
                                    Status akan berubah menjadi <b>Ditolak</b>.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Alasan Penolakan (opsional)</label>
                                <textarea name="reject_reason" class="form-control rounded-4" rows="3"
                                    placeholder="Contoh: Data tidak lengkap / alamat tidak jelas..."></textarea>
                            </div>

                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-danger rounded-pill px-4">
                                    <i class="fa-solid fa-xmark me-1" style="color:#fff;"></i> Ya, Tolak
                                </button>

                                <button type="button" class="btn btn-secondary rounded-pill px-4"
                                    data-bs-dismiss="modal">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
