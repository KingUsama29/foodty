@extends('layouts.dashboard')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i> Dashboard
    </a>

    <a href="{{ route('admin.pengajuan') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-file-circle-check fa-fw me-3"></i> Ajuan Bantuan
    </a>

    <a href="{{ route('admin.petugas') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-users-gear fa-fw me-3"></i> Data Petugas
    </a>

    <a href="{{ route('admin.cabang') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-location-dot fa-fw me-3"></i> Cabang Lokasi
    </a>

    <a href="{{ route('admin.stok-barang') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-boxes-stacked fa-fw me-3"></i> Stok Barang
    </a>

    <a href="{{ route('admin.penyaluran') }}" class="list-group-item list-group-item-action d-flex align-items-center">
        <i class="fa-solid fa-chart-pie fa-fw me-3"></i> Hasil Penyaluran
    </a>
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fa-solid fa-house fa-lg text-primary me-3"></i>
            <div>
                <h5 class="mb-1">Dashboard Admin</h5>
                <small class="text-muted">Ringkasan pengelolaan bantuan pangan FoodTY</small>
            </div>
        </div>
    </div>

    {{-- KPI --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Pengajuan Pending</div>
                        <div class="fs-3 fw-bold">{{ $totalPending ?? 0 }}</div>
                    </div>
                    <i class="fa-solid fa-hourglass-half fs-3 text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Pengajuan Approved</div>
                        <div class="fs-3 fw-bold">{{ $totalApproved ?? 0 }}</div>
                    </div>
                    <i class="fa-solid fa-circle-check fs-3 text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Pengajuan Ditolak</div>
                        <div class="fs-3 fw-bold">{{ $totalRejected ?? 0 }}</div>
                    </div>
                    <i class="fa-solid fa-circle-xmark fs-3 text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Hampir Expired (Item)</div>
                        <div class="fs-3 fw-bold">{{ $totalExpiringItems ?? 0 }}</div>
                    </div>
                    <i class="fa-solid fa-triangle-exclamation fs-3 text-primary"></i>
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
                    <canvas id="chartFoodReqAdmin" height="220"></canvas>
                    <div id="emptyFoodReq" class="small text-muted mt-2 d-none">Belum ada data.</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="fw-semibold mb-2">Penyaluran 7 Hari Terakhir</div>
                    <canvas id="chartDistribution7Admin" height="220"></canvas>
                    <div id="emptyDist7" class="small text-muted mt-2 d-none">Belum ada data.</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="fw-semibold mb-2">Hampir Expired per Cabang</div>
                    <canvas id="chartExpiringBranch" height="220"></canvas>
                    <div id="emptyExp" class="small text-muted mt-2 d-none">Belum ada data hampir expired.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick cards --}}
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-file-circle-check fa-2x text-primary mb-3"></i>
                    <h6>Ajuan Bantuan</h6>
                    <p class="small text-muted">Kelola pengajuan bantuan dari penerima.</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-users-gear fa-2x text-primary mb-3"></i>
                    <h6>Data Petugas</h6>
                    <p class="small text-muted">Kelola data petugas penyaluran.</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa-solid fa-location-dot fa-2x text-primary mb-3"></i>
                    <h6>Cabang Lokasi</h6>
                    <p class="small text-muted">Kelola lokasi cabang bantuan.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ===== data dari backend =====
        const foodReq = @json($foodReqStatus ?? (object) []);
        const labels7 = @json($labels7 ?? []);
        const completed7 = @json($completed7 ?? []);
        const scheduled7 = @json($scheduled7 ?? []);
        const canceled7 = @json($canceled7 ?? []);

        const expLabels = @json($expBranchLabels ?? []);
        const expValues = @json($expBranchValues ?? []);

        // helper empty state
        const isAllZero = (arr) => Array.isArray(arr) && arr.every(v => Number(v) === 0);

        // ===== Doughnut: Status Pengajuan =====
        const foodReqKeys = Object.keys(foodReq);
        const foodReqVals = Object.values(foodReq);

        if (foodReqKeys.length === 0) {
            document.getElementById('emptyFoodReq').classList.remove('d-none');
        } else {
            new Chart(document.getElementById('chartFoodReqAdmin'), {
                type: 'doughnut',
                data: {
                    labels: foodReqKeys,
                    datasets: [{
                        data: foodReqVals
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
        }

        // ===== Line: Penyaluran 7 Hari =====
        if (labels7.length === 0 || (isAllZero(completed7) && isAllZero(scheduled7) && isAllZero(canceled7))) {
            document.getElementById('emptyDist7').classList.remove('d-none');
        } else {
            new Chart(document.getElementById('chartDistribution7Admin'), {
                type: 'line',
                data: {
                    labels: labels7,
                    datasets: [{
                            label: 'Completed',
                            data: completed7
                        },
                        {
                            label: 'Scheduled',
                            data: scheduled7
                        },
                        {
                            label: 'Canceled',
                            data: canceled7
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
        }

        // ===== Bar: Hampir Expired per Cabang =====
        if (expLabels.length === 0 || isAllZero(expValues)) {
            document.getElementById('emptyExp').classList.remove('d-none');
        } else {
            new Chart(document.getElementById('chartExpiringBranch'), {
                type: 'bar',
                data: {
                    labels: expLabels,
                    datasets: [{
                        label: 'Item hampir expired',
                        data: expValues
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
                            },
                            suggestedMax: Math.max(...expValues) + 1
                        }
                    }
                }
            });
        }
    </script>
@endpush
