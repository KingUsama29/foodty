@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-penerima', ['active' => 'penyaluran'])
@endsection

@section('content')
    @php
        use Carbon\Carbon;

        $now = Carbon::now();

        // helper status biar penerima ngerti
        $statusMeta = function ($d) use ($now) {
            $status = $d->status ?? '-';

            if ($status === 'canceled') {
                return [
                    'badge' => 'secondary',
                    'icon' => 'fa-ban',
                    'title' => 'Dibatalkan',
                    'desc' => 'Penyaluran dibatalkan. Jika perlu, buat pengajuan lagi / hubungi petugas.',
                ];
            }

            // Kalau nanti kamu tambahin status lain, ini tetap aman:
            if (in_array($status, ['scheduled', 'pending'])) {
                return [
                    'badge' => 'warning',
                    'icon' => 'fa-calendar-check',
                    'title' => 'Dijadwalkan',
                    'desc' => 'Petugas sudah menjadwalkan pengantaran. Menunggu hari H.',
                ];
            }

            if (in_array($status, ['in_transit', 'shipping'])) {
                return [
                    'badge' => 'primary',
                    'icon' => 'fa-truck-fast',
                    'title' => 'Dalam Pengantaran',
                    'desc' => 'Bantuan sedang dibawa petugas menuju lokasi.',
                ];
            }

            // default untuk completed
            return [
                'badge' => 'success',
                'icon' => 'fa-circle-check',
                'title' => 'Sudah Disalurkan',
                'desc' => 'Bantuan sudah dicatat sebagai selesai disalurkan oleh petugas.',
            ];
        };
    @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-truck-ramp-box fa-lg text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Penyaluran Saya</h5>
                    <small class="text-muted">
                        Pantau <span class="fw-semibold">jadwal pengantaran</span>, <span class="fw-semibold">status</span>,
                        dan detail bantuan yang akan / sudah disalurkan.
                    </small>
                </div>
            </div>

            {{-- Search --}}
            <form class="d-flex gap-2" method="GET" action="">
                <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control"
                    placeholder="Cari ID / cabang / petugas..." style="max-width:320px;">
                <button class="btn btn-primary rounded-pill px-4">
                    Cari
                </button>
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary rounded-pill px-4">Reset</a>
            </form>
        </div>
    </div>

    {{-- LEGEND / PENJELASAN STATUS (biar ga bingung) --}}
    <div class="alert alert-light border shadow-sm mb-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
            <div class="fw-semibold">
                <i class="fa-solid fa-circle-info me-1 text-primary"></i>
                Arti Status Penyaluran
            </div>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge text-bg-warning">
                    <i class="fa-solid fa-calendar-check me-1"></i> Dijadwalkan
                </span>
                <span class="badge text-bg-primary">
                    <i class="fa-solid fa-truck-fast me-1"></i> Dalam Pengantaran
                </span>
                <span class="badge text-bg-success">
                    <i class="fa-solid fa-circle-check me-1"></i> Sudah Disalurkan
                </span>
                <span class="badge text-bg-secondary">
                    <i class="fa-solid fa-ban me-1"></i> Dibatalkan
                </span>
            </div>
        </div>
        <div class="text-muted small mt-2">
            <span class="fw-semibold">Jadwal Pengantaran</span> = estimasi waktu petugas mengantar bantuan ke lokasi.
            Jika jadwal berubah, petugas bisa memperbarui penyaluran.
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:90px;">ID</th>
                            <th>Cabang</th>
                            <th>Petugas</th>
                            <th style="width:240px;">Jadwal Pengantaran</th>
                            <th style="width:240px;">Status</th>
                            <th class="text-end" style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $d)
                            @php
                                $meta = $statusMeta($d);

                                $jadwal = $d->scheduled_at ? Carbon::parse($d->scheduled_at) : null;
                                $selesai = $d->distributed_at ? Carbon::parse($d->distributed_at) : null;

                                $jadwalText = $jadwal ? $jadwal->format('d M Y • H:i') : '-';
                                $selesaiText = $selesai ? $selesai->format('d M Y • H:i') : null;

                                $cabangName = $d->cabang->name ?? '-';
                                $petugasName = $d->distributor->name ?? '-';
                            @endphp

                            <tr>
                                <td class="fw-semibold">#{{ $d->id }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $cabangName }}</div>
                                    <div class="text-muted small">
                                        <i class="fa-solid fa-file-circle-check me-1"></i>
                                        Request: #{{ $d->food_request_id ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $petugasName }}</div>
                                    <div class="text-muted small">
                                        <i class="fa-solid fa-id-badge me-1"></i>
                                        Petugas Cabang
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        <i class="fa-regular fa-clock me-1 text-primary"></i>
                                        {{ $jadwalText }}
                                    </div>
                                    <div class="text-muted small">
                                        Jadwal pengantaran ke alamat penerima
                                    </div>
                                </td>

                                <td>
                                    <span class="badge text-bg-{{ $meta['badge'] }}">
                                        <i class="fa-solid {{ $meta['icon'] }} me-1"></i>{{ $meta['title'] }}
                                    </span>

                                    <div class="text-muted small mt-1">
                                        {{ $meta['desc'] }}
                                    </div>

                                    @if ($selesaiText)
                                        <div class="text-muted small mt-1">
                                            <i class="fa-solid fa-circle-check me-1 text-success"></i>
                                            Dicatat selesai: <span class="fw-semibold">{{ $selesaiText }}</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('penerima.penyaluran.show', $d) }}"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                        <i class="fa-solid fa-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada data penyaluran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($list, 'links'))
                <div class="p-3">
                    {{ $list->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
