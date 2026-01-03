@extends('layouts.dashboard')
@section('sidebar-menu')
    @php
        $status = auth()->user()->latestRecipientVerification?->verification_status ?? 'pending';
    @endphp
    @include('partials.sidebar-penerima', ['active' => 'dashboard'])
@endsection
@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-2">Status Verifikasi</h5>

                <div class="alert alert-warning mb-3">
                    {{ $message }}
                </div>

                @if ($last && $last->verification_status === 'rejected' && $last->rejected_reason)
                    <div class="mb-3">
                        <div class="fw-semibold text-danger">Alasan ditolak:</div>
                        <div class="text-muted">{{ $last->rejected_reason }}</div>
                    </div>
                @endif

                <a href="{{ route('penerima.dashboard') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
    </div>
@endsection
