{{-- resources/views/admin/manajemen-cabang-create.blade.php --}}
@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'cabang'])
@endsection

@section('content')
    {{-- HEADER (lebih rapi + ada breadcrumb kecil) --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-4 bg-success-subtle d-flex align-items-center justify-content-center me-3 shadow-sm"
                    style="width:52px;height:52px;">
                    <i class="fa-solid fa-plus" style="color:#198754;"></i>
                </div>
                <div>
                    <div class="text-muted small mb-1">
                        <i class="fa-solid fa-location-dot me-1" style="color:#6c757d;"></i>
                        Cabang Lokasi <span class="mx-1">/</span> Tambah
                    </div>
                    <h5 class="mb-1">Tambah Cabang</h5>
                    <small class="text-muted">Tambahkan cabang lokasi baru untuk penyaluran bantuan</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1" style="color:#fff;"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- ERROR VALIDATION (lebih jelas) --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm border-0 rounded-4">
            <div class="fw-semibold mb-2">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> Periksa input kamu:
            </div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.cabang.store') }}">
        @csrf

        <div class="row g-4">
            {{-- LEFT: FORM --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="fw-semibold">
                                <i class="fa-solid fa-pen-ruler me-1" style="color:#6c757d;"></i> Informasi Cabang
                            </div>
                            <span class="text-muted small">Wajib diisi</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Nama Cabang</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fa-solid fa-building-flag" style="color:#6c757d;"></i>
                                    </span>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Contoh: Cabang Sleman">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">Status</label>
                                <div class="d-flex align-items-center justify-content-between border rounded-pill px-3 py-2 bg-white"
                                    style="height: 42px;">
                                    <div class="text-muted small">
                                        <i class="fa-solid fa-toggle-on me-1" style="color:#6c757d;"></i>
                                        Aktifkan cabang
                                    </div>
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                        <label class="form-check-label d-none" for="is_active">Aktif</label>
                                    </div>
                                </div>
                                <div class="text-muted small mt-2">
                                    Jika dimatikan, cabang dianggap nonaktif.
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small text-muted">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white align-items-start pt-2">
                                        <i class="fa-solid fa-location-crosshairs" style="color:#6c757d;"></i>
                                    </span>
                                    <textarea name="alamat" rows="4" class="form-control rounded-end @error('alamat') is-invalid @enderror"
                                        placeholder="Jl. ...">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.cabang') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Batal
                            </a>
                            <button class="btn btn-success rounded-pill px-4">
                                <i class="fa-solid fa-floppy-disk me-1" style="color:#fff;"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: TIPS / NOTE --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="fw-semibold mb-2">
                            <i class="fa-solid fa-circle-info me-1" style="color:#6c757d;"></i> Catatan
                        </div>
                        <div class="text-muted small">
                            <ul class="ps-3 mb-0">
                                <li>Gunakan nama cabang yang konsisten (misal: “Cabang Sleman”).</li>
                                <li>Alamat sebaiknya lengkap agar memudahkan distribusi.</li>
                                <li>Status “Aktif” menentukan cabang bisa dipakai untuk petugas.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 mt-4">
                    <div class="card-body">
                        <div class="fw-semibold mb-2">
                            <i class="fa-solid fa-shield-halved me-1" style="color:#6c757d;"></i> Validasi
                        </div>
                        <div class="text-muted small">
                            Sistem akan menolak jika nama/alamat kosong.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
