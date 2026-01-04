@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'penyaluran'])
@endsection

@section('content')
    @php
        $movedAt = $row->moved_at ? \Carbon\Carbon::parse($row->moved_at) : null;
        $expired = $row->expired_at ? \Carbon\Carbon::parse($row->expired_at) : null;

        $today = \Carbon\Carbon::today();
        $daysLeft = $expired ? $today->diffInDays($expired, false) : null;

        $expiredAlready = $expired ? $expired->isPast() : false;
        $nearExpired = $expired ? $daysLeft !== null && $daysLeft <= 180 && $daysLeft >= 0 : false;

        $badgeExp = !$expired
            ? ['secondary', 'Tanpa expired', 'fa-minus']
            : ($expiredAlready
                ? ['danger', 'Expired', 'fa-triangle-exclamation']
                : ($nearExpired
                    ? ['warning', 'Hampir expired', 'fa-clock']
                    : ['success', 'Aman', 'fa-circle-check']));

        // helper label kategori
        $kategoriLabel = match ($row->kategori ?? null) {
            'pangan_kemasan' => 'Pangan Kemasan',
            'pangan_segar' => 'Pangan Segar',
            'non_pangan' => 'Non Pangan',
            default => $row->kategori ?? '-',
        };
    @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-start">
                <div class="me-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle"
                        style="width:44px;height:44px;">
                        <i class="fa-solid fa-receipt text-primary"></i>
                    </span>
                </div>

                <div>
                    <h5 class="mb-1">Detail Penyaluran</h5>
                    <div class="text-muted small">
                        Audit detail transaksi pengeluaran stok cabang (warehouse movements).
                    </div>

                    <div class="mt-2 d-flex flex-wrap gap-2">
                        <span class="badge text-bg-light border">
                            <i class="fa-solid fa-hashtag me-1"></i>ID Movement: {{ $row->id }}
                        </span>
                        <span class="badge text-bg-light border">
                            <i class="fa-solid fa-right-from-bracket me-1"></i>Type: {{ $row->type ?? 'out' }}
                        </span>
                        <span class="badge text-bg-{{ $badgeExp[0] }}">
                            <i class="fa-solid {{ $badgeExp[2] }} me-1"></i>{{ $badgeExp[1] }}
                        </span>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.penyaluran') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- RINGKASAN --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <div class="fw-semibold">
                        <i class="fa-solid fa-circle-info me-2 text-primary"></i>Ringkasan Penyaluran
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Cabang</div>
                            <div class="fw-semibold">
                                <i class="fa-solid fa-building-flag me-1 text-primary"></i>
                                {{ $row->nama_cabang ?? '-' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Waktu (Log Movement)</div>
                            <div class="fw-semibold">
                                {{ $movedAt ? $movedAt->format('d M Y H:i') : '-' }}
                            </div>
                            <div class="text-muted small">
                                @if ($movedAt)
                                    {{ $movedAt->diffForHumans() }}
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Petugas</div>
                            <div class="fw-semibold">
                                <i class="fa-solid fa-user-gear me-1 text-primary"></i>
                                {{ $row->nama_petugas ?? '-' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Penerima</div>
                            <div class="fw-semibold">
                                <i class="fa-solid fa-user-check me-1 text-primary"></i>
                                {{ $row->nama_penerima ?? '-' }}
                            </div>
                            @if (!empty($row->recipient_phone) || !empty($row->recipient_address))
                                <div class="text-muted small mt-1">
                                    @if (!empty($row->recipient_phone))
                                        <span class="me-3"><i
                                                class="fa-solid fa-phone me-1"></i>{{ $row->recipient_phone }}</span>
                                    @endif
                                    @if (!empty($row->recipient_address))
                                        <span><i
                                                class="fa-solid fa-location-dot me-1"></i>{{ \Illuminate\Support\Str::limit($row->recipient_address, 50) }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Barang</div>
                            <div class="fw-semibold">
                                <i class="fa-solid fa-box me-1 text-primary"></i>
                                {{ $row->nama_barang ?? '-' }}
                            </div>
                            <div class="text-muted small">
                                <i class="fa-solid fa-tag me-1"></i>{{ $kategoriLabel }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Jumlah</div>
                            <div class="fw-semibold">
                                {{ (float) ($row->qty ?? 0) }} {{ $row->unit ?? '' }}
                            </div>

                            <div class="text-muted small mt-1">
                                <i class="fa-solid fa-calendar-days me-1"></i>
                                Expired:
                                <span class="fw-semibold">
                                    {{ $expired ? $expired->format('d M Y') : '-' }}
                                </span>

                                @if ($expired)
                                    <span class="ms-2 badge text-bg-{{ $badgeExp[0] }}">
                                        <i class="fa-solid {{ $badgeExp[2] }} me-1"></i>{{ $badgeExp[1] }}
                                    </span>
                                @endif
                            </div>

                            @if ($expired && !$expiredAlready)
                                <div class="text-muted small mt-1">
                                    <i class="fa-solid fa-hourglass-half me-1"></i>
                                    Sisa hari: <span class="fw-semibold">{{ max(0, (int) $daysLeft) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="col-12">
                            <div class="text-muted small mb-1">Catatan Movement</div>
                            <div class="p-2 bg-light rounded border">
                                {{ $row->note ?? '-' }}
                            </div>
                        </div>

                        @if (!empty($row->source_type) && !empty($row->source_id))
                            <div class="col-12">
                                <span class="badge text-bg-light border">
                                    <i class="fa-solid fa-link me-1"></i>
                                    Source: {{ $row->source_type }} #{{ $row->source_id }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- PANEL AUDIT TAMBAHAN --}}
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <div class="fw-semibold">
                        <i class="fa-solid fa-shield-halved me-2 text-primary"></i>Info Audit
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">ID Cabang</span>
                        <span class="fw-semibold">{{ $row->cabang_id ?? '-' }}</span>
                    </div>

                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Warehouse Item ID</span>
                        <span class="fw-semibold">{{ $row->warehouse_item_id ?? '-' }}</span>
                    </div>

                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Created By</span>
                        <span class="fw-semibold">{{ $row->created_by ?? '-' }}</span>
                    </div>

                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Movement At</span>
                        <span class="fw-semibold">{{ $movedAt ? $movedAt->format('d/m/Y') : '-' }}</span>
                    </div>

                    <hr>

                    {{-- INFO DISTRIBUTION (kalau join ada) --}}
                    <div class="fw-semibold mb-2">
                        <i class="fa-solid fa-truck-fast me-2 text-primary"></i>Data Distribution
                    </div>

                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Distribution ID</span>
                        <span class="fw-semibold">{{ $row->distribution_id ?? '-' }}</span>
                    </div>

                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Food Request ID</span>
                        <span class="fw-semibold">{{ $row->food_request_id ?? '-' }}</span>
                    </div>

                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Status</span>
                        @php
                            $st = $row->status_penyaluran ?? null;
                            $stBadge = $st === 'completed' ? 'success' : ($st === 'canceled' ? 'secondary' : 'warning');
                        @endphp
                        <span class="badge bg-{{ $st ? $stBadge : 'light text-dark border' }}">
                            {{ $st ?? '-' }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <div class="text-muted small mb-1">Jadwal (scheduled_at)</div>
                        <div class="fw-semibold">
                            {{ !empty($row->scheduled_at) ? \Carbon\Carbon::parse($row->scheduled_at)->format('d M Y H:i') : '-' }}
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="text-muted small mb-1">Waktu Distribusi (distributed_at)</div>
                        <div class="fw-semibold">
                            {{ !empty($row->distributed_at) ? \Carbon\Carbon::parse($row->distributed_at)->format('d M Y H:i') : '-' }}
                        </div>
                    </div>

                    @if (!empty($row->note_penyaluran))
                        <div class="mt-3">
                            <div class="text-muted small mb-1">Catatan Distribution</div>
                            <div class="p-2 bg-light rounded border">
                                {{ $row->note_penyaluran }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- DATA PENGAJUAN (opsional, kalau query show() kamu select fieldnya) --}}
    @php
        $hasFoodReq =
            !empty($row->food_request_id) ||
            !empty($row->fr_status) ||
            !empty($row->fr_category) ||
            !empty($row->main_needs) ||
            !empty($row->address_detail) ||
            !empty($row->reason);
    @endphp

    @if ($hasFoodReq)
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <div class="fw-semibold">
                    <i class="fa-solid fa-file-circle-check me-2 text-primary"></i>Data Pengajuan (Food Request)
                </div>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Food Request ID</div>
                        <div class="fw-semibold">{{ $row->food_request_id ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Kategori Pengajuan</div>
                        <div class="fw-semibold">{{ $row->fr_category ?? ($row->kategori_pengajuan ?? '-') }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Status Pengajuan</div>
                        <div class="fw-semibold">{{ $row->fr_status ?? ($row->status_pengajuan ?? '-') }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Tanggungan</div>
                        <div class="fw-semibold">{{ $row->dependents ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Kebutuhan Utama</div>
                        <div class="fw-semibold">{{ $row->main_needs ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Request For</div>
                        <div class="fw-semibold">{{ $row->request_for ?? '-' }}</div>
                    </div>

                    <div class="col-12">
                        <div class="text-muted small mb-1">Alamat</div>
                        <div class="p-2 bg-light rounded border">
                            {{ $row->address_detail ?? '-' }}
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="text-muted small mb-1">Alasan</div>
                        <div class="p-2 bg-light rounded border">
                            {{ $row->reason ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
