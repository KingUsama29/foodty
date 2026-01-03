@php
    $user = auth()->user();
    $status = auth()->user()->latestRecipientVerification?->verification_status ?? 'pending';

    // helper kecil buat active menu
    function activeRoute($routeName)
    {
        return request()->routeIs($routeName . '*') ? 'active fw-semibold' : '';
    }
@endphp

<div class="list-group list-group-flush">

    <a href="{{ route('penerima.dashboard') }}"
        class="list-group-item list-group-item-action d-flex align-items-center {{ activeRoute('penerima.dashboard') }}">
        <i class="fa-solid fa-house fa-fw me-3"></i>
        Dashboard
    </a>

    @if ($status === 'approved')
        <a href="{{ route('penerima.pengajuan.index') }}"
            class="list-group-item list-group-item-action d-flex align-items-center {{ activeRoute('penerima.pengajuan') }}">
            <i class="fa-solid fa-file-circle-plus fa-fw me-3"></i>
            Pengajuan Bantuan
        </a>
    @else
        <a href="{{ route('verifikasi') }}"
            class="list-group-item list-group-item-action d-flex align-items-center {{ activeRoute('verifikasi') }}">
            <i class="fa-solid fa-id-card fa-fw me-3"></i>
            Verifikasi Data
        </a>
    @endif

    <a href="{{ route('penerima.riwayat') }}"
        class="list-group-item list-group-item-action d-flex align-items-center {{ activeRoute('penerima.riwayat') }}">
        <i class="fa-solid fa-clock-rotate-left fa-fw me-3"></i>
        Riwayat
    </a>

    <a href="{{ route('penerima.profile') }}"
        class="list-group-item list-group-item-action d-flex align-items-center {{ activeRoute('penerima.profile') }}">
        <i class="fa-solid fa-user-gear fa-fw me-3"></i>
        Profil
    </a>


</div>
