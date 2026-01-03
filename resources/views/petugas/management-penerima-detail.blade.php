@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'penerima'])
@endsection

@section('content')
    @php
        $status = $verification->verification_status ?? 'pending';

        $badge = match ($status) {
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'warning',
        };

        $label = match ($status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Pending',
        };

        $icon = match ($status) {
            'approved' => 'fa-circle-check',
            'rejected' => 'fa-circle-xmark',
            default => 'fa-clock',
        };
    @endphp

    {{-- HEADER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-id-card-clip fa-lg text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Detail Verifikasi Penerima</h5>
                    <small class="text-muted">Periksa data & dokumen, lalu approve / reject</small>
                </div>
            </div>

            <a href="{{ route('petugas.data-penerima') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm">
            <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ session('error') }}
        </div>
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

    {{-- STATUS BAR --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-muted">
            ID: <span class="fw-semibold">#{{ $verification->id }}</span>
            · Diajukan: <span class="fw-semibold">{{ $verification->created_at?->format('d M Y, H:i') }}</span>
        </div>

        <span class="badge bg-{{ $badge }} rounded-pill px-3 py-2">
            <i class="fa-solid {{ $icon }} me-1"></i> {{ $label }}
        </span>
    </div>

    <div class="row g-3">
        {{-- DATA AKUN --}}
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-semibold mb-0">
                            <i class="fa-solid fa-user me-1 text-muted"></i> Data Akun (Users)
                        </h6>
                        @if ($verification->verified_at)
                            <small class="text-muted">
                                <i class="fa-regular fa-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($verification->verified_at)->format('d M Y, H:i') }}
                            </small>
                        @endif
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Nama</span>
                            <span class="fw-semibold">{{ $verification->user->name ?? '-' }}</span>
                        </div>
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">NIK</span>
                            <span class="fw-semibold">{{ $verification->user->nik ?? '-' }}</span>
                        </div>
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Email</span>
                            <span class="fw-semibold">{{ $verification->user->email ?? '-' }}</span>
                        </div>
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">No. Telp</span>
                            <span class="fw-semibold">{{ $verification->user->no_telp ?? '-' }}</span>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="text-muted mb-1">Alamat</div>
                            <div class="fw-semibold">{{ $verification->user->alamat ?? '-' }}</div>
                        </div>
                    </div>

                    @if ($verification->verification_status === 'rejected' && $verification->rejected_reason)
                        <div class="alert alert-danger mt-3 mb-0">
                            <div class="fw-semibold mb-1">
                                <i class="fa-solid fa-circle-xmark me-1"></i> Alasan ditolak
                            </div>
                            <div>{{ $verification->rejected_reason }}</div>
                        </div>
                    @endif

                    @if ($verification->verification_status === 'pending')
                        <div class="mt-3 d-flex gap-2">
                            <button class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                data-bs-target="#accModal">
                                <i class="fa-solid fa-check me-1"></i> Approve
                            </button>

                            <button class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                data-bs-target="#rejectModal">
                                <i class="fa-solid fa-xmark me-1"></i> Reject
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- DATA VERIF + DOKUMEN --}}
        <div class="col-lg-6">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">
                        <i class="fa-solid fa-clipboard-check me-1 text-muted"></i> Data Verifikasi
                    </h6>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Nama Lengkap</span>
                            <span class="fw-semibold">{{ $verification->full_name ?? '-' }}</span>
                        </div>
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">No KK</span>
                            <span class="fw-semibold">{{ $verification->kk_number ?? '-' }}</span>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="text-muted mb-1">Alamat</div>
                            <div class="fw-semibold">{{ $verification->alamat ?? '-' }}</div>
                        </div>
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Provinsi</span>
                            <span class="fw-semibold">{{ $verification->province ?? '-' }}</span>
                        </div>
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Kota/Kab</span>
                            <span class="fw-semibold">{{ $verification->city ?? '-' }}</span>
                        </div>
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Kecamatan</span>
                            <span class="fw-semibold">{{ $verification->district ?? '-' }}</span>
                        </div>
                        <div class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Kode Pos</span>
                            <span class="fw-semibold">{{ $verification->postal_code ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">
                        <i class="fa-regular fa-folder-open me-1 text-muted"></i> Dokumen
                    </h6>

                    @if ($verification->documents->count())
                        <div class="list-group">
                            @foreach ($verification->documents as $doc)
                                <div class="list-group-item d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="fw-semibold text-capitalize">
                                            <i class="fa-regular fa-file-lines me-1 text-muted"></i>
                                            {{ $doc->type }}
                                        </div>
                                        <small class="text-muted">{{ $doc->original_name }}</small>
                                    </div>

                                    <a class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                        href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                        <i class="fa-solid fa-up-right-from-square me-1"></i> Lihat
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted">Belum ada dokumen yang diupload.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL APPROVE --}}
    <div class="modal fade" id="accModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-body text-center p-4">
                    <i class="fa-solid fa-circle-check fa-2xl text-success mb-3"></i>
                    <p class="fw-semibold mb-4">Apakah Anda yakin akan menyetujui verifikasi penerima ini?</p>

                    {{-- ROUTE ASLI PUNYAMU (GAK DIUBAH) --}}
                    <form method="POST" action="{{ route('penerima.approve', $verification->id) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success rounded-pill px-4">
                            <i class="fa-solid fa-check me-1"></i> Ya
                        </button>
                    </form>

                    <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tidak</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL REJECT --}}
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="fa-solid fa-circle-xmark fa-2xl text-danger mb-3"></i>
                    </div>

                    <p class="fw-semibold mb-3 text-center">Apakah Anda yakin akan menolak verifikasi penerima ini?</p>

                    {{-- ROUTE ASLI PUNYAMU (GAK DIUBAH) --}}
                    <form method="POST" action="{{ route('penerima.reject', $verification->id) }}">
                        @csrf
                        @method('PATCH')

                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="rejected_reason" class="form-control" rows="3"
                            placeholder="Contoh: Foto KTP tidak jelas / Data tidak sesuai" required>{{ old('rejected_reason') }}</textarea>

                        <div class="mt-3 text-center d-flex justify-content-center gap-2">
                            <button class="btn btn-danger rounded-pill px-4">
                                <i class="fa-solid fa-xmark me-1"></i> Ya, Tolak
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
@endsection
