@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'donasi'])
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-hand-holding-heart fa-lg text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Data Donasi</h5>
                    <small class="text-muted">Pencatatan donasi dari donatur (bisa banyak item)</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <form method="GET" class="d-flex gap-2">
                    <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm"
                        placeholder="Cari nama / no telp donatur">
                    <button class="btn btn-primary btn-sm rounded-pill px-3">Cari</button>
                </form>

                <a href="{{ route('petugas.donasi.create') }}" class="btn btn-success btn-sm rounded-pill px-3">
                    + Tambah
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Donatur</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
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
                        @endphp
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $d->donor->name }}</div>
                                <small class="text-muted">{{ $d->donor->phone ?? '-' }}</small>
                            </td>
                            <td>
                                <div>{{ $d->donated_at?->format('Y-m-d H:i') }}</div>
                                <small class="text-muted">ID: {{ $d->id }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $badge }} rounded-pill px-3 py-2 text-capitalize">
                                    {{ $d->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('petugas.donasi.detail', $d->id) }}"
                                    class="btn btn-warning btn-sm rounded-pill px-3">
                                    Detail
                                </a>

                                <button class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                    data-bs-target="#del{{ $d->id }}">
                                    Hapus
                                </button>

                                <div class="modal fade" id="del{{ $d->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4">
                                            <div class="modal-body text-center p-4">
                                                <p class="fw-semibold mb-4">Yakin hapus data donasi ini?</p>
                                                <form method="POST" action="{{ route('petugas.donasi.destroy', $d->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger rounded-pill px-4">Ya</button>
                                                </form>
                                                <button class="btn btn-secondary rounded-pill px-4"
                                                    data-bs-dismiss="modal">Tidak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada data donasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">{{ $donations->links() }}</div>
        </div>
    </div>
@endsection
