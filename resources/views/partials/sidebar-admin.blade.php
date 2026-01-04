@php
    $active = $active ?? '';
    function isActive($key, $active)
    {
        return $key === $active ? 'active fw-semibold' : '';
    }
@endphp

@section('sidebar-menu')
    <div class="list-group list-group-flush">

        <a href="{{ route('admin.dashboard') }}"
            class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ isActive('dashboard', $active) }}">
            <i class="fa-solid fa-house fa-fw"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.pengajuan') }}"
            class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ isActive('pengajuan', $active) }}">
            <i class="fa-solid fa-file-circle-check fa-fw"></i>
            <span>Ajuan Bantuan</span>
        </a>

        <a href="{{ route('admin.petugas') }}"
            class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ isActive('petugas', $active) }}">
            <i class="fa-solid fa-users-gear fa-fw"></i>
            <span>Data Petugas</span>
        </a>

        <a href="{{ route('admin.cabang') }}"
            class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ isActive('cabang', $active) }}">
            <i class="fa-solid fa-location-dot fa-fw"></i>
            <span>Cabang Lokasi</span>
        </a>

        <a href="{{ route('admin.stok-barang') }}"
            class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ isActive('stok', $active) }}">
            <i class="fa-solid fa-boxes-stacked fa-fw"></i>
            <span>Stok Barang</span>
        </a>

        <a href="{{ route('admin.penyaluran') }}"
            class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 {{ isActive('penyaluran', $active) }}">
            <i class="fa-solid fa-chart-pie fa-fw"></i>
            <span>Hasil Penyaluran</span>
        </a>

    </div>
@endsection
