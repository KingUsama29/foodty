@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'penyaluran'])
@endsection

@section('content')
    @php
        $status = $distribution->status ?? '-';

        $meta = match ($status) {
            'scheduled' => ['label' => 'Dijadwalkan', 'badge' => 'warning', 'icon' => 'fa-calendar-check'],
            'on_delivery' => ['label' => 'Dalam Pengantaran', 'badge' => 'primary', 'icon' => 'fa-truck-fast'],
            'completed' => ['label' => 'Sudah Disalurkan', 'badge' => 'success', 'icon' => 'fa-circle-check'],
            'canceled' => ['label' => 'Dibatalkan', 'badge' => 'secondary', 'icon' => 'fa-ban'],
            default => ['label' => strtoupper($status), 'badge' => 'dark', 'icon' => 'fa-circle-info'],
        };

        $scheduledAt = $distribution->scheduled_at ? \Carbon\Carbon::parse($distribution->scheduled_at) : null;
        $distributedAt = $distribution->distributed_at ? \Carbon\Carbon::parse($distribution->distributed_at) : null;

        $cabangName = $distribution->cabang->name ?? '-';
        $petugasName = $distribution->distributor->name ?? '-';
        $mainNeeds = $distribution->request->main_needs ?? '-';
    @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h5 class="mb-0 fw-bold">
                        <i class="fa-solid fa-receipt me-2 text-white"></i>
                        Detail Penyaluran #{{ $distribution->id }}
                    </h5>

                    <span class="badge bg-{{ $meta['badge'] }} rounded-pill px-3 py-2">
                        <i class="fa-solid {{ $meta['icon'] }} me-1 text-white"></i>
                        <span class="text-white">{{ $meta['label'] }}</span>
                    </span>
                </div>

                <div class="text-muted small mt-2">
                    <span class="me-2">
                        <i class="fa-solid fa-building-flag me-1 text-white"></i>
                        Cabang: <b>{{ $cabangName }}</b>
                    </span>
                    <span class="me-2">
                        <i class="fa-solid fa-user-gear me-1 text-white"></i>
                        Petugas: <b>{{ $petugasName }}</b>
                    </span>
                    <span>
                        <i class="fa-solid fa-bowl-food me-1 text-white"></i>
                        Request: <b>#{{ $distribution->food_request_id }}</b> • {{ $mainNeeds }}
                    </span>
                </div>

                {{-- timeline mini --}}
                <div class="mt-3 d-flex flex-wrap gap-2">
                    <span class="badge text-bg-light border rounded-pill px-3 py-2">
                        <i class="fa-solid fa-calendar-day me-1 text-white"></i>
                        Jadwal Pengantaran:
                        <b>{{ $scheduledAt ? $scheduledAt->format('d M Y • H:i') : '-' }}</b>
                    </span>

                    <span class="badge text-bg-light border rounded-pill px-3 py-2">
                        <i class="fa-solid fa-flag-checkered me-1 text-white"></i>
                        Selesai Dicatat:
                        <b>{{ $distributedAt ? $distributedAt->format('d M Y • H:i') : '-' }}</b>
                    </span>

                    <span class="badge text-bg-light border rounded-pill px-3 py-2">
                        <i class="fa-solid fa-diagram-project me-1 text-white"></i>
                        Alur: <b>Dijadwalkan → Dalam Pengantaran → Sudah Disalurkan</b>
                    </span>
                </div>
            </div>

            <a href="{{ route('petugas.data-penyaluran') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1 text-white"></i> Kembali
            </a>
        </div>
    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success shadow-sm d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-check text-white"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger shadow-sm d-flex align-items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-white"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- ACTIONS --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-wrap gap-2 align-items-center justify-content-between">
            <div class="fw-semibold">
                <i class="fa-solid fa-gears me-2 text-white"></i>
                Aksi Penyaluran
            </div>

            <div class="d-flex flex-wrap gap-2">
                @if ($status === 'scheduled')
                    {{-- PATCH route => wajib spoof method PATCH --}}
                    <form method="POST" action="{{ route('petugas.penyaluran.on_delivery', $distribution) }}">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-primary btn-sm rounded-pill px-3" type="submit">
                            <i class="fa-solid fa-truck-fast me-1 text-white"></i> Mulai Antar (OTW)
                        </button>
                    </form>

                    <form method="POST" action="{{ route('petugas.penyaluran.complete', $distribution) }}">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success btn-sm rounded-pill px-3" type="submit"
                            onclick="return confirm('Yakin tandai penyaluran ini sudah disalurkan?')">
                            <i class="fa-solid fa-circle-check me-1 text-white"></i> Tandai Selesai
                        </button>
                    </form>
                @elseif ($status === 'on_delivery')
                    <form method="POST" action="{{ route('petugas.penyaluran.complete', $distribution) }}">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success btn-sm rounded-pill px-3" type="submit"
                            onclick="return confirm('Yakin penyaluran sudah sampai & selesai disalurkan?')">
                            <i class="fa-solid fa-flag-checkered me-1 text-white"></i> Selesai Disalurkan
                        </button>
                    </form>
                @endif

                @if (in_array($status, ['scheduled', 'on_delivery', 'completed']))
                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3" data-bs-toggle="collapse"
                        data-bs-target="#cancelBox">
                        <i class="fa-solid fa-rotate-left me-1 text-white"></i> Batalkan / Rollback
                    </button>
                @endif
            </div>
        </div>

        @if (in_array($status, ['scheduled', 'on_delivery', 'completed']))
            <div class="collapse" id="cancelBox">
                <div class="card-body border-top">
                    <div class="alert alert-warning mb-3">
                        <i class="fa-solid fa-triangle-exclamation me-1 text-white"></i>
                        Cancel akan <b>mengembalikan stok</b> + membuat movement <b>IN</b> dengan source
                        <b>distribution_cancel</b>.
                    </div>

                    <form method="POST" action="{{ route('petugas.penyaluran.cancel', $distribution) }}" class="row g-2">
                        @csrf
                        <div class="col-md-9">
                            <input class="form-control" name="reason" placeholder="Alasan cancel (wajib)..." required
                                maxlength="500">
                            <div class="text-muted small mt-1">
                                <i class="fa-solid fa-circle-info me-1 text-white"></i>
                                Alasan akan dicatat di note agar audit jelas.
                            </div>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button class="btn btn-danger rounded-pill" type="submit"
                                onclick="return confirm('Yakin batalkan penyaluran ini? Stok akan rollback.')">
                                <i class="fa-solid fa-trash-can me-1 text-white"></i> Konfirmasi Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    {{-- INFO --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="fa-solid fa-user me-2 text-white"></i> Data Penerima
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="text-muted small">Nama</div>
                        <div class="fw-semibold">{{ $distribution->recipient_name ?? '-' }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small">No. Telp</div>
                        <div class="fw-semibold">{{ $distribution->recipient_phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-muted small">Alamat</div>
                        <div>{{ $distribution->recipient_address ?? '-' }}</div>
                    </div>

                    @if ($distribution->note)
                        <hr>
                        <div class="text-muted small">Catatan Petugas</div>
                        <div>{{ $distribution->note }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="fa-solid fa-file-circle-check me-2 text-white"></i> Data Pengajuan
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="text-muted small">Request</div>
                        <div class="fw-semibold">
                            #{{ $distribution->food_request_id }} • {{ $mainNeeds }}
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small">Cabang</div>
                        <div class="fw-semibold">{{ $cabangName }}</div>
                    </div>
                    <div>
                        <div class="text-muted small">Petugas</div>
                        <div class="fw-semibold">{{ $petugasName }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ITEMS --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold d-flex align-items-center justify-content-between">
            <div>
                <i class="fa-solid fa-boxes-stacked me-2 text-white"></i> Barang yang Disalurkan
            </div>
            <span class="badge text-bg-light border">
                {{ $distribution->items->count() }} item
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th>Expired</th>
                            <th class="text-end">Qty</th>
                            <th>Unit</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($distribution->items as $it)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $it->warehouseItem->name ?? 'Item' }}
                                    <div class="text-muted small">
                                        {{ $it->warehouseItem->category ?? '' }}
                                    </div>
                                </td>
                                <td style="white-space:nowrap;">
                                    {{ $it->expired_at ? \Carbon\Carbon::parse($it->expired_at)->format('d M Y') : 'Tanpa expired' }}
                                </td>
                                <td class="text-end fw-semibold" style="white-space:nowrap;">
                                    {{ (float) $it->qty }}
                                </td>
                                <td>{{ $it->unit }}</td>
                                <td class="text-muted small">
                                    {{ $it->note ? \Illuminate\Support\Str::limit($it->note, 80) : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada item.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
