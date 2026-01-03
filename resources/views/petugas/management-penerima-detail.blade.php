@extends('layouts.dashboard')

@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'penerima'])
@endsection

@section('content')

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
                Kembali
            </a>
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
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Data Akun (Users)</h6>

                    <div class="mb-2"><span class="text-muted">Nama:</span> <span
                            class="fw-semibold">{{ $verification->user->name }}</span></div>
                    <div class="mb-2"><span class="text-muted">NIK:</span> {{ $verification->user->nik }}</div>
                    <div class="mb-2"><span class="text-muted">Email:</span> {{ $verification->user->email }}</div>
                    <div class="mb-2"><span class="text-muted">No. Telp:</span> {{ $verification->user->no_telp ?? '-' }}
                    </div>
                    <div class="mb-2"><span class="text-muted">Alamat:</span> {{ $verification->user->alamat ?? '-' }}
                    </div>

                    <hr>

                    <h6 class="fw-semibold mb-3">Status Verifikasi</h6>

                    @php
                        $status = $verification->verification_status;
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
                    @endphp

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-{{ $badge }} rounded-pill px-3 py-2">{{ $label }}</span>
                        <small class="text-muted">
                            @if ($verification->verified_at)
                                Diverifikasi: {{ $verification->verified_at }}
                            @endif
                        </small>
                    </div>

                    @if ($verification->verification_status === 'rejected' && $verification->rejected_reason)
                        <div class="mt-3">
                            <div class="fw-semibold text-danger">Alasan ditolak:</div>
                            <div class="text-muted">{{ $verification->rejected_reason }}</div>
                        </div>
                    @endif

                    <div class="mt-4 d-flex gap-2">
                        @if ($verification->verification_status === 'pending')
                            <button class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                data-bs-target="#accModal">
                                Approve
                            </button>

                            <button class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                data-bs-target="#rejectModal">
                                Reject
                            </button>
                        @endif
                    </div>


                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Data Verifikasi (recipient_verifications)</h6>

                    <div class="mb-2"><span class="text-muted">Nama Lengkap:</span> <span
                            class="fw-semibold">{{ $verification->full_name }}</span></div>
                    <div class="mb-2"><span class="text-muted">No KK:</span> {{ $verification->kk_number }}</div>
                    <div class="mb-2"><span class="text-muted">Alamat:</span> {{ $verification->alamat }}</div>
                    <div class="mb-2"><span class="text-muted">Provinsi:</span> {{ $verification->province }}</div>
                    <div class="mb-2"><span class="text-muted">Kota/Kab:</span> {{ $verification->city }}</div>
                    <div class="mb-2"><span class="text-muted">Kecamatan:</span> {{ $verification->district }}</div>
                    <div class="mb-2"><span class="text-muted">Kode Pos:</span> {{ $verification->postal_code }}</div>

                    <hr>

                    <h6 class="fw-semibold mb-3">Dokumen (recipient_verification_documents)</h6>

                    @if ($verification->documents->count())
                        <div class="list-group">
                            @foreach ($verification->documents as $doc)
                                <div class="list-group-item d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="fw-semibold text-capitalize">{{ $doc->type }}</div>
                                        <small class="text-muted">{{ $doc->original_name }}</small>
                                    </div>

                                    <a class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                        href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                        Lihat
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
                    <p class="fw-semibold mb-4">
                        Apakah anda yakin akan menyetujui verifikasi penerima ini?
                    </p>

                    <form method="POST" action="{{ route('penerima.approve', $verification->id) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success rounded-pill px-4">Ya</button>
                    </form>

                    <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        Tidak
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL REJECT --}}
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-body p-4">
                    <p class="fw-semibold mb-3 text-center">
                        Apakah anda yakin akan menolak verifikasi penerima ini?
                    </p>

                    <form method="POST" action="{{ route('penerima.reject', $verification->id) }}">
                        @csrf
                        @method('PATCH')

                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="rejected_reason" class="form-control" rows="3"
                            placeholder="Contoh: Foto KTP tidak jelas / Data tidak sesuai" required>{{ old('rejected_reason') }}</textarea>

                        <div class="mt-3 text-center">
                            <button class="btn btn-danger rounded-pill px-4">Ya, Tolak</button>
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
