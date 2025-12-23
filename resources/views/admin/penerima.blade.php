@extends('admin.layout')

@section('title', 'Data Penerima')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <h4 class="fw-semibold mb-4">Data Penerima</h4>

        <div class="rounded-4 p-4" style="background:#d7ebe2;">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center bg-white">
                    <thead class="table-light">
                        <tr>
                            <th>Pengaju</th>
                            <th>Detail</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- MENUNGGU -->
                        <tr>
                            <td>Rizman</td>
                            <td>
                                <a href="{{ url('/admin/penerima/detail') }}"
                                   class="btn btn-warning btn-sm rounded-pill px-3">
                                    Lihat
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm rounded-pill px-3 me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalAcc">
                                    Acc
                                </button>
                                <button class="btn btn-danger btn-sm rounded-pill px-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalTolak">
                                    Tolak
                                </button>
                            </td>
                        </tr>

                        <!-- SUDAH ACC -->
                        <tr>
                            <td>Andi Saputra</td>
                            <td>
                                <a href="{{ url('/admin/penerima/detail') }}"
                                   class="btn btn-warning btn-sm rounded-pill px-3">
                                    Lihat
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-success">Acc</span>
                            </td>
                        </tr>

                        <!-- DITOLAK -->
                        <tr>
                            <td>Siti Rahma</td>
                            <td>
                                <a href="{{ url('/admin/penerima/detail') }}"
                                   class="btn btn-warning btn-sm rounded-pill px-3">
                                    Lihat
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-danger">Ditolak</span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<!-- MODAL ACC -->
<div class="modal fade" id="modalAcc" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h6 class="modal-title">Konfirmasi ACC</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                Apakah anda yakin akan <strong>ACC</strong> pengajuan ini?
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button class="btn btn-success rounded-pill px-4" data-bs-dismiss="modal">Ya</button>
                <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TOLAK -->
<div class="modal fade" id="modalTolak" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h6 class="modal-title">Konfirmasi Tolak</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                Apakah anda yakin akan <strong>MENOLAK</strong> pengajuan ini?
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal">Ya</button>
                <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
</div>
@endsection
