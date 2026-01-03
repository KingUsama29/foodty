@extends('layouts.dashboard')

@section('sidebar-menu')
    @php
        $status = auth()->user()->latestRecipientVerification?->verification_status ?? 'pending';
    @endphp
    @include('partials.sidebar-penerima', ['active' => 'dashboard'])
@endsection

@section('content')
    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-file-pen text-primary"></i>
                </div>
                <div>
                    <h5 class="mb-1">Form Verifikasi Penerima</h5>
                    <small class="text-muted">Lengkapi data sesuai ketentuan</small>
                </div>
            </div>

            <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                <i class="fa-solid fa-shield-halved me-1"></i> Verifikasi Akun
            </span>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">

            <form method="POST" action="{{ route('verifikasi.logic') }}" enctype="multipart/form-data" class="row g-4">
                @csrf

                {{-- SECTION: DOKUMEN --}}
                <div class="col-12">
                    <div class="fw-semibold mb-2">
                        <i class="fa-regular fa-image me-1 text-primary"></i> Upload Dokumen
                    </div>
                    <div class="text-muted" style="font-size: 13px;">
                        Pastikan foto jelas, tidak blur, dan seluruh bagian dokumen terlihat.
                    </div>
                </div>

                {{-- FOTO KTP --}}
                <div class="col-12 col-md-4">
                    <div class="border rounded-4 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-semibold">
                                <i class="fa-solid fa-id-card me-1 text-primary"></i> Foto KTP
                            </div>
                            <small class="text-muted">Wajib</small>
                        </div>

                        <input type="file" name="ktp" class="form-control" accept="image/*"
                            onchange="previewImage(this, 'previewKtp')">

                        @error('ktp')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                        <div class="mt-3 border rounded-3 overflow-hidden bg-light">
                            <img id="previewKtp" class="img-fluid w-100 d-none" style="max-height:180px;object-fit:cover;">
                        </div>
                    </div>
                </div>

                {{-- SELFIE + KTP --}}
                <div class="col-12 col-md-4">
                    <div class="border rounded-4 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-semibold">
                                <i class="fa-solid fa-camera me-1 text-primary"></i> Selfie + KTP
                            </div>
                            <small class="text-muted">Wajib</small>
                        </div>

                        <input type="file" name="selfie_ktp" class="form-control" accept="image/*"
                            onchange="previewImage(this, 'previewSelfie')">

                        @error('selfie_ktp')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                        <div class="mt-3 border rounded-3 overflow-hidden bg-light">
                            <img id="previewSelfie" class="img-fluid w-100 d-none"
                                style="max-height:180px;object-fit:cover;">
                        </div>
                    </div>
                </div>

                {{-- KK --}}
                <div class="col-12 col-md-4">
                    <div class="border rounded-4 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-semibold">
                                <i class="fa-solid fa-file-lines me-1 text-primary"></i> Kartu Keluarga (KK)
                            </div>
                            <small class="text-muted">Wajib</small>
                        </div>

                        <input type="file" name="kk" class="form-control" accept="image/*"
                            onchange="previewImage(this, 'previewKk')">

                        @error('kk')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                        <div class="mt-3 border rounded-3 overflow-hidden bg-light">
                            <img id="previewKk" class="img-fluid w-100 d-none" style="max-height:180px;object-fit:cover;">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <hr class="my-1">
                </div>

                {{-- SECTION: DATA PRIBADI --}}
                <div class="col-12">
                    <div class="fw-semibold mb-2">
                        <i class="fa-solid fa-user me-1 text-primary"></i> Data Pribadi
                    </div>
                </div>

                {{-- Nama --}}
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">Nama (sesuai KTP)</label>
                    <input type="text" name="full_name" class="form-control rounded-pill" placeholder="Nama sesuai KTP"
                        value="{{ old('full_name') }}">
                    @error('full_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- No Telepon (opsional) --}}
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">No Telepon Aktif (opsional)</label>
                    <input type="tel" name="phone" class="form-control rounded-pill" placeholder="08xxxxxxxxxx"
                        value="{{ old('phone') }}">
                </div>

                {{-- NIK readonly --}}
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">NIK (otomatis)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fa-solid fa-hashtag"></i>
                        </span>
                        <input type="text" class="form-control" value="{{ auth()->user()->nik }}" readonly>
                    </div>
                    <small class="text-muted">NIK diambil dari akun kamu.</small>
                </div>

                {{-- Nomor KK --}}
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">Nomor KK</label>
                    <input type="text" name="kk_number" class="form-control rounded-pill"
                        placeholder="16 digit nomor KK" value="{{ old('kk_number') }}">
                    @error('kk_number')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <hr class="my-1">
                </div>

                {{-- SECTION: ALAMAT --}}
                <div class="col-12">
                    <div class="fw-semibold mb-2">
                        <i class="fa-solid fa-location-dot me-1 text-primary"></i> Alamat
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control rounded-4" rows="3" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Province / City / District / Postal Code --}}
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold">Provinsi</label>
                    <input type="text" name="province" class="form-control rounded-pill" placeholder="Provinsi"
                        value="{{ old('province') }}">
                    @error('province')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold">Kota/Kabupaten</label>
                    <input type="text" name="city" class="form-control rounded-pill" placeholder="Kota/Kabupaten"
                        value="{{ old('city') }}">
                    @error('city')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold">Kecamatan</label>
                    <input type="text" name="district" class="form-control rounded-pill" placeholder="Kecamatan"
                        value="{{ old('district') }}">
                    @error('district')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold">Kode Pos</label>
                    <input type="text" name="postal_code" class="form-control rounded-pill" placeholder="Kode Pos"
                        value="{{ old('postal_code') }}">
                    @error('postal_code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- SUBMIT --}}
                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold py-2">
                        <i class="fa-solid fa-paper-plane me-1"></i> Ajukan Verifikasi
                    </button>
                    <div class="text-muted text-center mt-2" style="font-size: 13px;">
                        Dengan mengajukan, kamu menyatakan data yang dimasukkan benar.
                    </div>
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
