@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'penyaluran-requests'])
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h5 class="mb-1">Pengajuan Siap Disalurkan</h5>
                <small class="text-muted">Daftar pengajuan approved yang belum pernah disalurkan</small>
            </div>
            <a href="{{ route('petugas.data-penyaluran') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form class="row g-2" method="GET">
                <div class="col-md-10">
                    <input class="form-control" name="q" value="{{ $q }}"
                        placeholder="Cari nama / ID / kebutuhan / kategori...">
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary rounded-pill" type="submit">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:90px;">ID</th>
                            <th style="min-width:280px;">Pemohon</th>
                            <th style="width:160px;">Kategori</th>
                            <th style="width:160px;">Menunggu</th>
                            <th style="min-width:240px;">Kebutuhan & Alasan</th>
                            <th class="text-end" style="width:220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $r)
                            @php
                                $baseDate = $r->reviewed_at ?? $r->created_at;
                                $now = now();

                                if (!$baseDate) {
                                    $waitLabel = 'baru saja';
                                    $hours = 0;
                                } else {
                                    if ($baseDate->greaterThan($now)) {
                                        $baseDate = $now;
                                    }

                                    // label human-friendly: menit/jam/hari/bulan/tahun (tanpa desimal)
                                    $waitLabel = $baseDate->diffForHumans($now, [
                                        'parts' => 1,
                                        'short' => true,
                                        'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                                    ]);

                                    $hours = $baseDate->diffInHours($now);
                                }

                                // badge urgency (ubah threshold kalau mau)
                                if ($hours >= 24 * 14) {
                                    $badgeClass = 'bg-danger';
                                    $badgeText = 'Urgent';
                                } elseif ($hours >= 24 * 7) {
                                    $badgeClass = 'bg-warning text-dark';
                                    $badgeText = 'Menunggu';
                                } else {
                                    $badgeClass = 'bg-success';
                                    $badgeText = 'Baru';
                                }

                                // ringkas alamat & alasan biar ga kepanjangan
                                $addr = trim((string) $r->address_detail);
                                $addrShort = strlen($addr) > 70 ? substr($addr, 0, 70) . '…' : $addr;

                                $reason = trim((string) $r->reason);
                                $reasonShort = strlen($reason) > 70 ? substr($reason, 0, 70) . '…' : $reason;

                                // data kontak (kalau ada)
                                $phone = $r->user->no_telp ?? ($r->recipient_phone ?? null);
                            @endphp

                            <tr>
                                <td class="fw-semibold">#{{ $r->id }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $r->user->name ?? ($r->recipient_name ?? '-') }}</div>
                                    <div class="small text-muted">
                                        <i class="fa-solid fa-location-dot me-1"></i>{{ $addrShort ?: '-' }}
                                    </div>

                                    <div class="small mt-1 d-flex flex-wrap gap-2">
                                        <span class="badge bg-light text-dark border">
                                            <i class="fa-solid fa-people-roof me-1"></i>Tanggungan:
                                            {{ (int) $r->dependents }}
                                        </span>

                                        @if ($phone)
                                            <span class="badge bg-light text-dark border">
                                                <i class="fa-solid fa-phone me-1"></i>{{ $phone }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-secondary">{{ $r->category }}</span>
                                    <div class="small text-muted mt-1">
                                        Untuk: {{ $r->request_for }}
                                    </div>
                                </td>

                                <td>
                                    <span class="badge {{ $badgeClass }}">{{ $badgeText }} •
                                        {{ $waitLabel }}</span>
                                    <div class="small text-muted mt-1">
                                        {{ $r->reviewed_at ?? null ? 'Sejak review' : 'Sejak dibuat' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold small">{{ $r->main_needs }}</div>
                                    <div class="small text-muted">{{ $reasonShort ?: '-' }}</div>
                                </td>

                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                                        {{-- tombol detail (kalau route kamu ada) --}}
                                        <a href="{{ route('petugas.pengajuan.detail', $r->id) }}"
                                            class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                            <i class="fa-solid fa-eye me-1"></i> Detail
                                        </a>

                                        {{-- tombol salurkan prefill --}}
                                        <a href="{{ route('petugas.penyaluran-create', ['food_request_id' => $r->id]) }}"
                                            class="btn btn-success btn-sm rounded-pill px-3">
                                            <i class="fa-solid fa-truck-fast me-1"></i> Salurkan
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-4 text-muted">
                                    Tidak ada pengajuan approved yang siap disalurkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($requests->hasPages())
            <div class="card-footer">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
@endsection
