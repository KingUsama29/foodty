@extends('admin.layout')

@section('title', 'Riwayat Penyaluran')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <h4 class="fw-semibold mb-4">Riwayat Penyaluran</h4>

        <div class="rounded-4 p-4" style="background:#d7ebe2;">
            <table class="table table-bordered text-center bg-white">
                <thead class="table-light">
                    <tr>
                        <th>Kode Penyaluran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#34</td>
                        <td>
                            <span class="badge bg-warning text-dark">
                                Proses
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</main>
@endsection
