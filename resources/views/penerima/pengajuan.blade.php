@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU ================= --}}
@section('sidebar-menu')

    {{-- DASHBOARD --}}
    <a href="{{ route('penerima.dashboard') }}"
       class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i>
        Dashboard
    </a>

    {{-- VERIFIKASI DATA --}}
    <a href="/pilihform"
       class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-user-check fa-fw me-3"></i>
        Verifikasi Data
    </a>

    {{-- PENGAJUAN BANTUAN --}}
    @if(auth()->check() && auth()->user()->verification_status === 'approved')

        <a href="/pengajuan"
           class="list-group-item list-group-item-action active d-flex align-items-center">
            <i class="fa-solid fa-file-circle-plus fa-fw me-3"></i>
            Pengajuan Bantuan
        </a>

    @else

        <a href="/pilihform"
           class="list-group-item list-group-item-action disabled d-flex align-items-center"
           style="opacity:0.6; cursor:not-allowed;">
            <i class="fa-solid fa-lock fa-fw me-3"></i>
            Pengajuan Bantuan
        </a>

    @endif

    {{-- RIWAYAT --}}
    <a href="{{ route('penerima.riwayat') }}"
       class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-clock-rotate-left fa-fw me-3"></i>
        Riwayat
    </a>

@endsection


@section('content')

{{-- ================= HEADER ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center gap-2">
        <i class="fa-solid fa-file-circle-plus fa-lg text-primary"></i>
        <div>
            <h5 class="mb-1">Pengajuan Bantuan</h5>
            <small class="text-muted">
                Lengkapi data pengajuan bantuan
            </small>
        </div>
    </div>
</div>

{{-- ================= FORM AJUAN ================= --}}
<div class="card shadow-lg border-0 w-100" style="border-radius:28px;">
    <div class="card-body p-4 p-md-5">

        {{-- JIKA BELUM LOGIN --}}
        @if(!auth()->check())
            <div class="alert alert-warning">
                Silakan login terlebih dahulu untuk mengajukan bantuan.
            </div>
        @elseif(auth()->user()->verification_status !== 'approved')
            <div class="alert alert-info">
                Silakan lakukan <b>Verifikasi Data</b> terlebih dahulu.
                Setelah disetujui, Anda dapat mengajukan bantuan.
            </div>
        @else

            {{-- FORM --}}
            <form method="POST" action="/pengajuan"
                  enctype="multipart/form-data" class="row g-3">
                @csrf

                {{-- NIK --}}
                <div class="col-12 col-md-6">
                    <input type="text" name="nik"
                           class="form-control rounded-pill shadow-sm"
                           placeholder="NIK" required>
                </div>

                {{-- NAMA --}}
                <div class="col-12 col-md-6">
                    <input type="text" name="nama"
                           class="form-control rounded-pill shadow-sm"
                           placeholder="Nama Pengguna" required>
                </div>

                {{-- KATEGORI --}}
                <div class="col-12">
                    <select name="kategori"
                            class="form-select rounded-pill shadow-sm"
                            required>
                        <option value="" selected disabled>Pilih Salah Satu</option>
                        <option value="lansia">Lansia</option>
                        <option value="ibu_balita">Ibu Bayi / Balita</option>
                        <option value="bencana">Bencana Alam</option>
                        <option value="kehilangan_pekerjaan">Kehilangan Pekerjaan</option>
                        <option value="yatim_piatu">Yatim Piatu</option>
                        <option value="tunawisma">Tunawisma</option>
                    </select>
                </div>

                {{-- DESKRIPSI --}}
                <div class="col-12">
                    <textarea name="deskripsi" rows="4"
                              class="form-control rounded-4 shadow-sm"
                              placeholder="Deskripsi Pengajuan" required></textarea>
                </div>

                <div class="col-12">
                    <hr class="my-4">
                </div>

                {{-- FOTO BUKTI --}}
                <div class="col-12 col-md-6 mx-auto text-center">
                    <label class="form-label fw-semibold">
                        Foto Bukti Pendukung
                    </label>
                    <input type="file" name="foto_bukti"
                           class="form-control" accept="image/*" required
                           onchange="previewImage(this, 'previewBukti')">
                    <img id="previewBukti"
                         class="img-fluid rounded shadow-sm mt-3 d-none"
                         style="max-height:220px;">
                </div>

                {{-- SUBMIT --}}
                <div class="col-12 mt-4">
                    <button type="submit"
                            class="btn btn-primary w-100 rounded-pill fw-semibold py-2">
                        Ajukan Bantuan
                    </button>
                </div>

            </form>
        @endif

    </div>
</div>

{{-- ================= JS PREVIEW ================= --}}
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
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