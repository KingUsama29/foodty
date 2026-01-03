@extends('layouts.dashboard')

@section('sidebar-menu')
    @php
        $status = auth()->user()->latestRecipientVerification?->verification_status ?? 'pending';
    @endphp
    @include('partials.sidebar-penerima', ['active' => 'dashboard'])
@endsection

@section('content')
    @php
        $user = auth()->user();

        // Attempt terakhir (object tunggal) sesuai sistem Opsi A
        $verification = $user?->latestRecipientVerification;

        $status = $verification?->verification_status ?? 'pending';

        $badgeClass = match ($status) {
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            default => 'bg-warning text-dark',
        };

        $statusText = match ($status) {
            'approved' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => 'Menunggu Verifikasi',
        };

        // dokumen untuk attempt terakhir
        $docs = $verification?->documents ?? collect();
    @endphp

    <div class="container py-4">

        {{-- HEADER --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">

                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                        style="width:44px;height:44px;">
                        <i class="fa-solid fa-user-shield text-primary"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Profil Penerima</h5>
                        <small class="text-muted">Data akun dan informasi verifikasi kamu</small>
                    </div>
                </div>

                <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
                    <i
                        class="fa-solid
                        {{ $status === 'approved' ? 'fa-circle-check' : ($status === 'rejected' ? 'fa-circle-xmark' : 'fa-clock') }}
                        me-1"></i>
                    {{ $statusText }}
                </span>
            </div>
        </div>

        {{-- ALERT JIKA DITOLAK --}}
        @if ($status === 'rejected')
            <div class="alert alert-danger shadow-sm mb-4">
                <div class="d-flex align-items-start gap-2">
                    <i class="fa-solid fa-triangle-exclamation mt-1"></i>
                    <div class="flex-grow-1">
                        <div class="fw-semibold mb-1">Verifikasi ditolak</div>
                        <div>{{ $verification?->rejected_reason ?? 'Tidak ada alasan yang tercatat.' }}</div>

                        {{-- Optional: tampilkan kapan boleh submit ulang kalau cooldown ada --}}
                        @if (!empty($verification?->cooldown_until))
                            <div class="mt-2 text-muted" style="font-size: 14px;">
                                Kamu bisa ajukan ulang setelah:
                                <span class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($verification->cooldown_until)->format('d M Y, H:i') }}
                                </span>
                            </div>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('verifikasi') }}" class="btn btn-sm btn-outline-light border">
                                <i class="fa-solid fa-rotate-right me-1"></i> Ajukan Ulang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-3">

            {{-- KARTU AKUN --}}
            <div class="col-12 col-lg-5">
                <div class="card shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                style="width:54px;height:54px;">
                                <i class="fa-solid fa-user text-secondary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold" style="font-size: 18px;">
                                    {{ $user->name ?? '-' }}
                                </div>
                                <div class="text-muted" style="font-size: 13px;">
                                    <i class="fa-regular fa-envelope me-1"></i>
                                    <span class="text-break">{{ $user->email ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="vstack gap-3">
                            <div class="d-flex justify-content-between gap-3">
                                <div class="text-muted" style="font-size: 13px;">
                                    <i class="fa-solid fa-id-card me-1"></i> NIK Akun
                                </div>
                                <div class="fw-semibold text-end">{{ $user->nik ?? '-' }}</div>
                            </div>

                            <div class="d-flex justify-content-between gap-3">
                                <div class="text-muted" style="font-size: 13px;">
                                    <i class="fa-solid fa-phone me-1"></i> No. Telepon
                                </div>
                                <div class="fw-semibold text-end">{{ $user->no_telp ?? '-' }}</div>
                            </div>

                            <div>
                                <div class="text-muted mb-1" style="font-size: 13px;">
                                    <i class="fa-solid fa-location-dot me-1"></i> Alamat Akun
                                </div>
                                <div class="fw-semibold">{{ $user->alamat ?? '-' }}</div>
                            </div>

                            <div class="text-muted" style="font-size: 12px;">
                                <i class="fa-regular fa-calendar me-1"></i>
                                Dibuat: {{ optional($user->created_at)->format('d M Y, H:i') }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- KARTU DATA VERIFIKASI --}}
            <div class="col-12 col-lg-7">

                <div class="card shadow-sm mb-3">
                    <div class="card-body">

                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-2">
                            <div class="fw-semibold">
                                <i class="fa-solid fa-shield-halved me-1 text-primary"></i>
                                Data Verifikasi (Attempt Terakhir)
                            </div>

                            {{-- kalau belum approved, boleh diarahkan isi/ajukan --}}
                            @if ($status !== 'approved')
                                <a href="{{ route('verifikasi') }}"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="fa-solid fa-arrow-right me-1"></i>
                                    {{ $verification ? 'Lihat Status / Ajukan Ulang' : 'Mulai Verifikasi' }}
                                </a>
                            @endif
                        </div>

                        @if (!$verification)
                            <div class="alert alert-light border mb-0">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                Kamu belum mengisi data verifikasi. Silakan verifikasi agar bisa mengajukan bantuan.
                            </div>
                        @else
                            <div class="row g-3 mt-1">
                                <div class="col-12 col-md-6">
                                    <div class="text-muted" style="font-size: 13px;">Nama Lengkap</div>
                                    <div class="fw-semibold">{{ $verification->full_name ?? '-' }}</div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="text-muted" style="font-size: 13px;">NIK Verifikasi</div>
                                    <div class="fw-semibold">{{ $verification->nik ?? '-' }}</div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="text-muted" style="font-size: 13px;">No. KK</div>
                                    <div class="fw-semibold">{{ $verification->kk_number ?? '-' }}</div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="text-muted" style="font-size: 13px;">Kode Pos</div>
                                    <div class="fw-semibold">{{ $verification->postal_code ?? '-' }}</div>
                                </div>

                                <div class="col-12">
                                    <div class="text-muted" style="font-size: 13px;">Alamat Verifikasi</div>
                                    <div class="fw-semibold">{{ $verification->alamat ?? '-' }}</div>
                                </div>

                                <div class="col-12">
                                    <div class="text-muted" style="font-size: 13px;">Wilayah</div>
                                    <div class="fw-semibold">
                                        {{ $verification->district ?? '-' }},
                                        {{ $verification->city ?? '-' }},
                                        {{ $verification->province ?? '-' }}
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="text-muted" style="font-size: 13px;">
                                        <i class="fa-regular fa-paper-plane me-1"></i> Waktu Pengajuan
                                    </div>
                                    <div class="fw-semibold">
                                        {{ $verification->submitted_at ? \Carbon\Carbon::parse($verification->submitted_at)->format('d M Y, H:i') : '—' }}
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="text-muted" style="font-size: 13px;">
                                        <i class="fa-regular fa-clock me-1"></i> Waktu Diproses
                                    </div>
                                    <div class="fw-semibold">
                                        {{ $verification->reviewed_at ? \Carbon\Carbon::parse($verification->reviewed_at)->format('d M Y, H:i') : '—' }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- KARTU DOKUMEN --}}
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="fw-semibold mb-2">
                            <i class="fa-regular fa-folder-open me-1 text-primary"></i>
                            Dokumen Verifikasi (Attempt Terakhir)
                        </div>

                        @if (!$verification)
                            <div class="text-muted">Dokumen akan muncul setelah kamu mengisi verifikasi.</div>
                        @elseif ($docs->count() === 0)
                            <div class="text-muted">Belum ada dokumen yang tersimpan.</div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach ($docs as $doc)
                                    @php
                                        $icon = match ($doc->type) {
                                            'ktp' => 'fa-id-card',
                                            'selfie_ktp' => 'fa-camera',
                                            'kk' => 'fa-file-lines',
                                            default => 'fa-file',
                                        };
                                    @endphp

                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                    style="width:40px;height:40px;">
                                                    <i class="fa-solid {{ $icon }} text-secondary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-capitalize">
                                                        {{ $doc->type ?? 'dokumen' }}
                                                    </div>
                                                    <div class="text-muted" style="font-size: 13px;">
                                                        {{ $doc->original_name ?? 'file' }}
                                                        @if ($doc->file_size)
                                                            · {{ number_format($doc->file_size / 1024, 0) }} KB
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            @if (!empty($doc->file_path))
                                                <a target="_blank"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                    href="{{ asset('storage/' . $doc->file_path) }}">
                                                    <i class="fa-solid fa-eye me-1"></i> Lihat
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
