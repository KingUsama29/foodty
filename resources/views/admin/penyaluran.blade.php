@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'penyaluran'])
@endsection

@section('content')
    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-start">
                <div class="me-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle"
                        style="width:44px;height:44px;">
                        <i class="fa-solid fa-clipboard-list text-primary"></i>
                    </span>
                </div>

                <div>
                    <h5 class="mb-1">Audit Penyaluran Cabang</h5>
                    <div class="text-muted small">
                        Monitoring pusat untuk seluruh penyaluran cabang (barang keluar dari gudang cabang).
                    </div>

                    <div class="mt-2 d-flex flex-wrap gap-2">
                        <span class="badge text-bg-light border">
                            <i class="fa-solid fa-building me-1"></i>
                            Total Cabang: {{ $cabangs->count() }}
                        </span>

                        <span class="badge text-bg-light border">
                            <i class="fa-solid fa-list-check me-1"></i>
                            Data tampil: {{ $audit->count() }}
                        </span>

                        @if (!empty($cabangId))
                            <span class="badge text-bg-primary">
                                <i class="fa-solid fa-filter me-1"></i>
                                Filter Cabang: {{ $cabangs->firstWhere('id', (int) $cabangId)?->name ?? 'Dipilih' }}
                            </span>
                        @endif

                        @if (!empty($q))
                            <span class="badge text-bg-secondary">
                                <i class="fa-solid fa-magnifying-glass me-1"></i>
                                Pencarian: "{{ $q }}"
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-end">
                <span class="badge text-bg-light border">
                    <i class="fa-solid fa-shield-halved me-1"></i> Admin Pusat (Read-only)
                </span>
            </div>
        </div>
    </div>

    {{-- FILTER (VIEW-ONLY) --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form class="row g-2 align-items-end" method="GET">
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">Cabang</label>
                    <select name="cabang_id" class="form-select form-select-sm">
                        <option value="">Semua Cabang</option>
                        @foreach ($cabangs as $c)
                            <option value="{{ $c->id }}" @selected(($cabangId ?? '') == $c->id)>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label small text-muted mb-1">Pencarian</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control"
                            placeholder="Cari petugas / barang / kategori / catatan...">
                    </div>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-sm btn-primary w-100">
                        <i class="fa-solid fa-filter me-1"></i> Terapkan
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE AUDIT --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="fw-semibold">
                <i class="fa-solid fa-truck-ramp-box me-2 text-primary"></i>
                Riwayat Penyaluran (Barang Keluar)
            </div>
            <small class="text-muted">
                Sumber data: <span class="fw-semibold">warehouse_movements</span> (type = out)
            </small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="min-width:140px;">Waktu</th>
                            <th>Cabang</th>
                            <th>Petugas</th>
                            <th>Pemohon</th>
                            <th>Barang</th>
                            <th class="text-end">Qty</th>
                            <th>Expired</th>
                            <th>Catatan</th>
                            <th class="text-end" style="width:120px;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($audit as $row)
                            @php
                                $expired = $row->expired_at ? \Carbon\Carbon::parse($row->expired_at) : null;
                                $today = \Carbon\Carbon::today();

                                $daysLeft = $expired ? $today->diffInDays($expired, false) : null;
                                $expiredAlready = $expired ? $expired->isPast() : false;
                                // Hampir expired kalau < 6 bulan (180 hari)
                                $nearExpired = $expired
                                    ? $daysLeft !== null && $daysLeft <= 180 && $daysLeft >= 0
                                    : false;
                            @endphp

                            <tr>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $row->moved_at ? \Carbon\Carbon::parse($row->moved_at)->format('d M Y') : '-' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $row->moved_at ? \Carbon\Carbon::parse($row->moved_at)->format('H:i') : '' }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge text-bg-light border">
                                        <i class="fa-solid fa-location-dot me-1"></i>{{ $row->nama_cabang ?? '-' }}
                                    </span>
                                </td>

                                <td class="fw-semibold">{{ $row->nama_petugas ?? '-' }}</td>

                                <td>
                                    {{ $row->nama_penerima ?? '-' }}
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $row->nama_barang ?? '-' }}</div>
                                    <small class="text-muted">
                                        <i class="fa-solid fa-tag me-1"></i>{{ $row->kategori ?? '-' }}
                                    </small>
                                </td>

                                <td class="text-end">
                                    <span class="fw-semibold">{{ $row->qty ?? 0 }}</span>
                                    <span class="text-muted">{{ $row->unit ?? '' }}</span>
                                </td>

                                <td>
                                    @if (!$expired)
                                        <span class="text-muted">-</span>
                                    @else
                                        <div class="fw-semibold">{{ $expired->format('d M Y') }}</div>

                                        @if ($expiredAlready)
                                            <span class="badge text-bg-danger">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> Expired
                                            </span>
                                        @elseif ($nearExpired)
                                            <span class="badge text-bg-warning">
                                                <i class="fa-solid fa-clock me-1"></i> Hampir expired
                                            </span>
                                        @else
                                            <span class="badge text-bg-success">
                                                <i class="fa-solid fa-circle-check me-1"></i> Aman
                                            </span>
                                        @endif
                                    @endif
                                </td>

                                <td style="max-width:260px;">
                                    <small class="text-muted">
                                        {{ $row->note ? \Illuminate\Support\Str::limit($row->note, 45) : '-' }}
                                    </small>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('admin.penyaluran.detail', $row->id) }}"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <div class="mb-2">
                                        <i class="fa-solid fa-folder-open fa-lg"></i>
                                    </div>
                                    Belum ada riwayat penyaluran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white">
            {{ $audit->links() }}
        </div>
    </div>
@endsection
