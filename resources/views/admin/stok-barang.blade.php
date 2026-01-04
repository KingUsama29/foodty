@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'stok-barang'])
@endsection

@section('content')
    @php
        $today = \Carbon\Carbon::today();
        $soonLimit = $today->copy()->addDays(30);
    @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <h5 class="mb-1">
                        <i class="fa-solid fa-boxes-stacked me-2 text-primary"></i>Stok Barang Semua Cabang
                    </h5>
                    <small class="text-muted">Dikelompokkan per cabang biar admin gampang pantau</small>
                </div>

                {{-- Legend --}}
                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                    <span class="badge rounded-pill text-bg-secondary">
                        <i class="fa-solid fa-circle-info me-1"></i>Info
                    </span>
                    <span class="badge rounded-pill text-bg-warning">
                        <i class="fa-regular fa-clock me-1"></i>Expired &lt; 6 Bulan
                    </span>
                    <span class="badge rounded-pill text-bg-danger">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i>Expired lewat
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if ($stok->isEmpty())
        <div class="alert alert-warning">
            <i class="fa-solid fa-triangle-exclamation me-1"></i>
            Belum ada data stok di gudang cabang.
        </div>
    @else
        <div class="accordion" id="accordionCabang">
            @foreach ($stok as $cabangId => $items)
                @php
                    $namaCabang = $items->first()->nama_cabang;

                    // rekap cepat
                    $totalQtyCabang = $items->sum('total_qty');
                    $totalItemCabang = $items->count();

                    $expiredSoon = 0;
                    $expiredOver = 0;

                    foreach ($items as $it) {
                        if ($it->expired_terdekat) {
                            $d = \Carbon\Carbon::parse($it->expired_terdekat);
                            if ($d->lt($today)) {
                                $expiredOver++;
                            } elseif ($d->lte($soonLimit)) {
                                $expiredSoon++;
                            }
                        }
                    }
                @endphp

                <div class="accordion-item mb-2 border rounded shadow-sm">
                    <h2 class="accordion-header" id="head{{ $cabangId }}">
                        <button
                            class="accordion-button collapsed fw-semibold d-flex align-items-center justify-content-between"
                            type="button" data-bs-toggle="collapse" data-bs-target="#cabang{{ $cabangId }}"
                            aria-expanded="false" aria-controls="cabang{{ $cabangId }}">

                            <span class="d-flex align-items-center">
                                <i class="fa-solid fa-warehouse me-2 text-primary"></i>
                                {{ $namaCabang }}
                            </span>

                            <span class="ms-2 d-none d-md-inline">
                                <span class="badge rounded-pill text-bg-primary me-1">
                                    {{ $totalItemCabang }} item
                                </span>
                                <span class="badge rounded-pill text-bg-secondary me-1">
                                    {{ $totalQtyCabang }} total qty
                                </span>

                                @if ($expiredOver > 0)
                                    <span class="badge rounded-pill text-bg-danger me-1">
                                        {{ $expiredOver }} expired
                                    </span>
                                @endif

                                @if ($expiredSoon > 0)
                                    <span class="badge rounded-pill text-bg-warning">
                                        {{ $expiredSoon }} hampir expired
                                    </span>
                                @endif
                            </span>
                        </button>
                    </h2>

                    <div id="cabang{{ $cabangId }}" class="accordion-collapse collapse"
                        aria-labelledby="head{{ $cabangId }}" data-bs-parent="#accordionCabang">
                        <div class="accordion-body">

                            {{-- rekap versi mobile --}}
                            <div class="d-md-none mb-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge rounded-pill text-bg-primary">{{ $totalItemCabang }} item</span>
                                    <span class="badge rounded-pill text-bg-secondary">{{ $totalQtyCabang }} total
                                        qty</span>
                                    @if ($expiredOver > 0)
                                        <span class="badge rounded-pill text-bg-danger">{{ $expiredOver }} expired</span>
                                    @endif
                                    @if ($expiredSoon > 0)
                                        <span class="badge rounded-pill text-bg-warning">{{ $expiredSoon }} hampir
                                            expired</span>
                                    @endif
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">Barang</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center" class="text-end">Total Stok</th>
                                            <th class="text-center">Expired Terdekat</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center" style="width:140px;">Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $row)
                                            @php
                                                $expiredText = '-';
                                                $badge = 'text-bg-secondary';
                                                $status = 'Aman';

                                                if ($row->expired_terdekat) {
                                                    $dt = \Carbon\Carbon::parse($row->expired_terdekat);
                                                    $expiredText = $dt->format('d M Y');

                                                    if ($dt->lt($today)) {
                                                        $badge = 'text-bg-danger';
                                                        $status = 'Expired';
                                                    } elseif ($dt->lte($soonLimit)) {
                                                        $badge = 'text-bg-warning';
                                                        $status = 'Hampir Expired';
                                                    } else {
                                                        $badge = 'text-bg-success';
                                                        $status = 'Aman';
                                                    }
                                                } else {
                                                    $badge = 'text-bg-secondary';
                                                    $status = 'Tanpa expired';
                                                }
                                            @endphp

                                            <tr>
                                                <td class="text-center fw-semibold">{{ $row->nama_barang }}</td>
                                                <td class="text-center">
                                                    <span class="badge text-bg-light border">
                                                        {{ $row->kategori }}
                                                    </span>
                                                </td>
                                                <td class="text-center text-end fw-semibold">
                                                    {{ $row->total_qty }} {{ $row->unit }}
                                                </td>
                                                <td class="text-center">{{ $expiredText }}</td>
                                                <td class="text-center">
                                                    <span class="badge {{ $badge }}">{{ $status }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.stok-barang.detail', [$row->cabang_id, $row->warehouse_item_id]) }}"
                                                        class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                        <i class="fa-solid fa-eye me-1"></i> Detail
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
