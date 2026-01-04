@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'penyaluran'])
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-1">Riwayat Penyaluran</h5>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table mb-0">
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
                            <span class="badge bg-warning">Proses</span>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
@endsection
