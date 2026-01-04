@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'cabang'])
@endsection
@section('content')
    @php $q = $q ?? request('q'); @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-location-dot" style="color:#0d6efd;"></i>
                </div>
                <div>
                    <h5 class="mb-1">Cabang Lokasi</h5>
                    <small class="text-muted">Kelola data cabang penyaluran bantuan (CRUD)</small>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-2">
                <form method="GET" class="d-flex gap-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white">
                            <i class="fa-solid fa-magnifying-glass" style="color:#6c757d;"></i>
                        </span>
                        <input type="text" name="q" value="{{ $q }}" class="form-control"
                            placeholder="Cari nama cabang / alamat...">
                    </div>
                    <button class="btn btn-primary btn-sm rounded-pill px-3">Cari</button>
                </form>

                <a href="{{ route('admin.cabang.create') }}" class="btn btn-success btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-plus me-1" style="color:#fff;"></i> Tambah
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-4">
            <i class="fa-solid fa-circle-check me-1" style="color:#198754;"></i> {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Cabang</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cabangs as $c)
                            @php
                                $active = (bool) $c->is_active;
                                $badge = $active ? 'success' : 'secondary';
                                $text = $active ? 'Aktif' : 'Nonaktif';
                                $icon = $active ? 'fa-circle-check' : 'fa-circle-minus';
                            @endphp

                            <tr>
                                <td style="min-width:200px;">
                                    <div class="fw-semibold">{{ $c->name }}</div>
                                    <small class="text-muted">ID: {{ $c->id }}</small>
                                </td>

                                <td style="min-width:260px;">
                                    <div class="text-muted">
                                        <i class="fa-solid fa-location-crosshairs me-1" style="color:#6c757d;"></i>
                                        {{ $c->alamat }}
                                    </div>
                                </td>

                                <td style="min-width:160px;">
                                    <span class="badge bg-{{ $badge }} rounded-pill px-3 py-2">
                                        <i class="fa-solid {{ $icon }} me-1" style="color:#fff;"></i>
                                        {{ $text }}
                                    </span>
                                </td>

                                <td class="text-end" style="min-width:320px;">
                                    <div class="d-inline-flex gap-2">
                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.cabang.edit', $c->id) }}"
                                            class="btn btn-info btn-sm rounded-pill px-3 text-white">
                                            <i class="fa-solid fa-pen-to-square me-1" style="color:#fff;"></i> Edit
                                        </a>

                                        {{-- HAPUS --}}
                                        <button class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                            data-bs-toggle="modal" data-bs-target="#del{{ $c->id }}">
                                            <i class="fa-solid fa-trash me-1" style="color:#dc3545;"></i> Hapus
                                        </button>
                                    </div>

                                    {{-- MODAL DELETE --}}
                                    <div class="modal fade" id="del{{ $c->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4">
                                                <div class="modal-body p-4">
                                                    <div class="text-center">
                                                        <i
                                                            class="fa-solid fa-triangle-exclamation fa-2xl text-danger mb-3"></i>
                                                        <div class="fw-semibold mb-1">Hapus cabang ini?</div>
                                                        <div class="text-muted mb-3" style="font-size:14px;">
                                                            Aksi ini tidak bisa dibatalkan.
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-center gap-2">
                                                        <form method="POST"
                                                            action="{{ route('admin.cabang.destroy', $c->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger rounded-pill px-4">
                                                                <i class="fa-solid fa-trash me-1" style="color:#fff;"></i>
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
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fa-regular fa-folder-open me-1" style="color:#6c757d;"></i> Belum ada data
                                    cabang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $cabangs->links() }}
            </div>
        </div>
    </div>
@endsection
