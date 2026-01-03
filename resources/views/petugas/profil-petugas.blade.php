@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'profil'])
@endsection

@section('content')

    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-id-badge text-primary"></i>
                </div>
                <div>
                    <h5 class="mb-1">Profil Petugas</h5>
                    <small class="text-muted">Kelola data & foto profil petugas</small>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <div class="fw-semibold mb-1">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> Gagal:
            </div>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3">
        {{-- LEFT: PROFILE CARD --}}
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">

                    @php
                        $photo = $petugas->file_path ? asset('storage/' . $petugas->file_path) : null;
                    @endphp

                    <div class="mb-3">
                        @if ($photo)
                            <img src="{{ $photo }}" alt="Foto Profil" class="rounded-circle shadow-sm"
                                style="width:132px;height:132px;object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm"
                                style="width:132px;height:132px;">
                                <span class="fw-bold text-muted" style="font-size:34px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="fw-semibold" style="font-size:18px;">
                        {{ $user->name }}
                    </div>

                    <div class="text-muted small mb-2">
                        <i class="fa-regular fa-envelope me-1"></i>{{ $user->email }}
                    </div>

                    {{-- CABANG --}}
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 border rounded-pill mb-3">
                        <i class="fa-solid fa-building text-muted"></i>
                        <span class="text-muted">Cabang:</span>
                        <span class="fw-semibold">{{ $petugas->cabang->name ?? '-' }}</span>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm rounded-pill px-4" data-bs-toggle="modal"
                            data-bs-target="#photoModal">
                            <i class="fa-solid fa-camera me-1"></i> Ganti Foto
                        </button>

                        @if ($petugas->file_path)
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-4" data-bs-toggle="modal"
                                data-bs-target="#deletePhotoModal">
                                <i class="fa-solid fa-trash me-1"></i> Hapus Foto
                            </button>
                        @endif
                    </div>

                    <hr class="my-4">

                    {{-- QUICK INFO --}}
                    <div class="text-start">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small"><i class="fa-solid fa-phone me-1"></i>No. Telp</span>
                            <span class="fw-semibold small">{{ $petugas->no_telp ?? ($user->no_telp ?? '-') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="text-muted small"><i class="fa-solid fa-circle me-1"></i>Status</span>
                            <span class="fw-semibold small">
                                {{ $petugas->is_active ?? 0 ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- RIGHT: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="fw-semibold">
                            <i class="fa-solid fa-pen-to-square text-primary me-1"></i> Informasi Petugas
                        </div>
                        <span class="text-muted small">Perbarui data kontak & alamat</span>
                    </div>

                    <form method="POST" action="{{ route('petugas.profil-petugas.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input class="form-control" value="{{ $user->name }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <input class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa-solid fa-phone"></i>
                                    </span>
                                    <input type="text" name="no_telp" class="form-control"
                                        value="{{ old('no_telp', $petugas->no_telp ?? $user->no_telp) }}"
                                        placeholder="contoh: 08xxxxxxxxxx">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </span>
                                    <input class="form-control"
                                        value="{{ $petugas->is_active ?? 0 ? 'Aktif' : 'Nonaktif' }}" disabled>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </span>
                                    <textarea name="alamat" class="form-control" rows="3" placeholder="alamat petugas">{{ old('alamat', $petugas->alamat ?? $user->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button class="btn btn-success rounded-pill px-4" type="submit">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL GANTI FOTO --}}
    <div class="modal fade" id="photoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-body p-4">
                    <div class="text-center mb-3">
                        <div class="rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center"
                            style="width:54px;height:54px;">
                            <i class="fa-solid fa-camera text-primary"></i>
                        </div>
                        <div class="fw-semibold mt-2">Ganti Foto Profil</div>
                        <div class="text-muted small">Upload foto baru untuk profil petugas</div>
                    </div>

                    <form method="POST" action="{{ route('petugas.profil-petugas.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <input type="file" name="photo" class="form-control" accept="image/*" required>
                        <small class="text-muted d-block mt-2">Format jpg/png, max 2MB.</small>

                        <div class="mt-3 d-flex justify-content-center gap-2">
                            <button class="btn btn-primary rounded-pill px-4">
                                <i class="fa-solid fa-upload me-1"></i> Upload
                            </button>
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                Batal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS FOTO --}}
    <div class="modal fade" id="deletePhotoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-body text-center p-4">
                    <div class="mb-2">
                        <i class="fa-solid fa-triangle-exclamation text-danger fa-2x"></i>
                    </div>
                    <p class="fw-semibold mb-4">
                        Yakin hapus foto profil? Nanti akan kembali ke default.
                    </p>

                    <form method="POST" action="{{ route('petugas.profil-petugas.photo.delete') }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger rounded-pill px-4">
                            <i class="fa-solid fa-trash me-1"></i> Ya, Hapus
                        </button>
                    </form>

                    <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
