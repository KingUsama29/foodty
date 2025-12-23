@extends('admin.layout')

@section('title', 'Cabang Lokasi')

@section('content')
<main class="py-5">
    <div class="container-fluid px-5">

        <h4 class="fw-semibold mb-4">Cabang Lokasi</h4>

        <div class="rounded-4 p-4" style="background:#d7ebe2;">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center bg-white">
                    <thead class="table-light">
                        <tr>
                            <th>Cabang</th>
                            <th>Total Petugas</th>
                            <th>Menangani</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Medan</td>
                            <td>46</td>
                            <td>31 Daerah</td>
                        </tr>
                        <tr>
                            <td>Yogyakarta</td>
                            <td>32</td>
                            <td>17 Daerah</td>
                        </tr>
                        <tr>
                            <td>Jakarta</td>
                            <td>41</td>
                            <td>24 Daerah</td>
                        </tr>
                        <tr>
                            <td>Padang</td>
                            <td>43</td>
                            <td>34 Daerah</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
@endsection
