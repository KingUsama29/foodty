@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU ADMIN ================= --}}
@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'stok'])
@endsection


{{-- ================= KONTEN STOK BARANG ================= --}}
@section('content')
    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fa-solid fa-boxes-stacked fa-lg text-primary me-3"></i>
            <div>
                <h5 class="mb-1">Stok Barang</h5>
                <small class="text-muted">
                    Data stok bantuan berdasarkan daerah
                </small>
            </div>
        </div>
    </div>

    {{-- TABEL DAERAH --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Daerah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>Medan</td>
                        <td>
                            <a href="{{ route('admin.stok.detail', 'medan') }}"
                                class="btn btn-warning btn-sm rounded-pill px-3">
                                Lihat
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Yogyakarta</td>
                        <td>
                            <a href="{{ route('admin.stok.detail', 'yogyakarta') }}"
                                class="btn btn-warning btn-sm rounded-pill px-3">
                                Lihat
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Jakarta</td>
                        <td>
                            <a href="{{ route('admin.stok.detail', 'jakarta') }}"
                                class="btn btn-warning btn-sm rounded-pill px-3">
                                Lihat
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Padang</td>
                        <td>
                            <a href="{{ route('admin.stok.detail', 'padang') }}"
                                class="btn btn-warning btn-sm rounded-pill px-3">
                                Lihat
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>
@endsection
