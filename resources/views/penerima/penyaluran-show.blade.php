@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-penerima', ['active' => 'penyaluran'])
@endsection

@section('content')
    @php
        use Carbon\Carbon;

        $status = $distribution->status ?? '-';

        $statusView = match ($status) {
            'canceled' => [
                'badge' => 'secondary',
                'icon' => 'fa-ban',
                'title' => 'Dibatalkan',
                'desc' => 'Penyaluran dibatalkan oleh petugas.',
            ],
            'scheduled', 'pending' => [
                'badge' => 'warning',
                'icon' => 'fa-calendar-check',
                'title' => 'Dijadwalkan',
                'desc' => 'Petugas sudah menjadwalkan pengantaran.',
            ],
            'in_transit', 'shipping' => [
                'badge' => 'primary',
                'icon' => 'fa-truck-fast',
                'title' => 'Dalam Pengantaran',
                'desc' => 'Bantuan sedang dibawa petugas menuju lokasi.',
            ],
            default => [
                'badge' => 'success',
                'icon' => 'fa-circle-check',
                'title' => 'Sudah Disalurkan',
                'desc' => 'Bantuan dicatat sudah selesai disalurkan.',
            ],
        };

        $jadwal = $distribution->scheduled_at ? Carbon::parse($distribution->scheduled_at) : null;
        $selesai = $distribution->distributed_at ? Carbon::parse($distribution->distributed_at) : null;

        $cabangName = $distribution->cabang->name ?? '-';
        $petugasName = $distribution->distributor->name ?? '-';

        $kategoriLabel = function ($cat) {
            return match ($cat) {
                'pangan_kemasan' => 'Pangan Kemasan',
                'pangan_segar' => 'Pangan Segar',
                'non_pangan' => 'Non Pangan',
                default => $cat ?? '-',
            };
        };
    @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h5 class="mb-1">
                    <i class="fa-solid fa-clipboard-list me-2 text-primary"></i>
                    Detail Penyaluran #{{ $distribution->id }}
                </h5>
                <small class="text-muted">
                    Cabang: <span class="fw-semibold">{{ $cabangName }}</span>
                    <span class="mx-1">•</span>
                    Petugas: <span class="fw-semibold">{{ $petugasName }}</span>
                </small>

                <div class="mt-2 d-flex flex-wrap gap-2">
                    <span class="badge text-bg-{{ $statusView['badge'] }}">
                        <i class="fa-solid {{ $statusView['icon'] }} me-1"></i>{{ $statusView['title'] }}
                    </span>

                    @if ($jadwal)
                        <span class="badge text-bg-light border">
                            <i class="fa-regular fa-clock me-1"></i>
                            Jadwal pengantaran: <span class="fw-semibold">{{ $jadwal->format('d M Y • H:i') }}</span>
                        </span>
                    @else
                        <span class="badge text-bg-light border">
                            <i class="fa-regular fa-clock me-1"></i>
                            Jadwal pengantaran: <span class="fw-semibold">Belum ditentukan</span>
                        </span>
                    @endif

                    @if ($selesai)
                        <span class="badge text-bg-light border">
                            <i class="fa-solid fa-circle-check me-1 text-success"></i>
                            Dicatat selesai: <span class="fw-semibold">{{ $selesai->format('d M Y • H:i') }}</span>
                        </span>
                    @endif
                </div>

                <div class="text-muted small mt-2">
                    {{ $statusView['desc'] }}
                </div>
            </div>

            <a href="{{ route('penerima.penyaluran') }}" class="btn btn-secondary rounded-pill px-4">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-3">
        {{-- DATA PENERIMA --}}
        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="fa-solid fa-user-check me-2 text-primary"></i>Data Penerima
                </div>
                <div class="card-body">
                    <div class="text-muted small">Nama</div>
                    <div class="fw-semibold mb-3">
                        {{ $distribution->recipient_name ?? ($distribution->request->user->name ?? '-') }}</div>

                    <div class="text-muted small">No. Telp</div>
                    <div class="fw-semibold mb-3">
                        {{ $distribution->recipient_phone ?? ($distribution->request->user->no_telp ?? '-') }}</div>

                    <div class="text-muted small">Alamat</div>
                    <div class="fw-semibold">
                        {{ $distribution->recipient_address ?? ($distribution->request->address_detail ?? '-') }}</div>

                    @if (!empty($distribution->note))
                        <hr>
                        <div class="text-muted small">Catatan dari Petugas</div>
                        <div class="fw-semibold">{{ $distribution->note }}</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- BARANG --}}
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-semibold d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fa-solid fa-box-open me-2 text-primary"></i>Barang yang Disalurkan
                    </div>
                    <span class="badge text-bg-light border">
                        <i class="fa-solid fa-layer-group me-1"></i>
                        {{ $distribution->items?->count() ?? 0 }} item
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Barang</th>
                                    <th>Kategori</th>
                                    <th class="text-end">Qty</th>
                                    <th style="width:160px;">Expired</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($distribution->items as $it)
                                    @php
                                        $exp = $it->expired_at ? Carbon::parse($it->expired_at) : null;
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">
                                            {{ $it->warehouseItem->name ?? '-' }}
                                            @if (!empty($it->note))
                                                <div class="text-muted small">
                                                    <i class="fa-regular fa-note-sticky me-1"></i>{{ $it->note }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge text-bg-light border">
                                                {{ $kategoriLabel($it->warehouseItem->category ?? null) }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-semibold" style="white-space:nowrap;">
                                            {{ (float) $it->qty }} {{ $it->unit }}
                                        </td>
                                        <td>
                                            {{ $exp ? $exp->format('d M Y') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada item.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-3 text-muted small">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        Jika ada perubahan jadwal atau pembatalan, status akan berubah sesuai update dari petugas.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
