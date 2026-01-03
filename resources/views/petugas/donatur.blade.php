@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'donatur'])
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-hand-holding-heart fa-lg text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Data Donatur</h5>
                    <small class="text-muted">Kelola donatur agar input donasi lebih cepat</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <form method="GET" class="d-flex gap-2">
                    <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm"
                        placeholder="Cari nama / no telp">
                    <button class="btn btn-primary btn-sm rounded-pill px-3" type="submit">Cari</button>
                </form>

                <a href="{{ route('petugas.donatur.create') }}" class="btn btn-success btn-sm rounded-pill px-3">
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
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($donors as $d)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $d->name }}</div>
                                <small class="text-muted text-capitalize">Tipe: {{ $d->type }}</small>
                            </td>

                            <td>
                                <div>{{ $d->phone }}</div>
                                <small class="text-muted">{{ $d->email ?? '-' }}</small>
                            </td>

                            <td>
                                <span class="text-muted">{{ $d->address ?? '-' }}</span>
                            </td>

                            <td class="text-end">
                                <a href="{{ route('petugas.donatur.edit', $d->id) }}"
                                    class="btn btn-warning btn-sm rounded-pill px-3">
                                    Edit
                                </a>

                                <button class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $d->id }}">
                                    Hapus
                                </button>

                                {{-- Modal Delete --}}
                                <div class="modal fade" id="deleteModal{{ $d->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4">
                                            <div class="modal-body text-center p-4">
                                                <p class="fw-semibold mb-4">
                                                    Yakin hapus donatur <span
                                                        class="text-danger">{{ $d->name }}</span>?
                                                </p>

                                                <form method="POST"
                                                    action="{{ route('petugas.donatur.destroy', $d->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger rounded-pill px-4">Ya</button>
                                                </form>

                                                <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                                    Tidak
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
                            <td colspan="4" class="text-center text-muted py-4">
                                Data donatur masih kosong.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $donors->links() }}
            </div>
        </div>
    </div>
@endsection
