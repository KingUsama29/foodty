@extends('admin.layout')

@section('title', 'Ringkasan Penyaluran')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <h4 classasi="fw-semibold mb-4">Ringkasan Penyaluran</h4>

        <div class="mx-auto rounded-4 p-4"
             style="max-width:700px; background:#d7ebe2;">

            <table class="table table-bordered bg-white mb-4">
                <tbody>
                    <tr>
                        <th width="35%">Kode Penyaluran</th>
                        <td>#34</td>
                    </tr>
                    <tr>
                        <th>Nama Penerima</th>
                        <td>Rizman</td>
                    </tr>
                    <tr>
                        <th>Cabang / Petugas</th>
                        <td>Medan</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>Bencana Alam</td>
                    </tr>
                    <tr>
                        <th>Barang Disalurkan</th>
                        <td>
                            Beras 10 kg, Minyak 5 Liter, Air Minum 1 Kotak
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-warning text-dark">
                                Menunggu Pengantaran
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <a href="{{ url('/admin/salurkan/form') }}"
                   class="btn btn-secondary rounded-pill px-4">
                    Kembali
                </a>

                <a href="{{ url('/admin/salurkan/riwayat') }}"
                   class="btn btn-success rounded-pill px-4">
                    Lihat Riwayat
                </a>
            </div>

        </div>

    </div>
</main>
@endsection
