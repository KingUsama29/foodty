@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'stok-barang'])
@endsection

@section('content')
    @php
        $today = \Carbon\Carbon::today();
        $soonLimit = $today->copy()->addDays(180); // 6 bulan
        $expiredTerdekatDt = $expiredTerdekat ? \Carbon\Carbon::parse($expiredTerdekat) : null;

        $kategoriLabel = match ($item->category ?? null) {
            'pangan_kemasan' => 'Pangan Kemasan',
            'pangan_segar' => 'Pangan Segar',
            'non_pangan' => 'Non Pangan',
            default => $item->category ?? '-',
        };
    @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div>
                <h5 class="mb-1">
                    <i class="fa-solid fa-boxes-stacked me-2 text-primary"></i>Detail Stok Barang
                </h5>
                <div class="text-muted small">
                    Stok per batch (warehouse_stocks) + riwayat perubahan stok (warehouse_movements), termasuk rollback.
                </div>

                <div class="mt-2 d-flex flex-wrap gap-2">
                    <span class="badge text-bg-light border">
                        <i class="fa-solid fa-building-flag me-1"></i>{{ $cabang->name }}
                    </span>
                    <span class="badge text-bg-light border">
                        <i class="fa-solid fa-box me-1"></i>{{ $item->name }}
                    </span>
                    <span class="badge text-bg-light border">
                        <i class="fa-solid fa-tag me-1"></i>{{ $kategoriLabel }}
                    </span>
                </div>
            </div>

            <a href="{{ route('admin.stok-barang') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-1">Total Stok Saat Ini</div>
                    <div class="fs-4 fw-semibold">{{ (float) $totalQty }} {{ $unit }}</div>

                    <div class="text-muted small mt-2">
                        <i class="fa-solid fa-calendar-days me-1"></i>
                        Expired terdekat:
                        <span class="fw-semibold">
                            {{ $expiredTerdekatDt ? $expiredTerdekatDt->format('d M Y') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <div class="fw-semibold">
                        <i class="fa-solid fa-layer-group me-2 text-primary"></i>Stok Per Batch (warehouse_stocks)
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Expired</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($batches as $b)
                                    @php
                                        $exp = $b->expired_at ? \Carbon\Carbon::parse($b->expired_at) : null;

                                        $badge = 'text-bg-secondary';
                                        $status = 'Tanpa expired';

                                        if ($exp) {
                                            if ($exp->lt($today)) {
                                                $badge = 'text-bg-danger';
                                                $status = 'Expired';
                                            } elseif ($exp->lte($soonLimit)) {
                                                $badge = 'text-bg-warning';
                                                $status = 'Hampir expired';
                                            } else {
                                                $badge = 'text-bg-success';
                                                $status = 'Aman';
                                            }
                                        }
                                    @endphp

                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $exp ? $exp->format('d M Y') : '-' }}</div>
                                            <div class="text-muted small">Stock ID: {{ $b->id }}</div>
                                        </td>
                                        <td class="text-end fw-semibold">
                                            {{ (float) $b->qty }} {{ $b->unit }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $badge }}">{{ $status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Tidak ada batch stok.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-3 text-muted small">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        Ini kondisi stok terkini per batch. Perubahan stok lengkap ada di tabel Riwayat Penyaluran.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MOVEMENTS --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="fw-semibold">
                <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Riwayat Perubahan Stok (warehouse_movements)
            </div>

            <div class="d-flex flex-wrap gap-2">
                <span class="badge text-bg-success"><i class="fa-solid fa-arrow-down me-1"></i>IN</span>
                <span class="badge text-bg-danger"><i class="fa-solid fa-arrow-up me-1"></i>OUT</span>
                <span class="badge text-bg-secondary"><i class="fa-solid fa-sliders me-1"></i>ADJUST</span>
                <span class="badge text-bg-warning"><i class="fa-solid fa-rotate-left me-1"></i>ROLLBACK</span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Tipe</th>
                            <th>Expired</th>
                            <th class="text-end">Qty</th>
                            <th>Petugas</th>
                            <th>Source</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movements as $m)
                            @php
                                $moved = $m->moved_at ? \Carbon\Carbon::parse($m->moved_at) : null;

                                $type = $m->type ?? '-';
                                $exp = $m->expired_at ? \Carbon\Carbon::parse($m->expired_at) : null;

                                // ✅ rollback detector (cukup aman)
                                $isRollback =
                                    !empty($m->source_type) &&
                                    \Illuminate\Support\Str::contains($m->source_type, ['_cancel', 'rollback']);

                                // ✅ badge & label tampil
                                if ($isRollback) {
                                    $label = 'ROLLBACK';
                                    $badgeClass = 'text-bg-warning';
                                    $icon = 'fa-rotate-left';
                                } else {
                                    $label = strtoupper($type);
                                    if ($type === 'in') {
                                        $badgeClass = 'text-bg-success';
                                        $icon = 'fa-arrow-down';
                                    } elseif ($type === 'out') {
                                        $badgeClass = 'text-bg-danger';
                                        $icon = 'fa-arrow-up';
                                    } else {
                                        $badgeClass = 'text-bg-secondary';
                                        $icon = 'fa-sliders';
                                    }
                                }

                                // qty prefix biar enak dibaca (rollback tetep keliatan netral)
                                $qtyPrefix = $type === 'in' ? '+' : ($type === 'out' ? '-' : '');
                            @endphp

                            <tr>
                                <td style="white-space:nowrap;">
                                    <div class="fw-semibold">{{ $moved ? $moved->format('d M Y') : '-' }}</div>
                                    <div class="text-muted small">{{ $moved ? $moved->format('H:i') : '' }}</div>
                                </td>

                                <td>
                                    <span class="badge {{ $badgeClass }}">
                                        <i class="fa-solid {{ $icon }} me-1"></i>{{ $label }}
                                    </span>

                                    @if ($isRollback)
                                        <div class="text-muted small mt-1">
                                            asal:
                                            {{ $m->source_type ?? '-' }}{{ $m->source_id ? ' #' . $m->source_id : '' }}
                                        </div>
                                    @endif
                                </td>


                                <td>{{ $exp ? $exp->format('d M Y') : '-' }}</td>

                                <td class="text-end fw-semibold" style="white-space:nowrap;">
                                    {{ $qtyPrefix }}{{ (float) $m->qty }} {{ $m->unit }}
                                </td>

                                <td class="fw-semibold">{{ $m->created_by_name ?? '-' }}</td>

                                <td style="white-space:nowrap;">
                                    <span class="badge text-bg-light border">
                                        {{ $m->source_type ?? '-' }}{{ $m->source_id ? ' #' . $m->source_id : '' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="text-muted small">
                                        {{ $m->note ? \Illuminate\Support\Str::limit($m->note, 70) : '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada riwayat movement untuk barang ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white">
            {{ $movements->links() }}
        </div>
    </div>
@endsection
