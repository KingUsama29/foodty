@extends('admin.layout')

@section('title', 'Detail Barang')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <h4 class="fw-semibold mb-4">Detail Barang</h4>

        <div class="rounded-4 p-4" style="background:#d7ebe2;">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center bg-white">
                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Beras 10 kg</td>
                            <td>107</td>
                        </tr>
                        <tr>
                            <td>Minyak 5 Liter</td>
                            <td>168</td>
                        </tr>
                        <tr>
                            <td>Air Minum 1 Kotak</td>
                            <td>109</td>
                        </tr>
                        <tr>
                            <td>Roti Kering</td>
                            <td>248</td>
                        </tr>
                        <tr>
                            <td>Susu Bayi</td>
                            <td>158</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="{{ url('/admin/barang') }}"
                   class="btn btn-light rounded-pill px-5">
                    Kembali
                </a>
            </div>
        </div>

    </div>
</main>
@endsection
