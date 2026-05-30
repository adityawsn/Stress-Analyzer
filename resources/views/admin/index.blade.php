@extends('admin.layouts.app')

@section('title', 'StressAnalyzer - Dashboard')

@section('content')
    <!-- Main Content -->
    <div id="main-content">
        <header class="top-nav">
            <button class="btn d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="fw-medium text-muted d-none d-md-block">
                <i class="bi bi-house-door-fill me-2"></i> Selamat Datang, Admin StressAnalyzer!
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <p class="mb-0 fw-semibold" style="font-size: 14px;">Admin</p>
                    <small class="text-muted" style="font-size: 12px;">Sistem StressAnalyzer</small>
                </div>
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Aditya" alt="Avatar"
                    class="rounded-circle border" width="40" height="40">
            </div>
        </header>

        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Status Dashboard Penelitian</h4>
                    <p class="text-muted small mb-0">
                        Ringkasan data {{ $total ?? 0 }} responden penelitian tingkat stres skripsi.
                    </p>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="row g-4 mb-4"></div>
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card p-3 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Total Sampel
                                    (N)</small>
                                <h3 class="mb-0 fw-bold mt-1">{{ $total ?? 0 }}</h3>
                            </div>
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                        <div class="mt-3 small text-success fw-bold">
                            Mahasiswa
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-3 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Rerata X1
                                    (Tekanan Pennyusunan)</small>
                                <h3 class="mb-0 fw-bold mt-1 text-danger">{{ $mean_tps ?? 0 }}</h3>
                            </div>
                            <div class="icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-journal-x"></i>
                            </div>
                        </div>
                        <div class="mt-3 small text-muted">Kategori: <span
                                class="fw-bold text-danger">{{ $kategori_ts }}</span></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-3 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Rerata X2
                                    (Manajemen Waktu)</small>
                                <h3 class="mb-0 fw-bold mt-1 text-warning">{{ $mean_mw ?? 0 }}</h3>
                            </div>
                            <div class="icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-alarm"></i>
                            </div>
                        </div>
                        <div class="mt-3 small text-muted">Kategori: <span
                                class="fw-bold text-warning">{{ $kategori_mm }}</span></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-3 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Perbedaan Rerata
                                    (|X1 - X2|)</small>
                                <h3 class="mb-0 fw-bold mt-1 text-success">{{ $mean_diff ?? 0 }}</h3>
                            </div>
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="bi bi-patch-check"></i>
                            </div>
                        </div>
                        <div class="mt-3 small text-success fw-bold">Selisih X1 - X2</div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Main Chart -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 h-100 rounded-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold mb-0">Komparatif Hasil: Tsukamoto vs Mamdani</h6>
                            <small class="text-muted">Berdasarkan data kuesioner</small>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="comparisonChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Distribution -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-2">Distribusi Kategori (Fuzzy)</h6>
                            <select id="methodSelect" class="form-select form-select-sm w-auto">
                                <option value="ts">Tsukamoto</option>
                                <option value="mm">Mamdani</option>
                            </select>
                        </div>
                        <div style="height: 250px;">
                            <canvas id="donutChart"></canvas>
                        </div>
                        <div class="mt-4 small" id="donutLegend">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Data from server
        const labels = @json($labels ?? []);
        const tsukamotoData = @json($tsukamoto_vals ?? []);
        const mamdaniData = @json($mamdani_vals ?? []);
        const donutTs = @json($donut_ts ?? [0, 0, 0]);
        const donutMm = @json($donut_mm ?? [0, 0, 0]);

        // Comparison Chart
        new Chart(document.getElementById('comparisonChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Tsukamoto',
                        data: tsukamotoData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'transparent',
                        tension: 0.3,
                        borderWidth: 3
                    },
                    {
                        label: 'Mamdani',
                        data: mamdaniData,
                        borderColor: '#f59e0b',
                        backgroundColor: 'transparent',
                        borderDash: [5, 5],
                        tension: 0.3,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Distribution (donut) Chart with method toggle
        const donutCtx = document.getElementById('donutChart');
        const donutChart = new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Rendah', 'Sedang', 'Tinggi'],
                datasets: [{
                    data: donutTs,
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '75%'
            }
        });

        function renderDonutLegend(counts) {
            const total = counts.reduce((a, b) => a + b, 0) || 1;
            const labels = ['Rendah', 'Sedang', 'Tinggi'];
            const colors = ['#10b981', '#f59e0b', '#ef4444'];
            const container = document.getElementById('donutLegend');
            container.innerHTML = '';
            labels.forEach((lab, i) => {
                const pct = Math.round((counts[i] / total) * 100);
                const div = document.createElement('div');
                div.className = 'd-flex justify-content-between mb-2';
                div.innerHTML =
                    `<span><i class="bi bi-circle-fill me-2" style="color:${colors[i]}"></i> ${lab}</span><span class="fw-bold">${pct}%</span>`;
                container.appendChild(div);
            });
        }

        // initial legend
        renderDonutLegend(donutTs);

        document.getElementById('methodSelect').addEventListener('change', function(e) {
            const v = e.target.value;
            const counts = v === 'mm' ? donutMm : donutTs;
            donutChart.data.datasets[0].data = counts;
            donutChart.update();
            renderDonutLegend(counts);
        });
    </script>
@endsection
