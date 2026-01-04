@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU ADMIN ================= --}}
@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'stok'])
@endsection


{{-- ================= KONTEN DETAIL STOK ================= --}}
@section('content')
    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fa-solid fa-boxes-stacked fa-lg text-primary me-3"></i>
            <div>
                <h5 class="mb-1">Stok Barang</h5>
                <small class="text-muted">
                    Informasi stok bantuan pangan
                </small>
            </div>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Barang</th>
                        <th class="text-end pe-4">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4">Beras 10 kg</td>
                        <td class="text-end pe-4 fw-semibold">107</td>
                    </tr>
                    <tr>
                        <td class="ps-4">Minyak 5 Liter</td>
                        <td class="text-end pe-4 fw-semibold">168</td>
                    </tr>
                    <tr>
                        <td class="ps-4">Air Minum 1 Kotak</td>
                        <td class="text-end pe-4 fw-semibold">109</td>
                    </tr>
                    <tr>
                        <td class="ps-4">Roti Kering</td>
                        <td class="text-end pe-4 fw-semibold">248</td>
                    </tr>
                    <tr>
                        <td class="ps-4">Susu Bayi</td>
                        <td class="text-end pe-4 fw-semibold">158</td>
                    </tr>
                </tbody>
            </table>

            {{-- TOMBOL KEMBALI (TETAP) --}}
            <div class="p-3">
                <a href="{{ route('admin.stok') }}" class="btn btn-secondary rounded-pill px-4">
                    Kembali
                </a>
            </div>

        </div>
    </div>
@endsection
