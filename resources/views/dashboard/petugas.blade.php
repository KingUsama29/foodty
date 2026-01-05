@extends('layouts.dashboard')

{{-- ================= SIDEBAR MENU PETUGAS ================= --}}
@section('sidebar-menu')
    @include('partials.sidebar-petugas', ['active' => 'dashboard'])
@endsection

{{-- ================= KONTEN DASHBOARD PETUGAS ================= --}}
@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fa-solid fa-house fa-lg text-primary me-3"></i>
            <div>
                <h5 class="mb-1">Dashboard Petugas</h5>
                <small class="text-muted">Kelola dan verifikasi pengajuan bantuan dari masyarakat</small>
            </div>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small">Pengajuan Pending</div>
                        <div class="fs-3 fw-bold">{{ $pendingFoodRequest ?? 0 }}</div>
                    </div>
                    <i class="fa-solid fa-hourglass-half fs-3 text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small">Pengajuan Approved</div>
                        <div class="fs-3 fw-bold">{{ $approvedFoodRequest ?? 0 }}</div>
                    </div>
                    <i class="fa-solid fa-circle-check fs-3 text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small">Penyaluran Selesai</div>
                        <div class="fs-3 fw-bold">{{ $completedDistributions ?? 0 }}</div>
                    </div>
                    <i class="fa-solid fa-truck-ramp-box fs-3 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Menu Cards (punya lu, gw pertahanin) --}}
    <div class="row g-3 mb-4">
        {{-- DAFTAR TUGAS --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-list-check fa-2x text-primary mb-3"></i>
                    <h6>Daftar Tugas</h6>
                    <p class="small text-muted mb-0">
                        Daftar tugas penyaluran dan verifikasi bantuan yang harus dikerjakan.
                    </p>
                </div>
            </div>
        </div>

        {{-- RIWAYAT TUGAS --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-clock-rotate-left fa-2x text-primary mb-3"></i>
                    <h6>Riwayat Tugas</h6>
                    <p class="small text-muted mb-0">
                        Riwayat tugas yang telah diselesaikan oleh petugas.
                    </p>
                </div>
            </div>
        </div>

        {{-- PROFIL PETUGAS --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-id-badge fa-2x text-primary mb-3"></i>
                    <h6>Profil Petugas</h6>
                    <p class="small text-muted mb-0">
                        Informasi data petugas seperti cabang, nomor telepon, dan detail lainnya.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="fw-semibold mb-2">Status Pengajuan</div>
                    <canvas id="chartFoodReq"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="fw-semibold mb-2">Status Donasi</div>
                    <canvas id="chartDonation"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="fw-semibold mb-2">Penyaluran 7 Hari Terakhir</div>
                    <canvas id="chartDistribution7"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Pengajuan Siap Disalurkan (Prioritas) --}}
    <div class="card shadow-sm">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h6 class="mb-1">Pengajuan Siap Disalurkan (Prioritas)</h6>
                <small class="text-muted">Pengajuan approved yang belum punya penyaluran aktif/selesai.</small>
            </div>
            {{-- ganti route ini sesuai route lu --}}
            <a href="{{ route('petugas.data-penyaluran') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-truck me-1"></i> Lihat Semua
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Pemohon</th>
                        <th>Kategori</th>
                        <th>Tanggungan</th>
                        <th>Needs</th>
                        <th>Diajukan</th>
                        <th class="text-end" style="width:180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse (($readyRequests ?? []) as $i => $r)
                        <tr>
                            <td class="text-muted">{{ $i + 1 }}</td>
                            <td>
                                <div class="fw-semibold">{{ $r->user_name ?? '-' }}</div>
                                <div class="small text-muted">
                                    {{ $r->request_for === 'other' ? 'Untuk orang lain' : 'Untuk diri sendiri' }}
                                </div>
                            </td>
                            <td><span class="badge bg-info text-dark">{{ $r->category }}</span></td>
                            <td>{{ $r->dependents ?? '-' }}</td>
                            <td class="small text-muted">{{ \Illuminate\Support\Str::limit($r->main_needs, 40) }}</td>
                            <td class="small">
                                {{ $r->created_at ? \Carbon\Carbon::parse($r->created_at)->format('d M Y') : '-' }}
                            </td>


                            <td class="text-end">
                                {{-- ganti route detail pengajuan sesuai punya lu --}}
                                <a href="{{ route('petugas.pengajuan.detail', $r->id) }}"
                                    class="btn btn-outline-secondary btn-sm rounded-pill">
                                    Detail
                                </a>

                                {{-- ganti route create penyaluran sesuai punya lu --}}
                                <a href="{{ route('petugas.penyaluran-create', ['food_request_id' => $r->id]) }}"
                                    class="btn btn-primary btn-sm rounded-pill">
                                    Salurkan
                                </a>


                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Belum ada pengajuan yang siap disalurkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const foodReq = @json($foodReqStatus ?? []);
        const donation = @json($donationStatus ?? []);

        // Doughnut: Food Request status
        new Chart(document.getElementById('chartFoodReq'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(foodReq),
                datasets: [{
                    data: Object.values(foodReq)
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Bar: Donation status
        new Chart(document.getElementById('chartDonation'), {
            type: 'bar',
            data: {
                labels: Object.keys(donation),
                datasets: [{
                    label: 'Jumlah',
                    data: Object.values(donation),
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Line: Distribution 7 hari
        new Chart(document.getElementById('chartDistribution7'), {
            type: 'line',
            data: {
                labels: @json($labels7 ?? []),
                datasets: [{
                        label: 'Completed',
                        data: @json($completed7 ?? [])
                    },
                    {
                        label: 'Scheduled',
                        data: @json($scheduled7 ?? [])
                    },
                    {
                        label: 'Canceled',
                        data: @json($canceled7 ?? [])
                    },
                ]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
@endpush
