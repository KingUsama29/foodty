{{-- resources/views/admin/manajemen-petugas-edit.blade.php --}}
@extends('layouts.dashboard')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3" style="color:#6c757d;"></i> Dashboard
    </a>

    <a href="{{ route('admin.pengajuan') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-file-circle-check fa-fw me-3" style="color:#6c757d;"></i> Ajuan Bantuan
    </a>

    <a href="{{ route('admin.petugas') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-users-gear fa-fw me-3" style="color:#6c757d;"></i> Data Petugas
    </a>

    <a href="{{ route('admin.cabang') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-location-dot fa-fw me-3" style="color:#6c757d;"></i> Cabang Lokasi
    </a>

    <a href="{{ route('admin.stok') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-fw me-3" style="color:#6c757d;"></i> Stok Barang
    </a>

    <a href="{{ route('admin.penyaluran') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-fw me-3" style="color:#6c757d;"></i> Hasil Penyaluran
    </a>
@endsection

@section('content')
    @php
        $profile = $user->petugas ?? null;

        $photoUrl = $profile?->file_path ? asset('storage/' . $profile->file_path) : null;

        $oldName = old('name', $user->name);
        $oldNik = old('nik', $user->nik);
        $oldEmail = old('email', $user->email);

        $oldTelp = old('no_telp', $profile?->no_telp ?? $user->no_telp);
        $oldAlamat = old('alamat', $profile?->alamat ?? $user->alamat);

        $oldCabang = old('cabang_id', $profile?->cabang_id);
        $oldActive = old('is_active', (int) ($profile?->is_active ?? 0));
    @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center me-3"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-pen-to-square" style="color:#0dcaf0;"></i>
                </div>
                <div>
                    <h5 class="mb-1">Edit Petugas</h5>
                    <small class="text-muted">Ubah data akun petugas dan profilnya</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm rounded-pill px-3">
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

    <form action="{{ route('admin.petugas.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- LEFT: DATA UTAMA --}}
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="fw-semibold">
                                <i class="fa-solid fa-id-badge me-1" style="color:#6c757d;"></i> Data Akun
                            </div>
                            <span class="text-muted small">Ubah seperlunya</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Nama</label>
                                <input type="text" name="name" value="{{ $oldName }}"
                                    class="form-control rounded-pill @error('name') is-invalid @enderror"
                                    placeholder="Nama petugas">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">NIK</label>
                                <input type="text" name="nik" value="{{ $oldNik }}"
                                    class="form-control rounded-pill @error('nik') is-invalid @enderror" placeholder="NIK">
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">Email</label>
                                <input type="email" name="email" value="{{ $oldEmail }}"
                                    class="form-control rounded-pill @error('email') is-invalid @enderror"
                                    placeholder="Email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">Password Baru (opsional)</label>
                                <input type="password" name="password"
                                    class="form-control rounded-pill @error('password') is-invalid @enderror"
                                    placeholder="Kosongkan jika tidak diganti">
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
                                <input type="text" name="no_telp" value="{{ $oldTelp }}"
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
                                        <option value="{{ $c->id }}" @selected((string) $oldCabang === (string) $c->id)>
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
                                    placeholder="Alamat lengkap...">{{ $oldAlamat }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: FOTO + STATUS + ACTION --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body">
                        <div class="fw-semibold mb-3">
                            <i class="fa-solid fa-image me-1" style="color:#6c757d;"></i> Foto Petugas
                        </div>

                        @if ($photoUrl)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="{{ $photoUrl }}" class="rounded-circle shadow-sm"
                                    style="width:64px;height:64px;object-fit:cover" alt="Foto">
                                <div class="small text-muted">
                                    Foto saat ini tersimpan.<br>
                                    Upload baru jika mau diganti.
                                </div>
                            </div>
                        @else
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow-sm"
                                    style="width:64px;height:64px;">
                                    <i class="fa-solid fa-user" style="color:#6c757d;"></i>
                                </div>
                                <div class="small text-muted">
                                    Belum ada foto.
                                </div>
                            </div>
                        @endif

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
                                name="is_active" value="1" {{ (int) $oldActive === 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan petugas
                            </label>
                        </div>

                        <div class="text-muted small mt-2">
                            Jika dimatikan, status menjadi non-aktif.
                        </div>

                        <hr class="my-4">

                        <div class="d-grid gap-2">
                            <button class="btn btn-info text-white rounded-pill px-4">
                                <i class="fa-solid fa-floppy-disk me-1" style="color:#fff;"></i> Simpan Perubahan
                            </button>

                            <a href="{{ route('admin.petugas.detail', $user->id) }}"
                                class="btn btn-outline-secondary rounded-pill px-4">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>

                {{-- QUICK DELETE (opsional) --}}
                <div class="text-muted small mt-3">
                    <i class="fa-solid fa-circle-info me-1" style="color:#6c757d;"></i>
                    Password boleh dikosongkan kalau tidak ingin mengganti.
                </div>
            </div>
        </div>
    </form>
@endsection
