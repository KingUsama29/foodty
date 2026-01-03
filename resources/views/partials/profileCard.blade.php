@php
    $user = auth()->user();

    // status verifikasi penerima: attempt terakhir
    $statusVerif = $user?->latestRecipientVerification?->verification_status ?? 'pending';

    // foto khusus petugas (kalau ada)
    $photo = $user?->petugas?->file_path ? asset('storage/' . $user->petugas->file_path) : null;

    // badge verifikasi (khusus penerima)
    $badgeClass = match ($statusVerif) {
        'approved' => 'success',
        'rejected' => 'danger',
        default => 'warning',
    };

    $badgeText = match ($statusVerif) {
        'approved' => 'Terverifikasi',
        'rejected' => 'Ditolak',
        default => 'Menunggu Verifikasi',
    };
@endphp

<div class="d-flex align-items-center gap-3 py-2">

    {{-- AVATAR --}}
    <div class="flex-shrink-0">
        @if ($photo)
            <img src="{{ $photo }}" alt="Foto Profil" class="rounded-circle border"
                style="width:48px;height:48px;object-fit:cover;">
        @else
            <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center"
                style="width:48px;height:48px;">
                <span class="fw-bold text-muted">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </span>
            </div>
        @endif
    </div>

    {{-- INFO USER --}}
    <div class="lh-sm flex-grow-1">
        <div class="small text-muted">Selamat Datang</div>
        <div class="fw-semibold text-truncate">{{ $user->name ?? '-' }}</div>
        <div class="text-muted small text-capitalize">{{ $user->role ?? '-' }}</div>

        {{-- BADGE VERIFIKASI (khusus penerima) --}}
        @if (($user->role ?? '') === 'penerima')
            <span class="badge bg-{{ $badgeClass }} rounded-pill px-2 py-1 mt-2 d-inline-flex align-items-center">
                <i class="fa-solid fa-shield-halved me-1"></i> {{ $badgeText }}
            </span>
        @endif
    </div>

</div>
