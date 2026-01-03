@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'profil'])
@endsection

@section('content')

    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fa-solid fa-id-badge fa-lg text-primary me-3"></i>
            <div>
                <h5 class="mb-1">Profil Petugas</h5>
                <small class="text-muted">Kelola data & foto profil petugas</small>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

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

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">

                    @php
                        $photo = $petugas->file_path ? asset('storage/' . $petugas->file_path) : null;
                    @endphp

                    <div class="mb-3">
                        @if ($photo)
                            <img src="{{ $photo }}" alt="Foto Profil" class="rounded-circle shadow-sm"
                                style="width:130px;height:130px;object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm"
                                style="width:130px;height:130px;">
                                <span class="fw-bold text-muted" style="font-size:34px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <h6 class="fw-semibold mb-1">{{ $user->name }}</h6>
                    <div class="text-muted small mb-2">{{ $user->email }}</div>

                    {{-- NAMA CABANG --}}
                    <div class="small mb-3">
                        <span class="text-muted">Cabang:</span>
                        <span class="fw-semibold">{{ $petugas->cabang->name ?? '-' }}</span>
                    </div>

                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <button class="btn btn-outline-primary btn-sm rounded-pill px-4" data-bs-toggle="modal"
                            data-bs-target="#photoModal">
                            Ganti Foto
                        </button>

                        @if ($petugas->file_path)
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-4" data-bs-toggle="modal"
                                data-bs-target="#deletePhotoModal">
                                Hapus Foto
                            </button>
                        @endif
                    </div>

                </div>

            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Informasi Petugas</h6>

                    <form method="POST" action="{{ route('petugas.profil-petugas.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input class="form-control" value="{{ $user->name }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input class="form-control" value="{{ $user->email }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="no_telp" class="form-control"
                                    value="{{ old('no_telp', $petugas->no_telp ?? $user->no_telp) }}"
                                    placeholder="contoh: 08xxxxxxxxxx">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <input class="form-control" value="{{ $petugas->is_active ?? 0 ? 'Aktif' : 'Nonaktif' }}"
                                    disabled>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" placeholder="alamat petugas">{{ old('alamat', $petugas->alamat ?? $user->alamat) }}</textarea>
                            </div>
                        </div>

                        {{-- input photo disimpan di modal, tapi kalau kamu mau 1 form aja, bisa taruh juga di sini (opsional) --}}
                        <div class="mt-4">
                            <button class="btn btn-success rounded-pill px-4" type="submit">Simpan Perubahan</button>
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
                    <p class="fw-semibold mb-3 text-center">Ganti Foto Profil</p>

                    <form method="POST" action="{{ route('petugas.profil-petugas.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <input type="file" name="photo" class="form-control" accept="image/*" required>
                        <small class="text-muted d-block mt-2">Format jpg/png, max 2MB.</small>

                        <div class="mt-3 text-center">
                            <button class="btn btn-primary rounded-pill px-4">Upload</button>
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
                    <p class="fw-semibold mb-4">
                        Yakin hapus foto profil? Nanti akan kembali ke default.
                    </p>

                    <form method="POST" action="{{ route('petugas.profil-petugas.photo.delete') }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger rounded-pill px-4">Ya, Hapus</button>
                    </form>

                    <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
