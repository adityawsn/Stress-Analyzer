@extends('admin.layouts.app')
@section('title', 'StressAnalyzer - Analisis Statistik')
@section('content')

    <style>
        /* :root {
            --sidebar-width: 260px;
            --primary-color: #3b82f6;
            --accent-yellow: #fff9e6;
            --soft-blue: #e0f2fe;
            --polindra-blue: #003399;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        } */

        /* Sidebar Styling */
        /* #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 20px;
            background-color: var(--accent-yellow);
            border-bottom: 1px solid #ffeeba;
        }

        .nav-link {
            padding: 12px 20px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            border-radius: 8px;
            margin: 4px 12px;
        }

        .nav-link:hover {
            background-color: var(--soft-blue);
            color: var(--primary-color);
        }

        .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
        }

        /* Main Content */
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

        .ai-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            border: none;
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
            #sidebar { left: -260px; }
            #sidebar.active { left: 0; }
            #main-content { margin-left: 0; }
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
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Aditya" alt="Avatar" class="rounded-circle border" width="40" height="40">
            </div>
        </header>

        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h4 class="fw-bold mb-0">Analisis Komparatif (Tsukamoto vs Mamdani)</h4>
                    <p class="text-muted small">Statistik korelasi variabel X1 (Tekanan) dan X2 (Manajemen Waktu) terhadap Stres.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn ai-btn rounded-pill px-4 shadow-sm" onclick="analyzeThesisGap()">
                        <i class="bi bi-stars"></i> Rekomendasi AI ✨
                    </button>
                </div>
            </div>

            <!-- Stats Row: Focused on Variable Indicators -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Rerata Tekanan (X1)</small>
                            <i class="bi bi-exclamation-circle text-danger"></i>
                        </div>
                        <h3 class="fw-bold mb-0">72.4</h3>
                        <p class="small text-muted mb-0">Indikator: Revisi Berulang</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Rerata Manajemen (X2)</small>
                            <i class="bi bi-clock text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-0">58.1</h3>
                        <p class="small text-muted mb-0">Indikator: Prokrastinasi</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Akurasi Tsukamoto</small>
                            <i class="bi bi-check-circle-fill text-success"></i>
                        </div>
                        <h3 class="fw-bold mb-0">81.0%</h3>
                        <p class="small text-muted mb-0">Berdasarkan data uji</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card data-card border-0 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">Akurasi Mamdani</small>
                            <i class="bi bi-check-circle-fill text-info"></i>
                        </div>
                        <h3 class="fw-bold mb-0">80.5%</h3>
                        <p class="small text-muted mb-0">Selisih defuzzifikasi</p>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-4">
                <div class="col-lg-7">
                    <div class="card data-card border-0 shadow-sm h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold mb-0">Distribusi Skor Stres (Tsukamoto vs Mamdani)</h6>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary active">7 Hari</button>
                                <button class="btn btn-outline-secondary">30 Hari</button>
                            </div>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="comparisonChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card data-card border-0 shadow-sm h-100">
                        <h6 class="fw-bold mb-4">Top Stresor (Indikator X1 & X2)</h6>
                        <div class="space-y-4">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Kesulitan Bimbingan (X1.2)</small>
                                    <small class="fw-bold">78%</small>
                                </div>
                                <div class="progress progress-custom">
                                    <div class="progress-bar bg-danger" style="width: 78%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Beban Revisi (X1.3)</small>
                                    <small class="fw-bold">65%</small>
                                </div>
                                <div class="progress progress-custom">
                                    <div class="progress-bar bg-warning" style="width: 65%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Manajemen Prioritas (X2.3)</small>
                                    <small class="fw-bold">55%</small>
                                </div>
                                <div class="progress progress-custom">
                                    <div class="progress-bar bg-info" style="width: 55%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Kesulitan Judul (X1.1)</small>
                                    <small class="fw-bold">30%</small>
                                </div>
                                <div class="progress progress-custom">
                                    <div class="progress-bar bg-success" style="width: 30%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 p-3 bg-light rounded-3">
                            <small class="text-muted d-block fw-bold"><i class="bi bi-info-circle-fill"></i> Sesuai Tabel 3.1 Proposal:</small>
                            <small class="text-muted">Variabel X1 menunjukkan pengaruh lebih besar terhadap Stres Tinggi dibandingkan X2 pada sampel saat ini.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table of Comparison Samples -->
            <div class="card data-card border-0 shadow-sm">
                <h6 class="fw-bold mb-3">Sampel Hasil Inferensi (Komparatif)</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 14px;">
                        <thead class="bg-light">
                            <tr class="text-muted">
                                <th class="ps-3">Mahasiswa</th>
                                <th>X1 (Skripsi)</th>
                                <th>X2 (Waktu)</th>
                                <th>Z (Tsukamoto)</th>
                                <th>Z (Mamdani)</th>
                                <th class="text-end pe-3">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3">Sampel #01 (Budi)</td>
                                <td>85 (Tinggi)</td>
                                <td>30 (Buruk)</td>
                                <td class="fw-bold">88.50</td>
                                <td class="fw-bold text-muted">87.20</td>
                                <td class="text-end pe-3"><span class="badge bg-danger">STRES TINGGI</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3">Sampel #02 (Anita)</td>
                                <td>50 (Sedang)</td>
                                <td>60 (Cukup)</td>
                                <td class="fw-bold">55.00</td>
                                <td class="fw-bold text-muted">54.80</td>
                                <td class="text-end pe-3"><span class="badge bg-warning text-dark">STRES SEDANG</span></td>
                            </tr>
                            <tr>
                                <td class="ps-3">Sampel #03 (Rizky)</td>
                                <td>20 (Rendah)</td>
                                <td>80 (Baik)</td>
                                <td class="fw-bold">22.15</td>
                                <td class="fw-bold text-muted">25.00</td>
                                <td class="text-end pe-3"><span class="badge bg-success">STRES RENDAH</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Modal -->
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
                        <p class="text-muted">Menganalisis korelasi variabel X1 & X2...</p>
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

        // Comparison Chart: Tsukamoto vs Mamdani Trends
        const ctx = document.getElementById('comparisonChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mhs 1', 'Mhs 2', 'Mhs 3', 'Mhs 4', 'Mhs 5', 'Mhs 6', 'Mhs 7'],
                datasets: [
                    {
                        label: 'Tsukamoto (Weighted Avg)',
                        data: [88, 55, 22, 90, 45, 60, 30],
                        borderColor: '#3b82f6',
                        backgroundColor: 'transparent',
                        tension: 0.3,
                        borderWidth: 3
                    },
                    {
                        label: 'Mamdani (Centroid)',
                        data: [87, 54, 25, 89, 48, 58, 35],
                        borderColor: '#a855f7',
                        backgroundColor: 'transparent',
                        borderDash: [5, 5],
                        tension: 0.3,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });

        async function callGemini(prompt, systemMsg = "") {
            const url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key=${apiKey}`;
            const payload = {
                contents: [{ parts: [{ text: prompt }] }],
                systemInstruction: { parts: [{ text: systemMsg }] }
            };
            const response = await fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
            const data = await response.json();
            return data.candidates[0].content.parts[0].text;
        }

        async function analyzeThesisGap() {
            aiResult.innerHTML = "";
            aiLoader.classList.remove('d-none');
            aiModal.show();

            const prompt = `Analisis temuan statistik skripsi mahasiswa di Polindra:
            - Variabel X1 (Tekanan Skripsi) mendominasi stres (rerata 72.4).
            - Variabel X2 (Manajemen Waktu) cukup rendah (rerata 58.1).
            - Akurasi Tsukamoto (81%) sedikit lebih tinggi dari Mamdani (80.5%).

            Berdasarkan indikator pada proposal (Judul, Bimbingan, Revisi, Jadwal), berikan 3 kesimpulan penelitian sementara dan saran penanganan stres mahasiswa skripsi yang profesional.`;

            try {
                const res = await callGemini(prompt, "Anda adalah asisten dosen pembimbing skripsi Polindra dan ahli logika fuzzy.");
                aiLoader.classList.add('d-none');
                aiResult.innerHTML = `
                    <h5 class="fw-bold mb-3">Analisis Penelitian Aditya Wisnu ✨</h5>
                    ${res.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')}
                `;
            } catch (e) {
                aiLoader.classList.add('d-none');
                aiResult.innerHTML = "Gagal memproses analisis AI.";
            }
        }
    </script>
@endsection
