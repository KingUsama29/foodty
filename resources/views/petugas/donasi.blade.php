@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'donasi'])
@endsection

@section('content')
    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-hand-holding-heart text-primary"></i>
                </div>
                <div>
                    <h5 class="mb-1">Data Donasi</h5>
                    <small class="text-muted">Pencatatan donasi dari donatur (bisa banyak item)</small>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-2">
                <form method="GET" class="d-flex gap-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="{{ $q }}" class="form-control"
                            placeholder="Cari nama / no telp donatur">
                    </div>
                    <button class="btn btn-primary btn-sm rounded-pill px-3">
                        Cari
                    </button>
                </form>

                <a href="{{ route('petugas.donasi.create') }}" class="btn btn-success btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-plus me-1"></i> Tambah
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 34%;">Donatur</th>
                            <th style="width: 26%;">Waktu</th>
                            <th style="width: 18%;">Status</th>
                            <th class="text-end" style="width: 22%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $d)
                            @php
                                $badge = match ($d->status) {
                                    'accepted' => 'success',
                                    'rejected' => 'danger',
                                    default => 'warning',
                                };

                                $statusText = match ($d->status) {
                                    'accepted' => 'Diterima',
                                    'rejected' => 'Ditolak',
                                    default => 'Menunggu',
                                };

                                $statusIcon = match ($d->status) {
                                    'accepted' => 'fa-circle-check',
                                    'rejected' => 'fa-circle-xmark',
                                    default => 'fa-clock',
                                };
                            @endphp

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                            style="width:36px;height:36px;">
                                            <i class="fa-solid fa-user text-muted"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $d->donor->name }}</div>
                                            <small class="text-muted">
                                                <i class="fa-solid fa-phone me-1"></i>
                                                {{ $d->donor->phone ?? '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        <i class="fa-regular fa-calendar me-1 text-muted"></i>
                                        {{ $d->donated_at?->format('d M Y, H:i') ?? '-' }}
                                    </div>
                                    <small class="text-muted">ID: {{ $d->id }}</small>
                                </td>

                                <td>
                                    <span class="badge bg-{{ $badge }} rounded-pill px-3 py-2">
                                        <i class="fa-solid {{ $statusIcon }} me-1"></i> {{ $statusText }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('petugas.donasi.detail', $d->id) }}"
                                            class="btn btn-warning btn-sm rounded-pill px-3">
                                            <i class="fa-solid fa-eye me-1"></i> Detail
                                        </a>

                                        <button class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                            data-bs-toggle="modal" data-bs-target="#del{{ $d->id }}">
                                            <i class="fa-solid fa-trash me-1"></i> Hapus
                                        </button>
                                    </div>

                                    {{-- MODAL DELETE --}}
                                    <div class="modal fade" id="del{{ $d->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4">
                                                <div class="modal-body p-4">
                                                    <div class="text-center">
                                                        <i
                                                            class="fa-solid fa-triangle-exclamation fa-2xl text-danger mb-3"></i>
                                                        <div class="fw-semibold mb-1">Hapus data donasi?</div>
                                                        <div class="text-muted mb-3" style="font-size: 14px;">
                                                            Aksi ini tidak bisa dibatalkan.
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-center gap-2">
                                                        <form method="POST"
                                                            action="{{ route('petugas.donasi.destroy', $d->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger rounded-pill px-4">
                                                                <i class="fa-solid fa-trash me-1"></i> Ya, Hapus
                                                            </button>
                                                        </form>
                                                        <button class="btn btn-secondary rounded-pill px-4"
                                                            data-bs-dismiss="modal">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fa-regular fa-folder-open me-1"></i> Belum ada data donasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $donations->links() }}
            </div>
        </div>
    </div>
@endsection
