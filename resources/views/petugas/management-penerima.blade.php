@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'penerima'])
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-users fa-lg text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Manage Penerima</h5>
                    <small class="text-muted">Daftar penerima yang mengajukan verifikasi</small>
                </div>
            </div>

            <form method="GET" class="d-flex gap-2">
                <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm"
                    placeholder="Cari nama / NIK / email">
                <button class="btn btn-primary btn-sm rounded-pill px-3" type="submit">
                    Cari
                </button>
            </form>
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
                        <th>Penerima</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($verifications as $v)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $v->user->name }}</div>
                                <small class="text-muted">NIK: {{ $v->user->nik }}</small>
                            </td>

                            <td>
                                <div>{{ $v->user->email }}</div>
                                <small class="text-muted">{{ $v->user->no_telp ?? '-' }}</small>
                            </td>

                            <td>
                                @php
                                    $status = $v->verification_status;
                                    $badge = match ($status) {
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        default => 'warning',
                                    };
                                    $label = match ($status) {
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                        default => 'Pending',
                                    };
                                @endphp

                                <span class="badge bg-{{ $badge }} rounded-pill px-3 py-2">
                                    {{ $label }}
                                </span>
                            </td>

                            <td class="text-end">
                                <a href="{{ route('petugas.penerima-detail', $v->id) }}"
                                    class="btn btn-warning btn-sm rounded-pill px-3">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada data verifikasi penerima.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $verifications->links() }}
            </div>

        </div>
    </div>
@endsection
