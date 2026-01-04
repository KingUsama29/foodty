@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'penyaluran'])
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h5 class="mb-1">Detail Penyaluran #{{ $distribution->id }}</h5>
                <small class="text-muted">Status: {{ $distribution->status }}</small>
            </div>
            <a href="{{ route('petugas.data-penyaluran') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="text-muted small">Penerima</div>
                    <div class="fw-semibold">{{ $distribution->recipient_name ?? '-' }}</div>
                    <div class="text-muted small">{{ $distribution->recipient_phone ?? '-' }}</div>
                </div>
                <div class="col-md-5">
                    <div class="text-muted small">Alamat</div>
                    <div>{{ $distribution->recipient_address ?? '-' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">Waktu</div>
                    <div>{{ optional($distribution->distributed_at)->format('d/m/Y H:i') }}</div>
                    <div class="text-muted small mt-2">Request</div>
                    <div>#{{ $distribution->food_request_id }} • {{ $distribution->request->main_needs ?? '-' }}</div>
                </div>
            </div>

            @if ($distribution->note)
                <hr>
                <div class="text-muted small">Catatan</div>
                <div>{{ $distribution->note }}</div>
            @endif
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="fw-semibold mb-2">Item</div>
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th>Expired</th>
                            <th>Qty</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($distribution->items as $it)
                            <tr>
                                <td>{{ $it->warehouseItem->name ?? 'Item' }}</td>
                                <td>{{ $it->expired_at ? $it->expired_at->format('Y-m-d') : 'tanpa expired' }}</td>
                                <td>{{ $it->qty }}</td>
                                <td>{{ $it->unit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($distribution->status === 'completed')
                <hr>
                <form method="POST" action="{{ route('petugas.penyaluran.cancel', $distribution) }}" class="d-flex gap-2">
                    @csrf
                    <input class="form-control" name="reason" placeholder="Alasan cancel..." required maxlength="500">
                    <button class="btn btn-danger rounded-pill px-4" type="submit">
                        Cancel Penyaluran
                    </button>
                </form>
                <small class="text-muted">Cancel akan mengembalikan stok dan membuat movement IN rollback.</small>
            @endif
        </div>
    </div>
@endsection
