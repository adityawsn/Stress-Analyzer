@extends('admin.layouts.app')
@section('title', 'StressAnalyzer - Analisis Statistik')
@section('content')

    <style>
        /* Sidebar Styling */

        #main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }


        .top-nav {
            background: white;
            padding: 12px 30px;
            margin: -20px -20px 20px -20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .data-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
        }

        .progress-custom {
            height: 8px;
            border-radius: 10px;
        }

        .badge-fuzzy {
            font-size: 10px;
            padding: 5px 10px;
            border-radius: 50px;
        }

        @media (max-width: 991.98px) {
            #sidebar {
                left: -260px;
            }

            #sidebar.active {
                left: 0;
            }

            #main-content {
                margin-left: 0;
            }
        }
    </style>

    <!-- Main Content -->
    <div id="main-content">
        <header class="top-nav">
            <button class="btn d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="fw-medium text-muted d-none d-md-block">
                <i class="bi bi-graph-up me-2"></i> Analisis Statistik Metode Fuzzy
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

        <div class="container-fluid py-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Analisis Statistik Tingkat Stres Mahasiswa</h4>
                    <p class="text-muted small mb-0">
                        Perbandingan Metode Fuzzy Tsukamoto dan Mamdani.
                    </p>
                </div>
            </div>

            <!-- Stats Row: Focused on Variable Indicators -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Rerata Tekanan Penyusunan Skripsi
                                (X1)</small>
                            <i class="bi bi-exclamation-circle text-danger"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($mean_tps, 2) }}</h3>
                        <p class="small text-muted mb-0">Nilai rata-rata tekanan skripsi</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Rerata Manajemen Waktu
                                (X2)</small>
                            <i class="bi bi-clock text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($mean_mw, 2) }}</h3>
                        <p class="small text-muted mb-0">Nilai rata-rata manajemen waktu</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Rerata
                                Tsukamoto</small>
                            <i class="bi bi-bar-chart-line text-success"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($mean_tsukamoto, 2) }}%</h3>
                        <p class="small text-muted mb-0">Rata-rata output inferensi</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Rerata Mamdani</small>
                            <i class="bi bi-bar-chart-line text-info"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($mean_mamdani, 2) }}%</h3>
                        <p class="small text-muted mb-0">Rata-rata output inferensi</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Standar Deviasi
                                (X1)</small>
                            <i class="bi bi-percent text-warning"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($std_tps, 2) }}</h3>
                        <p class="small text-muted mb-0">Variasi tekanan skripsi</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Standar Deviasi
                                (X2)</small>
                            <i class="bi bi-percent text-warning"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($std_mw, 2) }}</h3>
                        <p class="small text-muted mb-0">Variasi manajemen waktu</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Standar Deviasi
                                Tsukamoto</small>
                            <i class="bi bi-percent text-warning"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($std_tsukamoto, 2) }}</h3>
                        <p class="small text-muted mb-0">Variasi output Tsukamoto</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Standar Deviasi
                                Mamdani</small>
                            <i class="bi bi-percent text-warning"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($std_mamdani, 2) }}</h3>
                        <p class="small text-muted mb-0">Variasi output Mamdani</p>
                    </div>
                </div>
            </div>

            <!-- Demographics Row (Gender / Age / Jenjang) -->
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="card data-card border-0 shadow-sm h-100">
                        <h6 class="fw-bold mb-3">Distribusi Jenis Kelamin</h6>
                        <div style="height:220px;">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card data-card border-0 shadow-sm h-100">
                        <h6 class="fw-bold mb-3">Distribusi Usia</h6>
                        <div style="height:220px;">
                            <canvas id="ageChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card data-card border-0 shadow-sm h-100">
                        <h6 class="fw-bold mb-3">Distribusi Jenjang</h6>
                        <div style="height:220px;">
                            <canvas id="jenjangChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-2">
                <div class="col-lg-3">
                    <div class="card data-card border-0 shadow-sm h-100">
                        <h6 class="fw-bold mb-3">Distribusi Status Penyusunan</h6>
                        <div style="height:220px;">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card data-card border-0 shadow-sm h-100">
                        <h6 class="fw-bold mb-3">Distribusi Tahun Penyusunan</h6>
                        <div style="height:220px;">
                            <canvas id="yearChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card data-card border-0 shadow-sm h-100">
                        <h6 class="fw-bold mb-4">Top Stresor (Indikator X1 & X2)</h6>
                        @php $colors = ['bg-danger','bg-warning','bg-info','bg-success']; @endphp
                        <div class="space-y-4">
                            @foreach ($top_stressors as $stressor)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>{{ $stressor['label'] }}</small>
                                        <small class="fw-bold">{{ $stressor['percentage'] }}%</small>
                                    </div>
                                    <div class="progress progress-custom">
                                        <div class="progress-bar {{ $colors[$loop->index] ?? 'bg-secondary' }}"
                                            style="width: {{ $stressor['percentage'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- <div class="mt-4 p-3 bg-light rounded-3">
                            <small class="text-muted d-block fw-bold"><i class="bi bi-info-circle-fill"></i> Sesuai Tabel
                                3.1 Proposal:</small>
                            <small class="text-muted">Variabel X1 menunjukkan pengaruh lebih besar terhadap Stres Tinggi
                                dibandingkan X2 pada sampel saat ini.</small>
                        </div> --}}
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

        const genderCtx = document.getElementById('genderChart')?.getContext('2d');
        if (genderCtx) {
            new Chart(genderCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($gender_labels),
                    datasets: [{
                        data: @json($gender_values),
                        backgroundColor: ['#60a5fa', '#f472b6'],
                        hoverOffset: 8
                    }]
                },
                options: {
                    cutout: '55%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const v = context.raw || 0;
                                    const data = context.dataset.data || [];
                                    const sum = data.reduce((a, b) => a + (b || 0), 0);
                                    const pct = sum ? (v / sum * 100).toFixed(1) : 0;
                                    return context.label + ': ' + v + ' (' + pct + '%)';
                                }
                            }
                        }
                    },
                    elements: {
                        arc: {
                            borderColor: '#fff',
                            borderWidth: 2
                        }
                    },
                    maintainAspectRatio: false,
                    responsive: true
                }
            });
        }


        const ageCtx = document.getElementById('ageChart')?.getContext('2d');
        if (ageCtx) {
            new Chart(ageCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($age_labels),
                    datasets: [{
                        data: @json($age_values),
                        backgroundColor: [
                            '#93C5FD',
                            '#A5B4FC',
                            '#C4B5FD',
                            '#F9A8D4',
                            '#FBCFE8',
                            '#FDE68A',
                            '#86EFAC',
                            '#99F6E4',
                            '#A7F3D0'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 8
                    }]
                },
                options: {
                    cutout: '55%',
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw || 0;
                                    const data = context.dataset.data || [];
                                    const total = data.reduce((a, b) => a + b, 0);
                                    const percentage = total ?
                                        ((value / total) * 100).toFixed(1) :
                                        0;

                                    return `${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        const jenjangCtx = document.getElementById('jenjangChart')?.getContext('2d');
        if (jenjangCtx) {
            new Chart(jenjangCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($jenjang_labels),
                    datasets: [{
                        data: @json($jenjang_values),
                        backgroundColor: [
                            '#8b5cf6', // D3
                            '#34d399' // D4/S1
                        ],
                        hoverOffset: 8
                    }]
                },
                options: {
                    cutout: '55%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const v = context.raw || 0;
                                    const data = context.dataset.data || [];
                                    const sum = data.reduce((a, b) => a + (b || 0), 0);
                                    const pct = sum ? (v / sum * 100).toFixed(1) : 0;

                                    return context.label + ': ' + v + ' (' + pct + '%)';
                                }
                            }
                        }
                    },
                    elements: {
                        arc: {
                            borderColor: '#fff',
                            borderWidth: 2
                        }
                    },
                    maintainAspectRatio: false,
                    responsive: true
                }
            });
        }

        const statusCtx = document.getElementById('statusChart')?.getContext('2d');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($status_labels),
                    datasets: [{
                        data: @json($status_values),
                        backgroundColor: ['#f59e0b', '#22c55e'],
                        hoverOffset: 8
                    }]
                },
                options: {
                    cutout: '55%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const v = context.raw || 0;
                                    const data = context.dataset.data || [];
                                    const sum = data.reduce((a, b) => a + (b || 0), 0);
                                    const pct = sum ? (v / sum * 100).toFixed(1) : 0;
                                    return context.label + ': ' + v + ' (' + pct + '%)';
                                }
                            }
                        }
                    },
                    elements: {
                        arc: {
                            borderColor: '#fff',
                            borderWidth: 2
                        }
                    },
                    maintainAspectRatio: false,
                    responsive: true
                }
            });
        }

        const yearLabels = @json($year_labels);
        const yearValues = @json($year_values);

        const yearColors = [
            '#60a5fa',
            '#a78bfa',
            '#34d399',
            '#f59e0b',
            '#f472b6',
            '#14b8a6',
            '#fb7185',
            '#818cf8',
            '#22c55e',
            '#eab308'
        ];

        const yearCtx = document.getElementById('yearChart')?.getContext('2d');
        if (yearCtx) {
            new Chart(yearCtx, {
                type: 'doughnut',
                data: {
                    labels: yearLabels,
                    datasets: [{
                        data: yearValues,
                        backgroundColor: yearLabels.map((_, i) => yearColors[i % yearColors.length]),
                        hoverOffset: 8
                    }]
                },
                options: {
                    cutout: '55%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const v = context.raw || 0;
                                    const data = context.dataset.data || [];
                                    const sum = data.reduce((a, b) => a + (b || 0), 0);
                                    const pct = sum ? (v / sum * 100).toFixed(1) : 0;
                                    return context.label + ': ' + v + ' (' + pct + '%)';
                                }
                            }
                        }
                    },
                    elements: {
                        arc: {
                            borderColor: '#fff',
                            borderWidth: 2
                        }
                    },
                    maintainAspectRatio: false,
                    responsive: true
                }
            });
        }



    </script>
@endsection
