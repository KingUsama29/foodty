@extends('layouts.dashboard')

@section('sidebar-menu')
    <a href="{{ route('penerima.dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i>
        Dashboard
    </a>

    <a href="{{ route('verifikasi') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-file-pen fa-fw me-3"></i>
        Pengajuan Bantuan
    </a>

    <a href="{{ route('penerima.riwayat') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-clock-rotate-left fa-fw me-3"></i>
        Riwayat
    </a>
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center gap-2">
            <i class="fa-solid fa-file-pen fa-lg text-primary"></i>
            <div>
                <h5 class="mb-1">Form Verifikasi Penerima</h5>
                <small class="text-muted">Lengkapi data sesuai ketentuan</small>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0 w-100" style="border-radius:28px;">
        <div class="card-body p-4 p-md-5">

            <form method="POST" action="{{ route('verifikasi.logic') }}" enctype="multipart/form-data" class="row g-3">
                @csrf

                {{-- FOTO KTP --}}
                <div class="col-12 col-md-4 text-center">
                    <label class="form-label fw-semibold">Foto KTP</label>
                    <input type="file" name="ktp" class="form-control" accept="image/*"
                        onchange="previewImage(this, 'previewKtp')">
                    <img id="previewKtp" class="img-fluid rounded shadow-sm mt-2 d-none" style="max-height:180px;">
                    @error('ktp')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- SELFIE + KTP --}}
                <div class="col-12 col-md-4 text-center">
                    <label class="form-label fw-semibold">Selfie + KTP</label>
                    <input type="file" name="selfie_ktp" class="form-control" accept="image/*"
                        onchange="previewImage(this, 'previewSelfie')">
                    <img id="previewSelfie" class="img-fluid rounded shadow-sm mt-2 d-none" style="max-height:180px;">
                    @error('selfie_ktp')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- KK --}}
                <div class="col-12 col-md-4 text-center">
                    <label class="form-label fw-semibold">Kartu Keluarga (KK)</label>
                    <input type="file" name="kk" class="form-control" accept="image/*"
                        onchange="previewImage(this, 'previewKk')">
                    <img id="previewKk" class="img-fluid rounded shadow-sm mt-2 d-none" style="max-height:180px;">
                    @error('kk')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Nama --}}
                <div class="col-12 col-md-6">
                    <input type="text" name="full_name" class="form-control rounded-pill shadow-sm"
                        placeholder="Nama (sesuai KTP)" value="{{ old('full_name') }}">
                    @error('full_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- No Telepon (kalau memang dipakai & ada kolomnya) --}}
                <div class="col-12 col-md-6">
                    <input type="tel" name="phone" class="form-control rounded-pill shadow-sm"
                        placeholder="No Telepon Aktif" value="{{ old('phone') }}">
                </div>

                {{-- NIK auto (tampilan aja, gak usah dikirim) --}}
                <div class="col-12 col-md-6">
                    <input type="text" class="form-control rounded-pill shadow-sm" placeholder="NIK"
                        value="{{ auth()->user()->nik }}" readonly>
                </div>

                {{-- Nomor KK --}}
                <div class="col-12 col-md-6">
                    <input type="text" name="kk_number" class="form-control rounded-pill shadow-sm"
                        placeholder="Nomor KK" value="{{ old('kk_number') }}">
                    @error('kk_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="col-12">
                    <textarea name="alamat" class="form-control rounded-4 shadow-sm" rows="3" placeholder="Alamat">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Province / City / District / Postal Code (WAJIB sesuai validate controller) --}}
                <div class="col-12 col-md-3">
                    <input type="text" name="province" class="form-control rounded-pill shadow-sm" placeholder="Provinsi"
                        value="{{ old('province') }}">
                    @error('province')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 col-md-3">
                    <input type="text" name="city" class="form-control rounded-pill shadow-sm"
                        placeholder="Kota/Kabupaten" value="{{ old('city') }}">
                    @error('city')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 col-md-3">
                    <input type="text" name="district" class="form-control rounded-pill shadow-sm"
                        placeholder="Kecamatan" value="{{ old('district') }}">
                    @error('district')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 col-md-3">
                    <input type="text" name="postal_code" class="form-control rounded-pill shadow-sm"
                        placeholder="Kode Pos" value="{{ old('postal_code') }}">
                    @error('postal_code')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold py-2">
                        Ajukan
                    </button>
                </div>

                <div class="col-12">
                    <hr class="my-4">
                </div>
            </form>

        </div>
    </div>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (!preview) return;

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
