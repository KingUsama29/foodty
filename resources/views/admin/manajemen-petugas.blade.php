@extends('admin.layout')

@section('title', 'Manajemen Petugas')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <!-- HEADER HALAMAN -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold mb-0">Manajemen Petugas</h4>
            <button class="btn btn-success rounded-pill px-4">
                + Tambah Petugas
            </button>
        </div>

        <!-- TABEL -->
        <div class="rounded-4 p-4" style="background:#d7ebe2;">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center bg-white rounded-3 overflow-hidden">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No Telepon</th>
                            <th>Cabang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Rizman</td>
                            <td>0819029301</td>
                            <td>Medan</td>
                            <td>
                                <span class="badge bg-success">Online</span>
                            </td>
                            <td>
                                <a href="{{ url('/admin/manajemen-petugas/detail') }}"
                                   class="btn btn-warning btn-sm rounded-pill px-3 me-1">
                                    Detail
                                </a>
                                <button class="btn btn-primary btn-sm rounded-pill px-3 me-1">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm rounded-pill px-3">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Andi Saputra</td>
                            <td>0821123456</td>
                            <td>Yogyakarta</td>
                            <td>
                                <span class="badge bg-secondary">Offline</span>
                            </td>
                            <td>
                                <a href="{{ url('/admin/manajemen-petugas/detail') }}"
                                   class="btn btn-warning btn-sm rounded-pill px-3 me-1">
                                    Detail
                                </a>
                                <button class="btn btn-primary btn-sm rounded-pill px-3 me-1">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm rounded-pill px-3">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Siti Rahma</td>
                            <td>085712345678</td>
                            <td>Bandung</td>
                            <td>
                                <span class="badge bg-success">Online</span>
                            </td>
                            <td>
                                <a href="{{ url('/admin/manajemen-petugas/detail') }}"
                                   class="btn btn-warning btn-sm rounded-pill px-3 me-1">
                                    Detail
                                </a>
                                <button class="btn btn-primary btn-sm rounded-pill px-3 me-1">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm rounded-pill px-3">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
@endsection
