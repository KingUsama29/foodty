@extends('admin.layout')

@section('title', 'Salurkan')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <h4 class="fw-semibold mb-4">Salurkan</h4>

        <div class="rounded-4 p-4" style="background:#d7ebe2;">
            <table class="table table-bordered text-center bg-white">
                <thead class="table-light">
                    <tr>
                        <th>Petugas</th>
                        <th>Salurkan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(['Medan','Yogyakarta','Jakarta','Padang'] as $cabang)
                    <tr>
                        <td>{{ $cabang }}</td>
                        <td>
                            <a href="{{ url('/admin/salurkan/form') }}"
                               class="btn btn-warning btn-sm rounded-pill px-3">
                                Klik
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center mt-4">
                <a href="{{ url('/admin/salurkan/riwayat') }}"
                   class="btn btn-light rounded-pill px-5">
                    Riwayat
                </a>
            </div>
        </div>

    </div>
</main>
@endsection
