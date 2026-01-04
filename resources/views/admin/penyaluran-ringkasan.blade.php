@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'penyaluran'])
@endsection

@section('content')
    <div class="card shadow-sm text-center">
        <div class="card-body py-5">
            <h4 class="fw-bold mb-2">Penyaluran Berhasil!!</h4>
            <p class="mb-1">Kode Penyaluran : <strong>#34</strong></p>
            <p class="text-muted mb-4">
                Menunggu petugas mengantarkan barang
            </p>

            <a href="{{ route('admin.penyaluran.riwayat') }}" class="btn btn-warning rounded-pill w-100 py-2">
                Lihat
            </a>
        </div>
    </div>
@endsection
