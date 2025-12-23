@extends('admin.layout')

@section('title', 'Barang')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <h4 class="fw-semibold mb-4">Barang</h4>

        <div class="rounded-4 p-4" style="background:#d7ebe2;">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center bg-white">
                    <thead class="table-light">
                        <tr>
                            <th>Daerah</th>
                            <th>Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Medan</td>
                            <td>
                                <a href="{{ url('/admin/barang/detail') }}"
                                   class="btn btn-warning btn-sm rounded-pill px-3">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Yogyakarta</td>
                            <td>
                                <a href="{{ url('/admin/barang/detail') }}"
                                   class="btn btn-warning btn-sm rounded-pill px-3">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Jakarta</td>
                            <td>
                                <a href="{{ url('/admin/barang/detail') }}"
                                   class="btn btn-warning btn-sm rounded-pill px-3">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Padang</td>
                            <td>
                                <a href="{{ url('/admin/barang/detail') }}"
                                   class="btn btn-warning btn-sm rounded-pill px-3">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
@endsection
