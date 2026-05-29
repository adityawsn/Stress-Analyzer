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
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Aditya" alt="Avatar" class="rounded-circle border" width="40" height="40">
            </div>
        </header>

        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h5 class="fw-bold mb-1">Status Dashboard Penelitian</h5>
                    <p class="text-muted small">Ringkasan data 50 responden penelitian tingkat stres skripsi.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn ai-btn rounded-pill px-4" onclick="generateInsightAI()">
                        <i class="bi bi-stars"></i> Insight AI ✨
                    </button>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card p-3 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Total Sampel (N)</small>
                                <h3 class="mb-0 fw-bold mt-1">50</h3>
                            </div>
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                        <div class="mt-3 small text-success fw-bold">
                            Mahasiswa Polindra
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-3 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Rerata X1 (Tekanan)</small>
                                <h3 class="mb-0 fw-bold mt-1 text-danger">74.2</h3>
                            </div>
                            <div class="icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-journal-x"></i>
                            </div>
                        </div>
                        <div class="mt-3 small text-muted">Kategori: <span class="fw-bold text-danger">Tinggi</span></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-3 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Rerata X2 (Manajemen)</small>
                                <h3 class="mb-0 fw-bold mt-1 text-warning">56.8</h3>
                            </div>
                            <div class="icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-alarm"></i>
                            </div>
                        </div>
                        <div class="mt-3 small text-muted">Kategori: <span class="fw-bold text-warning">Cukup</span></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-3 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Akurasi Sistem</small>
                                <h3 class="mb-0 fw-bold mt-1 text-success">81.2%</h3>
                            </div>
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="bi bi-patch-check"></i>
                            </div>
                        </div>
                        <div class="mt-3 small text-success fw-bold">vs Penilaian Pakar</div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Main Chart -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 h-100 rounded-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold mb-0">Komparatif Hasil: Tsukamoto vs Mamdani</h6>
                            <small class="text-muted">Sampel Acak Responden</small>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="comparisonChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Distribution -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <h6 class="fw-bold mb-4">Distribusi Kategori (Fuzzy)</h6>
                        <div style="height: 250px;">
                            <canvas id="donutChart"></canvas>
                        </div>
                        <div class="mt-4 small">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="bi bi-circle-fill text-success me-2"></i> Rendah</span>
                                <span class="fw-bold">45%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="bi bi-circle-fill text-warning me-2"></i> Sedang</span>
                                <span class="fw-bold">35%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="bi bi-circle-fill text-danger me-2"></i> Tinggi</span>
                                <span class="fw-bold">20%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Insight Modal -->
    <div class="modal fade" id="aiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header ai-btn border-0 text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-stars"></i> Analisis Cerdas Gemini ✨</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="ai-loader" class="text-center py-5 d-none">
                        <div class="spinner-border text-primary mb-3"></div>
                        <p class="text-muted">Gemini sedang merangkum hasil penelitian Anda...</p>
                    </div>
                    <div id="ai-result" class="lh-lg"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const apiKey = "";
        const aiModal = new bootstrap.Modal(document.getElementById('aiModal'));
        const aiResult = document.getElementById('ai-result');
        const aiLoader = document.getElementById('ai-loader');

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Comparison Chart
        new Chart(document.getElementById('comparisonChart'), {
            type: 'line',
            data: {
                labels: ['Mhs 1', 'Mhs 2', 'Mhs 3', 'Mhs 4', 'Mhs 5', 'Mhs 6', 'Mhs 7'],
                datasets: [
                    {
                        label: 'Tsukamoto',
                        data: [82, 55, 30, 88, 45, 60, 25],
                        borderColor: '#3b82f6',
                        backgroundColor: 'transparent',
                        tension: 0.3,
                        borderWidth: 3
                    },
                    {
                        label: 'Mamdani',
                        data: [80, 52, 35, 85, 48, 58, 30],
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
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // Distribution Chart
        new Chart(document.getElementById('donutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Rendah', 'Sedang', 'Tinggi'],
                datasets: [{
                    data: [45, 35, 20],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: { maintainAspectRatio: false, cutout: '75%' }
        });

        async function generateInsightAI() {
            aiResult.innerHTML = "";
            aiLoader.classList.remove('d-none');
            aiModal.show();

            const prompt = `Berikan ringkasan analisis untuk dashboard StressAnalyzer Polindra.
            Data: 50 responden, rerata Tekanan (X1) 74.2 (Tinggi), rerata Manajemen Waktu (X2) 56.8 (Cukup).
            Metode Tsukamoto dan Mamdani menunjukkan korelasi 98% dengan selisih rata-rata 2.5%.
            Berikan interpretasi hasil ini untuk kebutuhan skripsi Aditya Wisnu.`;

            try {
                const url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key=${apiKey}`;
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ contents: [{ parts: [{ text: prompt }] }] })
                });
                const data = await response.json();
                const text = data.candidates[0].content.parts[0].text;
                aiLoader.classList.add('d-none');
                aiResult.innerHTML = text.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            } catch (e) {
                aiLoader.classList.add('d-none');
                aiResult.innerHTML = "Gagal memproses data.";
            }
        }
    </script>
@endsection



