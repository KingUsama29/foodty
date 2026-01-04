{{-- resources/views/admin/manajemen-cabang-edit.blade.php --}}
@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-admin', ['active' => 'cabang'])
@endsection

@section('content')
    @php
        $oldName = old('name', $cabang->name);
        $oldAlamat = old('alamat', $cabang->alamat);
        $oldActive = old('is_active', (int) $cabang->is_active);
    @endphp

    {{-- HEADER (lebih rapi + breadcrumb kecil) --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-4 bg-info-subtle d-flex align-items-center justify-content-center me-3 shadow-sm"
                    style="width:52px;height:52px;">
                    <i class="fa-solid fa-pen-to-square" style="color:#0dcaf0;"></i>
                </div>
                <div>
                    <div class="text-muted small mb-1">
                        <i class="fa-solid fa-location-dot me-1" style="color:#6c757d;"></i>
                        Cabang Lokasi <span class="mx-1">/</span> Edit <span class="mx-1">/</span>
                        <span class="fw-semibold">{{ $cabang->name }}</span>
                    </div>
                    <h5 class="mb-1">Edit Cabang</h5>
                    <small class="text-muted">Ubah informasi cabang lokasi dan status aktif</small>
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

    <form method="POST" action="{{ route('admin.cabang.update', $cabang->id) }}">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- LEFT: FORM --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="fw-semibold">
                                <i class="fa-solid fa-pen-ruler me-1" style="color:#6c757d;"></i> Informasi Cabang
                            </div>
                            <span class="text-muted small">Edit data</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Nama Cabang</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fa-solid fa-building-flag" style="color:#6c757d;"></i>
                                    </span>
                                    <input type="text" name="name" value="{{ $oldName }}"
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
                                            value="1" {{ (int) $oldActive === 1 ? 'checked' : '' }}>
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
                                        placeholder="Jl. ...">{{ $oldAlamat }}</textarea>
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
                            <button class="btn btn-info text-white rounded-pill px-4">
                                <i class="fa-solid fa-floppy-disk me-1" style="color:#fff;"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: INFO BOX --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="fw-semibold mb-2">
                            <i class="fa-solid fa-circle-info me-1" style="color:#6c757d;"></i> Info
                        </div>
                        <div class="text-muted small">
                            <div class="mb-2">
                                <span class="fw-semibold">ID Cabang:</span> {{ $cabang->id }}
                            </div>
                            <div class="mb-2">
                                <span class="fw-semibold">Dibuat:</span>
                                {{ $cabang->created_at?->format('d M Y, H:i') ?? '-' }}
                            </div>
                            <div>
                                <span class="fw-semibold">Terakhir Update:</span>
                                {{ $cabang->updated_at?->format('d M Y, H:i') ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 mt-4">
                    <div class="card-body">
                        <div class="fw-semibold mb-2">
                            <i class="fa-solid fa-shield-halved me-1" style="color:#6c757d;"></i> Catatan
                        </div>
                        <div class="text-muted small">
                            Pastikan nama cabang konsisten agar mudah dipilih saat membuat petugas.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
