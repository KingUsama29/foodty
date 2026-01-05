@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'penyaluran'])
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h5 class="mb-1">Riwayat Penyaluran</h5>
                <small class="text-muted">Riwayat penyaluran dari stok cabang</small>
            </div>

            <div class="d-flex gap-2">
                <form class="d-flex" method="GET" action="{{ route('petugas.data-penyaluran') }}">
                    <input class="form-control form-control-sm" name="q" value="{{ $q }}"
                        placeholder="Cari nama / id...">
                    <button class="btn btn-secondary btn-sm ms-2 rounded-pill px-3" type="submit">Cari</button>
                </form>

                {{-- <a href="{{ route('petugas.penyaluran-create') }}" class="btn btn-success btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-plus me-1"></i> Tambah
                </a> --}}
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Pemohon</th>
                            <th>Request</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $d)
                            <tr>
                                <td>#{{ $d->id }}</td>
                                <td>{{ $d->recipient_name ?? ($d->request->user->name ?? '-') }}</td>
                                <td>#{{ $d->food_request_id }} • {{ $d->request->main_needs ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $d->status === 'completed' ? 'success' : ($d->status === 'canceled' ? 'secondary' : 'warning') }}">
                                        {{ $d->status }}
                                    </span>
                                </td>
                                <td>{{ optional($d->distributed_at)->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('petugas.penyaluran.show', $d) }}"
                                        class="btn btn-primary btn-sm rounded-pill px-3">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $list->links() }}
            </div>
        </div>
    </div>
@endsection
