@extends('layouts.dashboard')

@section('sidebar-menu')
    @php
        $statusVerif = auth()->user()->latestRecipientVerification?->verification_status ?? 'pending';
    @endphp
    @include('partials.sidebar-penerima', ['active' => 'riwayat'])
@endsection

@section('content')
    @php
        $status = $request->status ?? 'pending';

        $badgeClass = match ($status) {
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            default => 'bg-warning text-dark',
        };

        $statusText = match ($status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Menunggu Review',
        };

        $statusIcon = match ($status) {
            'approved' => 'fa-circle-check',
            'rejected' => 'fa-circle-xmark',
            default => 'fa-clock',
        };

        $note = $request->review_notes ?? null;
        $photo = $request->file_path ?? null;
        $reviewedAt = $request->reviewed_at ?? null;

        $catIcon = match ($request->category) {
            'lansia' => 'fa-person-walking-with-cane',
            'ibu_balita' => 'fa-baby',
            'bencana' => 'fa-house-damage',
            'kehilangan_pekerjaan' => 'fa-briefcase',
            'yatim_piatu' => 'fa-user-group',
            'tunawisma' => 'fa-house-user',
            default => 'fa-hand-holding-heart',
        };
    @endphp

    <div class="container py-4">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
            <div>
                <a href="{{ route('penerima.riwayat') }}" class="text-decoration-none">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
                <h4 class="mt-2 mb-1">Detail Pengajuan</h4>
                <div class="text-muted small">
                    <i class="fa-regular fa-clock me-1"></i>
                    Diajukan: {{ optional($request->created_at)->format('d M Y, H:i') }}
                </div>
            </div>

            <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
                <i class="fa-solid {{ $statusIcon }} me-1"></i>
                {{ $statusText }}
            </span>
        </div>

        {{-- RINGKAS --}}
        <div class="card shadow-sm border-0 rounded-4 mb-3">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-start gap-3">

                    <span class="badge text-bg-light rounded-pill px-3 py-3 border">
                        <i class="fa-solid {{ $catIcon }} fs-5"></i>
                    </span>

                    <div class="flex-grow-1">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                            <div>
                                <div class="text-muted small">Kategori</div>
                                <div class="fw-semibold text-capitalize" style="font-size: 18px;">
                                    {{ $request->category ?? '-' }}
                                </div>
                                <div class="text-muted small mt-1">
                                    ID: <span class="fw-semibold text-dark">#{{ $request->id }}</span>
                                </div>
                            </div>

                            <div class="row g-2 mt-2">
                                <div class="col-12 col-md-6">
                                    <div class="border rounded-3 p-2 d-flex align-items-center gap-2 bg-light">
                                        <i class="fa-solid fa-users text-muted"></i>
                                        <div class="small text-muted">Tanggungan</div>
                                        <div class="ms-auto fw-semibold">{{ $request->dependents ?? 0 }}</div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="border rounded-3 p-2 d-flex align-items-center gap-2 bg-light">
                                        <i class="fa-solid fa-user text-muted"></i>
                                        <div class="small text-muted">Untuk</div>
                                        <div class="ms-auto fw-semibold text-capitalize">
                                            {{ $request->request_for === 'other' ? 'Orang lain' : 'Diri sendiri' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        @if (($request->request_for ?? 'self') === 'other')
                            <hr class="my-3">
                            <div class="text-muted small mb-1">
                                <i class="fa-solid fa-id-card me-1"></i> Data Penerima
                            </div>
                            <div class="fw-semibold">
                                {{ $request->recipient_name ?? '-' }}
                                @if (!empty($request->recipient_phone))
                                    <span class="text-muted">· {{ $request->recipient_phone }}</span>
                                @endif
                                @if (!empty($request->relationship))
                                    <span class="text-muted">({{ $request->relationship }})</span>
                                @endif
                            </div>
                        @endif

                        <hr class="my-3">

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="text-muted small">
                                    <i class="fa-solid fa-box-open me-1"></i> Kebutuhan Utama
                                </div>
                                <div class="fw-semibold">{{ $request->main_needs ?? '-' }}</div>
                            </div>

                            <div class="col-12">
                                <div class="text-muted small">
                                    <i class="fa-regular fa-note-sticky me-1"></i> Alasan Pengajuan
                                </div>
                                <div>{{ $request->reason ?? '-' }}</div>
                            </div>

                            @if (!empty($request->description))
                                <div class="col-12">
                                    <div class="text-muted small">
                                        <i class="fa-regular fa-file-lines me-1"></i> Deskripsi Tambahan
                                    </div>
                                    <div>{{ $request->description }}</div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- STATUS / TIMELINE --}}
        <div class="card shadow-sm border-0 rounded-4 mb-3">
            <div class="card-body p-3 p-md-4">
                <div class="fw-semibold mb-3">
                    <i class="fa-solid fa-route me-1"></i> Perkembangan Status
                </div>

                @php
                    $doneReview = (bool) $reviewedAt;
                    $doneDecision = in_array($status, ['approved', 'rejected']);

                    $decisionIcon =
                        $status === 'approved'
                            ? 'fa-circle-check'
                            : ($status === 'rejected'
                                ? 'fa-circle-xmark'
                                : 'fa-circle');
                    $decisionClass =
                        $status === 'approved'
                            ? 'text-success'
                            : ($status === 'rejected'
                                ? 'text-danger'
                                : 'text-muted');
                @endphp

                <div class="list-group list-group-flush">

                    {{-- STEP 1 --}}
                    <div class="list-group-item px-0 d-flex align-items-start gap-3">
                        <div class="pt-1">
                            <i class="fa-solid fa-circle-check text-success fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between gap-2">
                                <div class="fw-semibold">Pengajuan dikirim</div>
                                <div class="text-muted small">{{ optional($request->created_at)->format('d M Y, H:i') }}
                                </div>
                            </div>
                            <div class="text-muted">Data pengajuan kamu sudah masuk sistem.</div>
                        </div>
                    </div>

                    {{-- STEP 2 --}}
                    <div class="list-group-item px-0 d-flex align-items-start gap-3">
                        <div class="pt-1">
                            <i
                                class="fa-solid {{ $doneReview ? 'fa-circle-check text-success' : 'fa-hourglass-half text-muted' }} fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between gap-2">
                                <div class="fw-semibold">Sedang direview</div>
                                <div class="text-muted small">
                                    {{ $reviewedAt ? \Carbon\Carbon::parse($reviewedAt)->format('d M Y, H:i') : '—' }}
                                </div>
                            </div>
                            <div class="text-muted">
                                {{ $doneReview ? 'Pengajuan sudah diperiksa petugas.' : 'Menunggu petugas memeriksa pengajuan.' }}
                            </div>
                        </div>
                    </div>

                    {{-- STEP 3 --}}
                    <div class="list-group-item px-0 d-flex align-items-start gap-3">
                        <div class="pt-1">
                            <i class="fa-solid {{ $decisionIcon }} {{ $decisionClass }} fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between gap-2">
                                <div class="fw-semibold">Keputusan</div>
                                <div class="text-muted small">
                                    {{ $doneDecision ? optional($request->updated_at)->format('d M Y, H:i') : '—' }}
                                </div>
                            </div>
                            <div class="text-muted">
                                @if ($status === 'approved')
                                    Pengajuan kamu disetujui. Silakan tunggu info penyaluran.
                                @elseif ($status === 'rejected')
                                    Pengajuan ditolak. Cek catatan petugas di bawah.
                                @else
                                    Belum ada keputusan.
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        {{-- ALAMAT --}}
        <div class="card shadow-sm border-0 rounded-4 mb-3">
            <div class="card-body p-3 p-md-4">
                <div class="fw-semibold mb-2">
                    <i class="fa-solid fa-location-dot me-1"></i> Alamat
                </div>
                <div>{{ $request->address_detail ?? '-' }}</div>
            </div>
        </div>

        {{-- CATATAN --}}
        <div class="card shadow-sm border-0 rounded-4 mb-3">
            <div class="card-body p-3 p-md-4">
                <div class="fw-semibold mb-2">
                    <i class="fa-solid fa-message me-1"></i> Catatan Petugas
                </div>

                @if ($note)
                    <div>{{ $note }}</div>
                @else
                    <div class="text-muted">Belum ada catatan.</div>
                @endif
            </div>
        </div>

        {{-- FOTO --}}
        <div class="card shadow-sm border-0 rounded-4 mb-3">
            <div class="card-body p-3 p-md-4">
                <div class="fw-semibold mb-2">
                    <i class="fa-regular fa-image me-1"></i> Foto / Bukti Pendukung
                </div>

                @if (!empty($photo))
                    <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="text-decoration-none d-block">
                        <div class="border rounded-4 overflow-hidden">
                            <img src="{{ asset('storage/' . $photo) }}" alt="Foto Pengajuan"
                                class="img-fluid w-100 d-block">
                        </div>
                    </a>

                    <div class="text-muted small mt-2">
                        Tekan foto untuk buka ukuran penuh.
                    </div>
                @else
                    <div class="text-muted">Tidak ada foto yang diunggah.</div>
                @endif
            </div>
        </div>


    </div>
@endsection
