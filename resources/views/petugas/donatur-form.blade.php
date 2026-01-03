@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'donatur'])
@endsection

@section('content')

    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-user-pen fa-lg text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">
                        {{ $mode === 'create' ? 'Tambah Donatur' : 'Edit Donatur' }}
                    </h5>
                    <small class="text-muted">Isi data donatur dengan benar</small>
                </div>
            </div>

            <a href="{{ route('petugas.data-donatur') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <div class="fw-semibold mb-1">Gagal:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST"
                action="{{ $mode === 'create' ? route('petugas.donatur.store') : route('petugas.donatur.update', $donor->id) }}">

                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tipe Donatur</label>
                        <select name="type" class="form-select" required>
                            <option value="individu" @selected(old('type', $donor->type) === 'individu')>individu</option>
                            <option value="komunitas" @selected(old('type', $donor->type) === 'komunitas')>komunitas</option>
                            <option value="instansi" @selected(old('type', $donor->type) === 'instansi')>Instansi</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Nama Donatur</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $donor->name) }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $donor->phone) }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email (opsional)</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $donor->email) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat (opsional)</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $donor->address) }}</textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-success rounded-pill px-4" type="submit">
                        {{ $mode === 'create' ? 'Simpan' : 'Update' }}
                    </button>

                    <a href="{{ route('petugas.data-donatur') }}" class="btn btn-secondary rounded-pill px-4">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection
