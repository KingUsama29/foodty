@extends('layouts.dashboard')

@section('sidebar-menu')
    @php
        $status = auth()->user()->latestRecipientVerification?->verification_status ?? 'pending';
    @endphp
    @include('partials.sidebar-penerima', ['active' => 'riwayat'])
@endsection

@section('content')
    <div class="container py-4">

        <div class="d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center mb-3">
            <div>
                <h4 class="mb-1">Riwayat Pengajuan</h4>
                <div class="text-muted" style="font-size: 14px;">
                    Lihat semua pengajuan bantuan yang pernah kamu kirim.
                </div>
            </div>

            <form class="d-flex gap-2" method="GET">
                <input name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Cari kategori / alasan..." style="max-width: 260px;">
                <button class="btn btn-primary">Cari</button>
            </form>
        </div>

        {{-- Filter chips --}}
        <div class="d-flex gap-2 flex-wrap mb-4">
            @php $active = request('status'); @endphp

            <a class="btn btn-sm {{ $active == null ? 'btn-dark' : 'btn-outline-dark' }}"
                href="{{ route('penerima.riwayat', array_merge(request()->except('page'), ['status' => null])) }}">
                Semua
            </a>

            @foreach (['pending' => 'Pending', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'] as $key => $label)
                <a class="btn btn-sm {{ $active === $key ? 'btn-dark' : 'btn-outline-dark' }}"
                    href="{{ route('penerima.riwayat', array_merge(request()->except('page'), ['status' => $key])) }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if ($requests->count() === 0)
            {{-- Empty state --}}
            <div class="card p-4 text-center">
                <div style="font-size: 18px;" class="mb-1">Belum ada pengajuan</div>
                <div class="text-muted mb-3">Kalau kamu butuh bantuan, kamu bisa mulai ajukan sekarang.</div>
                <a href="{{ route('penerima.pengajuan.index') }}" class="btn btn-primary">
                    Ajukan Bantuan
                </a>
            </div>
        @else
            {{-- Card list --}}
            <div class="d-grid gap-3">
                @foreach ($requests as $item)
                    @php
                        $status = $item->status ?? 'pending';

                        $badgeClass = match ($status) {
                            'approved' => 'bg-success',
                            'rejected' => 'bg-danger',
                            default => 'bg-warning text-dark',
                        };

                        $statusText = match ($status) {
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            default => 'Menunggu',
                        };

                        $statusIcon = match ($status) {
                            'approved' => 'fa-circle-check',
                            'rejected' => 'fa-circle-xmark',
                            default => 'fa-clock',
                        };

                        $thumb = !empty($item->file_path) ? asset('storage/' . $item->file_path) : null;

                        // FA 6.5.1 FREE safe
                        $catIcon = match ($item->category) {
                            'lansia' => 'fa-person-walking-with-cane',
                            'ibu_balita' => 'fa-baby',
                            'bencana' => 'fa-house-damage',
                            'kehilangan_pekerjaan' => 'fa-briefcase',
                            'yatim_piatu' => 'fa-user-group',
                            'tunawisma' => 'fa-house-user',
                            default => 'fa-hand-holding-heart',
                        };
                    @endphp

                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-3">
                            <div class="d-flex gap-3 align-items-center">

                                {{-- THUMBNAIL --}}
                                <div class="flex-shrink-0">
                                    @if ($thumb)
                                        <img src="{{ $thumb }}" alt="Bukti"
                                            class="rounded-4 border object-fit-cover" style="width:88px;height:88px;">
                                    @else
                                        <div class="rounded-4 border bg-light d-flex align-items-center justify-content-center text-muted"
                                            style="width:88px;height:88px;">
                                            <i class="fa-regular fa-image fs-4"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- CONTENT --}}
                                <div class="flex-grow-1">

                                    {{-- TOP --}}
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div>
                                            <div class="text-muted small">
                                                <i class="fa-regular fa-clock me-1"></i>
                                                {{ optional($item->created_at)->format('d M Y, H:i') }}
                                            </div>

                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                <span class="badge text-bg-light rounded-pill px-2 py-2">
                                                    <i class="fa-solid {{ $catIcon }}"></i>
                                                </span>

                                                <div class="fw-semibold text-capitalize" style="font-size: 17px;">
                                                    {{ $item->category ?? 'Pengajuan Bantuan' }}
                                                </div>
                                            </div>
                                        </div>

                                        <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
                                            <i class="fa-solid {{ $statusIcon }} me-1"></i>
                                            {{ $statusText }}
                                        </span>
                                    </div>

                                    {{-- MID: pills --}}
                                    <div class="d-flex gap-2 flex-wrap mt-2">
                                        <span class="badge text-bg-light border rounded-pill px-3 py-2">
                                            <i class="fa-solid fa-box-open me-1"></i>
                                            <span class="text-muted">Utama:</span>
                                            <span class="fw-semibold text-dark">{{ $item->main_needs ?? '-' }}</span>
                                        </span>

                                        <span class="badge text-bg-light border rounded-pill px-3 py-2">
                                            <i class="fa-solid fa-users me-1"></i>
                                            <span class="text-muted">Tanggungan:</span>
                                            <span class="fw-semibold text-dark">{{ $item->dependents ?? 0 }}</span>
                                        </span>
                                    </div>

                                    {{-- BOTTOM --}}
                                    <div class="d-flex justify-content-between align-items-end gap-2 mt-2">
                                        <div class="text-muted small"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <i class="fa-regular fa-note-sticky me-1"></i>
                                            {{ $item->reason ?? '-' }}
                                        </div>

                                        <a href="{{ route('penerima.riwayat.show', $item->id) }}"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-3 flex-shrink-0">
                                            Detail <i class="fa-solid fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        @endif

    </div>
@endsection
