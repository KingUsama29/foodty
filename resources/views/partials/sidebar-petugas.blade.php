@php
    // $active diisi dari halaman, contoh: 'dashboard', 'penerima', dll
    $active = $active ?? '';
    $is = fn($key) => $active === $key ? 'active' : '';
@endphp

<a href="{{ route('petugas.dashboard') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ $is('dashboard') }}">
    <i class="fa-solid fa-house fa-fw me-3"></i>
    Dashboard
</a>

<a href="{{ route('petugas.data-penerima') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ $is('penerima') }}">
    <i class="fa-solid fa-list-check fa-fw me-3"></i>
    Data Penerima
</a>

<a href="{{ route('petugas.data-donasi') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ $is('donasi') }}">
    <i class="fa-solid fa-hand-holding-heart fa-fw me-3"></i>
    Data Donasi
</a>

<a href="{{ route('petugas.data-donatur') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ $is('donatur') }}">
    <i class="fa-solid fa-users fa-fw me-3"></i>
    Data Donatur
</a>

<a href="{{ route('petugas.profil-petugas') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ $is('profil') }}">
    <i class="fa-solid fa-id-badge fa-fw me-3"></i>
    Profil Petugas
</a>
