@extends('admin.layouts.app')
@section('title', 'StressAnalyzer - Pengaturan Fuzzy')
@section('content')
    <style>
        /* :root {
            --sidebar-width: 260px;
            --primary-color: #3b82f6;
            --accent-yellow: #fff9e6;
            --soft-blue: #e0f2fe;
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
        } */

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

        .config-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 24px;
        }

        .fuzzy-curve-container {
            height: 200px;
            background: #fdfdfd;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ai-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            border: none;
        }

        .rule-row {
            background: #f8fafc;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            border-left: 4px solid var(--primary-color);
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
                <i class="bi bi-gear-fill me-2"></i> Konfigurasi Variabel Fuzzy & Basis Aturan
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Parameter Penelitian (X1 & X2)</h4>
                    <p class="text-muted small">Sesuai Bab 3 proposal: Tekanan Skripsi & Manajemen Waktu.</p>
                </div>
                <button class="btn ai-btn rounded-pill px-4">
                    Simpan Konfigurasi
                </button>
            </div>

            <div class="row">
                <!-- Variabel X1 -->
                <div class="col-lg-6">
                    <div class="config-card shadow-sm border-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-primary">Variabel X1: Tekanan Skripsi</h6>
                            <span class="badge bg-soft-blue text-primary border border-primary-subtle">Semesta: 0-100</span>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <label class="small text-muted">Rendah (Trapmf)</label>
                                <input type="text" class="form-control form-control-sm" value="0, 0, 20, 40">
                            </div>
                            <div class="col-4">
                                <label class="small text-muted">Sedang (Trimf)</label>
                                <input type="text" class="form-control form-control-sm" value="30, 50, 70">
                            </div>
                            <div class="col-4">
                                <label class="small text-muted">Tinggi (Trapmf)</label>
                                <input type="text" class="form-control form-control-sm" value="60, 80, 100, 100">
                            </div>
                        </div>
                        <div class="fuzzy-curve-container">
                            <canvas id="chartX1"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Variabel X2 -->
                <div class="col-lg-6">
                    <div class="config-card shadow-sm border-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-warning">Variabel X2: Manajemen Waktu</h6>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Semesta: 0-100</span>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <label class="small text-muted">Buruk (Trapmf)</label>
                                <input type="text" class="form-control form-control-sm" value="0, 0, 30, 50">
                            </div>
                            <div class="col-4">
                                <label class="small text-muted">Cukup (Trimf)</label>
                                <input type="text" class="form-control form-control-sm" value="40, 60, 80">
                            </div>
                            <div class="col-4">
                                <label class="small text-muted">Baik (Trapmf)</label>
                                <input type="text" class="form-control form-control-sm" value="70, 90, 100, 100">
                            </div>
                        </div>
                        <div class="fuzzy-curve-container">
                            <canvas id="chartX2"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Method & Rule Base -->
                <div class="col-lg-12">
                    <div class="config-card shadow-sm border-0">
                        <div class="row">
                            <div class="col-md-4 border-end">
                                <h6 class="fw-bold mb-3">Metode Inferensi Komparatif</h6>
                                <div class="p-3 bg-light rounded-3 mb-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="method" id="tsukamoto" checked>
                                        <label class="form-check-label fw-medium" for="tsukamoto">Tsukamoto (Weighted Avg)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="method" id="mamdani">
                                        <label class="form-check-label fw-medium" for="mamdani">Mamdani (Centroid)</label>
                                    </div>
                                </div>
                                <div class="alert alert-info py-2 small border-0">
                                    <i class="bi bi-info-circle me-1"></i> Perbandingan ini dilakukan untuk menguji metode yang paling representatif.
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="fw-bold mb-3">Basis Aturan (Rule Base) - Tabel 3.1 & Proposal</h6>
                                <div class="rules-list" style="max-height: 200px; overflow-y: auto;">
                                    <div class="rule-row small"><strong>R1:</strong> IF Tekanan Tinggi AND Manajemen Buruk THEN Stres Tinggi</div>
                                    <div class="rule-row small"><strong>R2:</strong> IF Tekanan Tinggi AND Manajemen Cukup THEN Stres Tinggi</div>
                                    <div class="rule-row small"><strong>R3:</strong> IF Tekanan Tinggi AND Manajemen Baik THEN Stres Sedang</div>
                                    <div class="rule-row small"><strong>R4:</strong> IF Tekanan Sedang AND Manajemen Buruk THEN Stres Tinggi</div>
                                    <div class="rule-row small"><strong>R5:</strong> IF Tekanan Sedang AND Manajemen Cukup THEN Stres Sedang</div>
                                    <div class="rule-row small"><strong>R6:</strong> IF Tekanan Sedang AND Manajemen Baik THEN Stres Rendah</div>
                                    <div class="rule-row small"><strong>R7:</strong> IF Tekanan Rendah AND Manajemen Buruk THEN Stres Sedang</div>
                                    <div class="rule-row small"><strong>R8:</strong> IF Tekanan Rendah AND Manajemen Cukup THEN Stres Rendah</div>
                                    <div class="rule-row small"><strong>R9:</strong> IF Tekanan Rendah AND Manajemen Baik THEN Stres Rendah</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Modal -->
    <div class="modal fade" id="aiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header ai-btn border-0 text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-stars"></i> Optimasi Aturan Gemini AI ✨</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="ai-loader" class="text-center py-5 d-none">
                        <div class="spinner-border text-primary mb-3"></div>
                        <p class="text-muted">Menganalisis indikator X1 & X2 dari proposal Anda...</p>
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

        // Generate Charts for X1 and X2 (Trapmf/Trimf)
        function initChart(id, labelA, labelB, labelC) {
            const ctx = document.getElementById(id).getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
                    datasets: [
                        { label: labelA, data: [1, 1, 0.8, 0.4, 0, 0, 0, 0, 0, 0, 0], borderColor: '#10b981', tension: 0 },
                        { label: labelB, data: [0, 0, 0, 0.2, 0.6, 1, 0.6, 0.2, 0, 0, 0], borderColor: '#f59e0b', tension: 0 },
                        { label: labelC, data: [0, 0, 0, 0, 0, 0, 0.2, 0.6, 0.8, 1, 1], borderColor: '#ef4444', tension: 0 }
                    ]
                },
                options: { maintainAspectRatio: false, plugins: { legend: { labels: { font: { size: 10 } } } } }
            });
        }

        initChart('chartX1', 'Rendah', 'Sedang', 'Tinggi');
        initChart('chartX2', 'Buruk', 'Cukup', 'Baik');

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

        async function optimizeRulesAI() {
            aiResult.innerHTML = "";
            aiLoader.classList.remove('d-none');
            aiModal.show();

            const prompt = `Analisis basis aturan untuk skripsi saya di Polindra:
            X1 (Tekanan Skripsi: Rendah, Sedang, Tinggi)
            X2 (Manajemen Waktu: Buruk, Cukup, Baik)
            Hasil: Tingkat Stres (Rendah, Sedang, Tinggi).

            Berdasarkan 9 aturan yang saya miliki, apakah ada saran perubahan parameter atau penambahan aturan yang lebih akurat secara psikologis untuk mahasiswa tingkat akhir?`;

            try {
                const res = await callGemini(prompt, "Anda adalah asisten peneliti ahli logika fuzzy untuk Aditya Wisnu.");
                aiLoader.classList.add('d-none');
                aiResult.innerHTML = `<h5>Saran Optimasi Variabel ✨</h5><hr>${res.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')}`;
            } catch (e) {
                aiLoader.classList.add('d-none');
                aiResult.innerHTML = "Gagal memuat optimasi.";
            }
        }
    </script>
@endsection
