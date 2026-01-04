{{-- resources/views/admin/manajemen-petugas-create.blade.php --}}
@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'petugas'])
@endsection

@section('content')
    {{-- HEADER --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-3"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-user-plus" style="color:#198754;"></i>
                </div>
                <div>
                    <h5 class="mb-1">Tambah Petugas</h5>
                    <small class="text-muted">Buat akun petugas baru dan profilnya</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.petugas') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1" style="color:#fff;"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- ERROR VALIDATION --}}
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

    <form action="{{ route('admin.petugas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            {{-- LEFT: AKUN --}}
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="fw-semibold">
                                <i class="fa-solid fa-id-badge me-1" style="color:#6c757d;"></i> Data Akun
                            </div>
                            <span class="text-muted small">Wajib diisi</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Nama</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control rounded-pill @error('name') is-invalid @enderror"
                                    placeholder="Nama petugas">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik') }}"
                                    class="form-control rounded-pill @error('nik') is-invalid @enderror"
                                    placeholder="Contoh: 3275xxxxxxxxxxxx">
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control rounded-pill @error('email') is-invalid @enderror"
                                    placeholder="petugas@domain.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">Password</label>
                                <input type="password" name="password"
                                    class="form-control rounded-pill @error('password') is-invalid @enderror"
                                    placeholder="Minimal 6 karakter">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="fw-semibold mb-3">
                            <i class="fa-solid fa-address-book me-1" style="color:#6c757d;"></i> Kontak & Lokasi
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">No Telepon</label>
                                <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                                    class="form-control rounded-pill @error('no_telp') is-invalid @enderror"
                                    placeholder="08xxxxxxxxxx">
                                @error('no_telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">Cabang</label>
                                <select name="cabang_id"
                                    class="form-select rounded-pill @error('cabang_id') is-invalid @enderror">
                                    <option value="">- Pilih Cabang -</option>
                                    @foreach ($cabang ?? collect() as $c)
                                        <option value="{{ $c->id }}" @selected(old('cabang_id') == $c->id)>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cabang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label small text-muted">Alamat</label>
                                <textarea name="alamat" rows="3" class="form-control rounded-4 @error('alamat') is-invalid @enderror"
                                    placeholder="Alamat lengkap...">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: FOTO + STATUS --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body">
                        <div class="fw-semibold mb-3">
                            <i class="fa-solid fa-image me-1" style="color:#6c757d;"></i> Foto Petugas
                        </div>

                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror"
                            accept="image/png,image/jpeg,image/jpg,image/webp">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="text-muted small mt-2">
                            Format: jpg/png/webp (max 2MB).
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="fw-semibold mb-3">
                            <i class="fa-solid fa-toggle-on me-1" style="color:#6c757d;"></i> Status Akun
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan petugas
                            </label>
                        </div>

                        <div class="text-muted small mt-2">
                            Jika dimatikan, status menjadi non-aktif.
                        </div>

                        <hr class="my-4">

                        <div class="d-grid gap-2">
                            <button class="btn btn-success rounded-pill px-4">
                                <i class="fa-solid fa-floppy-disk me-1" style="color:#fff;"></i> Simpan
                            </button>

                            <a href="{{ route('admin.petugas') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
