{{-- resources/views/admin/manajemen-petugas.blade.php --}}
@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'petugas'])
@endsection

@section('content')
    @php
        $q = $q ?? request('q');

        $isPaginator =
            $petugas instanceof \Illuminate\Contracts\Pagination\Paginator ||
            $petugas instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    @endphp

    {{-- HEADER (tetep gaya yang ini) --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <span class="badge text-bg-primary rounded-3 p-3 me-3">
                    <i class="fa-solid fa-users-gear fa-lg"></i>
                </span>
                <div>
                    <h5 class="mb-1">Manajemen Petugas</h5>
                    <small class="text-muted">Kelola akun petugas penyaluran (CRUD)</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                {{-- SEARCH --}}
                <form method="GET" class="d-flex gap-2">
                    <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm"
                        placeholder="Cari nama / email / NIK / telp...">
                    <button class="btn btn-primary btn-sm rounded-pill px-3">
                        Cari
                    </button>
                </form>

                {{-- ADD --}}
                <a href="{{ route('admin.petugas.create') }}" class="btn btn-success btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-plus me-1 text-white"></i> Tambah
                </a>
            </div>
        </div>
    </div>

    {{-- FLASH --}}
    @if (session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-4">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm border-0 rounded-4">
            <i class="fa-solid fa-circle-xmark me-1"></i> {{ session('error') }}
        </div>
    @endif

    {{-- TABLE (ringkas) --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Petugas</th>
                            <th>Cabang</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($petugas as $p)
                            @php
                                $profile = $p->petugas ?? null;

                                $photoUrl = $profile?->file_path ? asset('storage/' . $profile->file_path) : null;
                                $email = $p->email ?? '-';

                                $cabangNama = $profile?->cabang?->name ?? '-';

                                $active = (bool) ($profile?->is_active ?? 0);
                                $badgeClass = $active ? 'bg-success' : 'bg-secondary';
                                $statusText = $active ? 'Aktif' : 'Non-Aktif';
                                $statusIcon = $active ? 'fa-signal' : 'fa-circle-minus';
                            @endphp

                            <tr>
                                {{-- PETUGAS --}}
                                <td style="min-width: 280px;">
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($photoUrl)
                                            <img src="{{ $photoUrl }}" alt="Foto Petugas"
                                                class="rounded-circle shadow-sm"
                                                style="width:44px;height:44px;object-fit:cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm"
                                                style="width:44px;height:44px;">
                                                <i class="fa-solid fa-user text-muted"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <div class="fw-semibold">{{ $p->name ?? '-' }}</div>
                                            <div class="text-muted small">{{ $email }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- CABANG --}}
                                <td style="min-width: 180px;">
                                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                        {{ $cabangNama }}
                                    </span>
                                </td>

                                {{-- STATUS --}}
                                <td style="min-width: 160px;">
                                    <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
                                        <i class="fa-solid {{ $statusIcon }} me-1 text-white"></i>
                                        {{ $statusText }}
                                    </span>
                                </td>

                                {{-- ================= AKSI (ANTI OVERRIDE: ICON PASTI PUTIH) ================= --}}
                                <td class="text-end" style="min-width: 240px;">
                                    <div class="d-inline-flex gap-2">

                                        {{-- DETAIL --}}
                                        <a href="{{ route('admin.petugas.detail', $p->id) }}"
                                            class="btn btn-warning btn-sm rounded-pill px-3 text-white">
                                            <i class="fa-solid fa-eye me-1" style="color:#fff !important;"></i> Detail
                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.petugas.edit', $p->id) }}"
                                            class="btn btn-info btn-sm rounded-pill px-3 text-white">
                                            <i class="fa-solid fa-pen-to-square me-1" style="color:#fff !important;"></i>
                                            Edit
                                        </a>

                                        {{-- HAPUS (TRIGGER MODAL) --}}
                                        <button class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                            data-bs-target="#del{{ $p->id }}">
                                            <i class="fa-solid fa-trash me-1" style="color:#fff !important;"></i> Hapus
                                        </button>
                                    </div>

                                    {{-- MODAL DELETE --}}
                                    <div class="modal fade" id="del{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4">
                                                <div class="modal-body p-4">
                                                    <div class="text-center">
                                                        <i
                                                            class="fa-solid fa-triangle-exclamation fa-2xl text-danger mb-3"></i>
                                                        <div class="fw-semibold mb-1">Hapus data petugas?</div>
                                                        <div class="text-muted mb-3" style="font-size: 14px;">
                                                            Aksi ini tidak bisa dibatalkan.
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-center gap-2">
                                                        <form method="POST"
                                                            action="{{ route('admin.petugas.destroy', $p->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger rounded-pill px-4">
                                                                <i class="fa-solid fa-trash me-1"
                                                                    style="color:#fff !important;"></i> Ya, Hapus
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
                                    <i class="fa-solid fa-folder-open me-1"></i>
                                    Belum ada data petugas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($isPaginator)
                <div class="mt-3">
                    {{ $petugas->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
