@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU PENERIMA ================= --}}
@section('sidebar-menu')
    @php
        $status = auth()->user()->latestRecipientVerification?->verification_status ?? 'pending';
    @endphp
    @include('partials.sidebar-penerima', ['active' => 'dashboard'])
@endsection


{{-- ================= KONTEN DASHBOARD PENERIMA ================= --}}
@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fa-solid fa-house fa-lg text-primary me-3"></i>
            <div>
                <h5 class="mb-1">Dashboard Penerima</h5>
                <small class="text-muted">
                    Ringkasan status pengajuan bantuan pangan
                </small>
            </div>
        </div>
    </div>


    <div class="row g-3">

        @if ($status === 'approved')
            {{-- PENGAJUAN --}}
            <div class="col-12 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-file-circle-plus fa-2x text-primary mb-3"></i>
                        <h6>Pengajuan Bantuan</h6>
                        <p class="small text-muted">
                            Akun kamu sudah terverifikasi. Silakan ajukan bantuan.
                        </p>
                        <a href="{{ route('penerima.pengajuan.index') }}" class="btn btn-primary mt-2">
                            Ajukan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        @else
            {{-- VERIFIKASI --}}
            <div class="col-12 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-id-card fa-2x text-primary mb-3"></i>
                        <h6>Verifikasi Data Diri</h6>
                        <p class="small text-muted">
                            Lengkapi verifikasi data diri seperti foto KTP dan data pendukung lainnya.
                        </p>
                        <a href="{{ route('verifikasi') }}" class="btn btn-primary mt-2">
                            Verifikasi Sekarang
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- RIWAYAT --}}
        <div class="col-12 col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="fa-solid fa-clock-rotate-left fa-2x text-primary mb-3"></i>
                    <h6>Riwayat Pengajuan</h6>
                    <p class="small text-muted">
                        Lihat riwayat pengajuan dan status bantuan yang pernah diajukan.
                    </p>
                    <a href="{{ route('penerima.riwayat') }}" class="btn btn-outline-primary mt-2">
                        Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
