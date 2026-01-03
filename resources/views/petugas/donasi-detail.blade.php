@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'donasi'])
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-file-lines fa-lg text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Detail Donasi</h5>
                    <small class="text-muted">Donasi ID: {{ $donation->id }}</small>
                </div>
            </div>

            <a href="{{ route('petugas.data-donasi') }}" class="btn btn-secondary btn-sm rounded-pill px-3">Kembali</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Header Donasi</h6>

                    <div class="mb-2"><span class="text-muted">Donatur:</span> <span
                            class="fw-semibold">{{ $donation->donor->name }}</span></div>
                    <div class="mb-2"><span class="text-muted">No Telp:</span> {{ $donation->donor->phone ?? '-' }}</div>
                    <div class="mb-2"><span class="text-muted">Waktu:</span>
                        {{ $donation->donated_at?->format('Y-m-d H:i') }}
                    </div>
                    <div class="mb-2">
                        <span class="text-muted">Diterima Oleh:</span>
                        <span class="fw-semibold">{{ $donation->receivedBy->name ?? '-' }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted">Kontak Petugas:</span>
                        {{ $donation->receivedBy->no_telp ?? '-' }}
                    </div>
                    <div class="mb-2">
                        <span class="text-muted">Cabang:</span>
                        {{ $donation->cabang->name ?? '-' }}
                    </div>
                    <div class="mb-2"><span class="text-muted">Status:</span> <span
                            class="badge bg-success rounded-pill px-3 py-2 text-capitalize">{{ $donation->status }}</span>
                    </div>



                    @if ($donation->note)
                        <div class="mt-3">
                            <div class="fw-semibold">Catatan:</div>
                            <div class="text-muted">{{ $donation->note }}</div>
                        </div>
                    @endif

                    @if ($donation->evidence_path)
                        <div class="mt-3">
                            <a class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                href="{{ asset('storage/' . $donation->evidence_path) }}" target="_blank">
                                Lihat Bukti
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Item Donasi</h6>

                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Kategori</th>
                                <th>Qty</th>
                                <th>Kondisi</th>
                                <th>Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donation->items as $it)
                                <tr>
                                    <td class="fw-semibold">{{ $it->item_name }}</td>
                                    <td>{{ $it->category }}</td>
                                    <td>{{ $it->qty }} {{ $it->unit }}</td>
                                    <td>{{ $it->condition }}</td>
                                    <td>{{ $it->expired_at ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
