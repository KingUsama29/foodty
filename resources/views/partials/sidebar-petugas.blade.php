@php
    // helper kecil buat active menu (biar konsisten kayak sidebar-penerima)
    function activeRoute($routeName)
    {
        return request()->routeIs($routeName . '*') ? 'active fw-semibold' : '';
    }
@endphp

<div class="list-group list-group-flush">

    <a href="{{ route('petugas.dashboard') }}"
        class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ activeRoute('petugas.dashboard') }}">
        <i class="fa-solid fa-house fa-fw"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('petugas.data-penerima') }}"
        class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ activeRoute('petugas.data-penerima') }}">
        <i class="fa-solid fa-list-check fa-fw"></i>
        <span>Data Penerima</span>
    </a>

    <a href="{{ route('petugas.data-donasi') }}"
        class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ activeRoute('petugas.data-donasi') }}">
        <i class="fa-solid fa-hand-holding-heart fa-fw"></i>
        <span>Data Donasi</span>
    </a>

    <a href="{{ route('petugas.data-donatur') }}"
        class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ activeRoute('petugas.data-donatur') }}">
        <i class="fa-solid fa-users fa-fw"></i>
        <span>Data Donatur</span>
    </a>

    <a href="{{ route('petugas.data-pengajuan') }}"
        class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ activeRoute('petugas.data-pengajuan') }}">
        <i class="fa-solid fa-file-circle-plus fa-fw"></i>
        <span>Data Pengajuan</span>
    </a>

    <a href="{{ route('petugas.profil-petugas') }}"
        class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ activeRoute('petugas.profil-petugas') }}">
        <i class="fa-solid fa-id-badge fa-fw"></i>
        <span>Profil Petugas</span>
    </a>

</div>
