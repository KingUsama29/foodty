@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'donasi'])
@endsection

@section('content')
    @php
        $badge = match ($donation->status) {
            'accepted' => 'success',
            'rejected' => 'danger',
            default => 'warning',
        };

        $statusText = match ($donation->status) {
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            default => 'Menunggu',
        };

        $statusIcon = match ($donation->status) {
            'accepted' => 'fa-circle-check',
            'rejected' => 'fa-circle-xmark',
            default => 'fa-clock',
        };
    @endphp
    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm">
            <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ session('error') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-file-lines text-primary"></i>
                </div>
                <div>
                    <h5 class="mb-1">Detail Donasi</h5>
                    <small class="text-muted">
                        Donasi ID: <span class="fw-semibold">#{{ $donation->id }}</span>
                    </small>
                </div>
            </div>

            <div class="d-flex gap-2">
                @if ($donation->status === 'accepted')
                    <button class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                        data-bs-target="#cancelDonation">
                        <i class="fa-solid fa-ban me-1"></i> Batalkan
                    </button>
                @endif

                <a href="{{ route('petugas.data-donasi') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

        </div>
    </div>

    {{-- META BAR --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div class="text-muted">
            <i class="fa-regular fa-calendar me-1"></i>
            Waktu: <span class="fw-semibold">{{ $donation->donated_at?->format('d M Y, H:i') ?? '-' }}</span>
            <span class="mx-2">•</span>
            <i class="fa-solid fa-user me-1"></i>
            Donatur: <span class="fw-semibold">{{ $donation->donor->name ?? '-' }}</span>
        </div>

        <span class="badge bg-{{ $badge }} rounded-pill px-3 py-2">
            <i class="fa-solid {{ $statusIcon }} me-1"></i> {{ $statusText }}
        </span>
    </div>

    <div class="row g-3">
        {{-- KIRI: HEADER DONASI --}}
        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="fw-semibold">
                            <i class="fa-solid fa-circle-info me-1 text-primary"></i> Header Donasi
                        </div>
                    </div>

                    <div class="list-group list-group-flush">

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">
                                <i class="fa-solid fa-user me-1"></i> Donatur
                            </span>
                            <span class="fw-semibold">{{ $donation->donor->name ?? '-' }}</span>
                        </div>

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">
                                <i class="fa-solid fa-phone me-1"></i> No Telp
                            </span>
                            <span class="fw-semibold">{{ $donation->donor->phone ?? '-' }}</span>
                        </div>

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">
                                <i class="fa-regular fa-clock me-1"></i> Waktu
                            </span>
                            <span class="fw-semibold">{{ $donation->donated_at?->format('d M Y, H:i') ?? '-' }}</span>
                        </div>

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">
                                <i class="fa-solid fa-id-badge me-1"></i> Diterima Oleh
                            </span>
                            <span class="fw-semibold">{{ $donation->receivedBy->name ?? '-' }}</span>
                        </div>

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">
                                <i class="fa-solid fa-mobile-screen-button me-1"></i> Kontak Petugas
                            </span>
                            <span class="fw-semibold">{{ $donation->receivedBy->no_telp ?? '-' }}</span>
                        </div>

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">
                                <i class="fa-solid fa-building me-1"></i> Cabang
                            </span>
                            <span class="fw-semibold">{{ $donation->cabang->name ?? '-' }}</span>
                        </div>

                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">
                                <i class="fa-solid fa-flag me-1"></i> Status
                            </span>
                            <span class="badge bg-{{ $badge }} rounded-pill px-3 py-2 text-capitalize">
                                {{ $donation->status }}
                            </span>
                        </div>

                    </div>

                    @if (!empty($donation->note))
                        <div class="alert alert-light border mt-3 mb-0">
                            <div class="fw-semibold mb-1">
                                <i class="fa-regular fa-note-sticky me-1"></i> Catatan
                            </div>
                            <div class="text-muted">{{ $donation->note }}</div>
                        </div>
                    @endif

                    @if (!empty($donation->evidence_path))
                        <div class="mt-3">
                            <a class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                href="{{ asset('storage/' . $donation->evidence_path) }}" target="_blank">
                                <i class="fa-regular fa-image me-1"></i> Lihat Bukti
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KANAN: ITEM DONASI --}}
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="fw-semibold">
                            <i class="fa-solid fa-boxes-stacked me-1 text-primary"></i> Item Donasi
                        </div>

                        <span class="text-muted small">
                            Total item: <span class="fw-semibold">{{ $donation->items?->count() ?? 0 }}</span>
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Kategori</th>
                                    <th class="text-nowrap">Qty</th>
                                    <th class="text-nowrap">Kondisi</th>
                                    <th class="text-nowrap">Expired</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($donation->items as $it)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $it->item_name }}</div>
                                        </td>
                                        <td class="text-capitalize">
                                            {{ $it->category ?? '-' }}
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="badge bg-light text-dark border">
                                                {{ $it->qty ?? 0 }} {{ $it->unit ?? '' }}
                                            </span>
                                        </td>
                                        <td class="text-capitalize">
                                            {{ $it->condition ?? '-' }}
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $it->expired_at ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fa-regular fa-folder-open me-1"></i> Belum ada item donasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if ($donation->status === 'accepted')
        <div class="modal fade" id="cancelDonation" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4">
                    <div class="modal-body p-4">
                        <div class="text-center mb-3">
                            <i class="fa-solid fa-triangle-exclamation fa-2xl text-danger mb-3"></i>
                            <div class="fw-semibold mb-1">Batalkan donasi ini?</div>
                            <div class="text-muted" style="font-size: 14px;">
                                Stok gudang akan dikurangi otomatis (rollback).
                            </div>
                        </div>

                        <form method="POST" action="{{ route('petugas.donasi.cancel', $donation->id) }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Alasan pembatalan</label>
                                <textarea name="reason" class="form-control" rows="3" required
                                    placeholder="Contoh: Barang rusak / expired / salah input"></textarea>
                            </div>

                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-danger rounded-pill px-4">
                                    <i class="fa-solid fa-ban me-1"></i> Ya, Batalkan
                                </button>
                                <button type="button" class="btn btn-secondary rounded-pill px-4"
                                    data-bs-dismiss="modal">
                                    Batal
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
