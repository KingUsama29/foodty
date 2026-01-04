@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'penyaluran'])
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-1">Isi Formulir Penyaluran Barang</h5>
            <small class="text-muted">Daerah: Medan</small>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <input type="text" class="form-control mb-3" value="Rizman" readonly>
            <input type="text" class="form-control mb-3" value="08123456789" readonly>
            <input type="text" class="form-control mb-3" value="327401xxxxxx" readonly>
            <input type="text" class="form-control mb-3" value="Bencana Alam" readonly>

            <textarea class="form-control mb-3" rows="3" readonly>
Stabat, Langkat, Medan
        </textarea>

            <textarea class="form-control mb-4" rows="3" readonly>
Beras, minyak, air minum
        </textarea>

            <a href="{{ route('admin.penyaluran.ringkasan') }}" class="btn btn-warning rounded-pill px-4">
                Kirim
            </a>

        </div>
    </div>
@endsection
