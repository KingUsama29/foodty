@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
<main class="py-5">

    <!-- FULL WIDTH CONTAINER (SEPERTI LANDING PAGE) -->
    <div class="container-fluid px-5">

        <!-- WELCOME SECTION -->
        <div class="rounded-4 p-4 mb-5" style="background:#7fc4da;">
            <div class="d-flex align-items-center gap-4">
                <div class="rounded-circle d-flex justify-content-center align-items-center"
                     style="width:90px;height:90px;background:#ffd38a;font-size:36px;">
                    👤
                </div>
                <div>
                    <h3 class="fw-semibold mb-1">Selamat Datang [user]</h3>
                    <span class="text-dark">Admin</span>
                </div>
            </div>
        </div>

        <!-- DASHBOARD GRID -->
        <div class="row g-4">

            <!-- CHART -->
            <div class="col-lg-8">
                <div class="rounded-4 p-4 h-100" style="background:#d7ebe2;">
                    <h6 class="fw-semibold mb-3">Distribusi Penerima Bantuan</h6>

                    <div class="bg-white rounded-4 p-3">
                        <div class="position-relative" style="height:340px;">
                            <canvas id="penerimaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KETERANGAN -->
            <div class="col-lg-4">
                <div class="rounded-4 p-4 h-100 d-flex flex-column justify-content-center"
                     style="background:#d7ebe2;">
                    <h6 class="fw-semibold mb-2">Keterangan</h6>
                    <p class="text-muted mb-0">
                        Grafik menunjukkan distribusi kategori penerima bantuan
                        berdasarkan data sementara. Nilai akan diperbarui
                        setelah integrasi sistem backend.
                    </p>
                </div>
            </div>

        </div>

    </div>
</main>

<!-- CHART SCRIPT -->
<script>
new Chart(document.getElementById('penerimaChart'), {
    type: 'doughnut',
    data: {
        labels: [
            'Lansia',
            'Ibu Bayi',
            'Bencana Alam',
            'Kehilangan Pekerjaan',
            'Yatim Piatu',
            'Tuna Wisma'
        ],
        datasets: [{
            data: [40, 25, 15, 10, 6, 4],
            backgroundColor: [
                '#0d6efd',
                '#ff8ab3',
                '#dc3545',
                '#ffc107',
                '#feca57',
                '#198754'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 14,
                    padding: 18
                }
            }
        }
    }
});
</script>
@endsection
