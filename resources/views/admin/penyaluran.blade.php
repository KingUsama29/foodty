@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU ADMIN ================= --}}
@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'penyaluran'])
@endsection


{{-- ================= KONTEN PENYALURAN ================= --}}
@section('content')
    {{-- HEADER (HANYA TAMBAH LOGO, DESAIN TETAP) --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fa-solid fa-chart-pie fa-lg text-primary me-3"></i>
            <div>
                <h5 class="mb-1">Penyaluran Bantuan</h5>
                <small class="text-muted">
                    Pilih petugas untuk menyalurkan bantuan
                </small>
            </div>
        </div>
    </div>

    {{-- TABEL PETUGAS --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Petugas</th>
                        <th style="width: 140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (['Medan', 'Yogyakarta', 'Jakarta', 'Padang'] as $daerah)
                        <tr>
                            <td>{{ $daerah }}</td>
                            <td>
                                <a href="{{ route('admin.penyaluran.form', $daerah) }}"
                                    class="btn btn-warning btn-sm rounded-pill px-3">
                                    Klik
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
