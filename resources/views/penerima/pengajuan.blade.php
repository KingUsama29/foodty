@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU ================= --}}
@section('sidebar-menu')
    @php
        $status = auth()->user()->latestRecipientVerification?->verification_status ?? 'pending';
    @endphp
    @include('partials.sidebar-penerima', ['active' => 'pengajuan'])
@endsection

@section('content')
    @php
        $user = auth()->user();
        $status = $user?->latestRecipientVerification?->verification_status ?? 'pending';
    @endphp

    {{-- ================= HEADER ================= --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                    style="width:44px;height:44px;">
                    <i class="fa-solid fa-file-circle-plus text-primary"></i>
                </div>
                <div>
                    <h5 class="mb-1">Pengajuan Bantuan</h5>
                    <small class="text-muted">Lengkapi data pengajuan bantuan</small>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('failed'))
        <div class="alert alert-danger shadow-sm">
            <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ session('failed') }}
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

    {{-- ================= FORM AJUAN ================= --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">

            {{-- JIKA BELUM LOGIN --}}
            @if (!auth()->check())
                <div class="alert alert-warning mb-0">
                    <i class="fa-solid fa-right-to-bracket me-1"></i>
                    Silakan login terlebih dahulu untuk mengajukan bantuan.
                </div>

                {{-- JIKA BELUM APPROVED --}}
            @elseif($status !== 'approved')
                <div class="alert alert-info mb-0">
                    <div class="fw-semibold mb-1">
                        <i class="fa-solid fa-id-card me-1"></i> Verifikasi diperlukan
                    </div>
                    Silakan lakukan <b>Verifikasi Data</b> terlebih dahulu. Setelah disetujui, Anda dapat mengajukan
                    bantuan.
                    <div class="mt-3">
                        <a href="{{ route('verifikasi') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="fa-solid fa-arrow-right me-1"></i> Ke Halaman Verifikasi
                        </a>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('penerima.pengajuan.store') }}" enctype="multipart/form-data"
                    class="row g-4">
                    @csrf

                    {{-- SECTION: UNTUK SIAPA --}}
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-semibold">
                                <i class="fa-solid fa-users me-1 text-primary"></i> Data Penerima Bantuan
                            </div>
                            <small class="text-muted">Pilih tujuan pengajuan</small>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Pengajuan Untuk</label>
                                <select name="request_for" id="request_for" class="form-select rounded-pill" required>
                                    <option value="self" @selected(old('request_for', 'self') === 'self')>Diri sendiri</option>
                                    <option value="other" @selected(old('request_for') === 'other')>Orang lain</option>
                                </select>
                                <small class="text-muted d-block mt-1">
                                    Kalau kamu bantu orang lain, pilih “Orang lain”.
                                </small>
                            </div>

                            {{-- DATA PENERIMA (DB: recipient_name, recipient_phone, relationship) --}}
                            <div class="col-12" id="recipientFields" style="display:none;">
                                <div class="border rounded-4 p-3 p-md-4 bg-light">
                                    <div class="fw-semibold mb-3">
                                        <i class="fa-solid fa-user-group me-1"></i> Data penerima (orang lain)
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">Nama Penerima</label>
                                            <input type="text" name="recipient_name" class="form-control rounded-pill"
                                                value="{{ old('recipient_name') }}" placeholder="Nama lengkap penerima">
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">No. HP Penerima</label>
                                            <input type="text" name="recipient_phone" class="form-control rounded-pill"
                                                value="{{ old('recipient_phone') }}" placeholder="08xxxxxxxxxx">
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">Hubungan Dengan Penerima</label>
                                            <input type="text" name="relationship" class="form-control rounded-pill"
                                                value="{{ old('relationship') }}"
                                                placeholder="Contoh: saudara, tetangga, teman">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-1">

                    {{-- SECTION: DATA PENGAJUAN --}}
                    <div class="col-12">
                        <div class="fw-semibold mb-2">
                            <i class="fa-solid fa-file-pen me-1 text-primary"></i> Data Pengajuan
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Kategori Pengajuan</label>
                                <select name="category" class="form-select rounded-pill" required>
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    <option value="lansia" @selected(old('category') === 'lansia')>Lansia</option>
                                    <option value="ibu_balita" @selected(old('category') === 'ibu_balita')>Ibu Bayi / Balita</option>
                                    <option value="bencana" @selected(old('category') === 'bencana')>Bencana Alam</option>
                                    <option value="kehilangan_pekerjaan" @selected(old('category') === 'kehilangan_pekerjaan')>Kehilangan Pekerjaan
                                    </option>
                                    <option value="yatim_piatu" @selected(old('category') === 'yatim_piatu')>Yatim Piatu</option>
                                    <option value="tunawisma" @selected(old('category') === 'tunawisma')>Tunawisma</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Jumlah Tanggungan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa-solid fa-people-group"></i>
                                    </span>
                                    <input type="number" min="0" name="dependents" class="form-control"
                                        value="{{ old('dependents') }}" placeholder="contoh: 4">
                                </div>
                                <small class="text-muted">Boleh kosong kalau tidak ada.</small>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Kebutuhan Utama</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa-solid fa-bowl-rice"></i>
                                    </span>
                                    <input type="text" name="main_needs" class="form-control"
                                        value="{{ old('main_needs') }}"
                                        placeholder="contoh: beras, susu bayi, lauk, sembako" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: ALAMAT & ALASAN --}}
                    <div class="col-12">
                        <div class="fw-semibold mb-2">
                            <i class="fa-solid fa-location-dot me-1 text-primary"></i> Alamat & Alasan
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Alamat Lengkap + Patokan</label>
                                <textarea name="address_detail" class="form-control rounded-4" rows="3"
                                    placeholder="Contoh: Jl. Mawar RT 02, dekat pos ronda / warung..." required>{{ old('address_detail') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Alasan Pengajuan</label>
                                <textarea name="reason" class="form-control rounded-4" rows="4"
                                    placeholder="Jelaskan kondisi saat ini (misal: sakit, korban bencana, dll)" required>{{ old('reason') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Deskripsi (opsional)</label>
                                <textarea name="description" class="form-control rounded-4" rows="3"
                                    placeholder="Boleh kosong. Tambahkan info lain kalau perlu...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: BUKTI --}}
                    <div class="col-12">
                        <div class="fw-semibold mb-2">
                            <i class="fa-regular fa-image me-1 text-primary"></i> Bukti Pendukung
                        </div>

                        <div class="border rounded-4 p-3 p-md-4 bg-light">
                            <div class="row g-3 align-items-center">
                                <div class="col-12 col-md-7">
                                    <label class="form-label fw-semibold">Upload Bukti (1 file)</label>
                                    <input type="file" name="file_path" class="form-control" accept="image/*"
                                        required onchange="previewImage(this, 'previewBukti')">
                                    <small class="text-muted d-block mt-2">
                                        1 file saja (jpg/png/jpeg). Kalau banyak, gabungkan jadi 1 foto/kolase.
                                    </small>
                                </div>

                                <div class="col-12 col-md-5 text-center">
                                    <img id="previewBukti" class="img-fluid rounded shadow-sm d-none"
                                        style="max-height:180px;" alt="Preview Bukti">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold py-2">
                            <i class="fa-solid fa-paper-plane me-1"></i> Ajukan Bantuan
                        </button>
                    </div>

                </form>
            @endif

        </div>
    </div>

    {{-- ================= JS ================= --}}
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

        function toggleRecipientFields() {
            const select = document.getElementById('request_for');
            const wrap = document.getElementById('recipientFields');
            if (!select || !wrap) return;

            const isOther = select.value === 'other';
            wrap.style.display = isOther ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleRecipientFields();
            document.getElementById('request_for')?.addEventListener('change', toggleRecipientFields);
        });
    </script>
@endsection
