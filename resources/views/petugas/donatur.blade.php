@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'donatur'])
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
                    <h5 class="mb-1">Data Donatur</h5>
                    <small class="text-muted">Kelola donatur agar input donasi lebih cepat</small>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-2">
                <form method="GET" class="d-flex gap-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="{{ $q }}" class="form-control"
                            placeholder="Cari nama / no telp">
                    </div>
                    <button class="btn btn-primary btn-sm rounded-pill px-3" type="submit">
                        Cari
                    </button>
                </form>

                <a href="{{ route('petugas.donatur.create') }}" class="btn btn-success btn-sm rounded-pill px-3">
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
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Donatur</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($donors as $d)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width:42px;height:42px;">
                                            <i class="fa-solid fa-user text-secondary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $d->name }}</div>
                                            <small class="text-muted text-capitalize">
                                                <i class="fa-solid fa-tag me-1"></i> {{ $d->type }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        <i class="fa-solid fa-phone me-1 text-muted"></i>{{ $d->phone }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="fa-regular fa-envelope me-1"></i>{{ $d->email ?? '-' }}
                                    </small>
                                </td>

                                <td>
                                    <span class="text-muted">
                                        <i class="fa-solid fa-location-dot me-1"></i>{{ $d->address ?? '-' }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('petugas.donatur.edit', $d->id) }}"
                                            class="btn btn-warning btn-sm rounded-pill px-3">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                        </a>

                                        <button class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $d->id }}">
                                            <i class="fa-solid fa-trash me-1"></i> Hapus
                                        </button>
                                    </div>

                                    {{-- Modal Delete --}}
                                    <div class="modal fade" id="deleteModal{{ $d->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4">
                                                <div class="modal-body text-center p-4">
                                                    <div class="mb-2">
                                                        <i class="fa-solid fa-triangle-exclamation text-danger fa-2x"></i>
                                                    </div>
                                                    <p class="fw-semibold mb-4">
                                                        Yakin hapus donatur <span
                                                            class="text-danger">{{ $d->name }}</span>?
                                                    </p>

                                                    <form method="POST"
                                                        action="{{ route('petugas.donatur.destroy', $d->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger rounded-pill px-4">
                                                            Ya, Hapus
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
                                    {{-- End Modal --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="fa-regular fa-face-meh fa-lg me-1"></i>
                                    Data donatur masih kosong.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $donors->links() }}
            </div>
        </div>
    </div>
@endsection
