@extends('admin.layouts.app')
@section('title', 'StressAnalyzer - Hasil Kuesioner')
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

        .data-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
        }

        .ai-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            border: none;
        }

        .status-pill {
            font-size: 11px;
            padding: 4px 12px;
            border-radius: 50px;
            font-weight: 600;
        }

        .table-indicator {
            font-size: 11px;
            color: #94a3b8;
            font-style: italic;
        }

        .results-toolbar {
            gap: 1rem;
        }

        .results-actions {
            gap: 0.75rem;
        }

        .results-search {
            width: min(350px, 42vw);
        }

        .results-table th {
            white-space: nowrap;
        }

        .results-table td {
            vertical-align: middle;
        }

        .result-action-btn {
            white-space: nowrap;
        }

        .results-pagination {
            gap: 1rem;
        }

        @media (max-width: 991.98px) {
            #sidebar { left: -260px; }
            #sidebar.active { left: 0; }
            #main-content { margin-left: 0; }
        }

        @media (max-width: 767.98px) {
            #main-content {
                padding: 14px;
            }

            .top-nav {
                padding: 10px 16px;
                margin: -14px -14px 16px -14px;
            }

            .results-toolbar {
                align-items: stretch !important;
                flex-direction: column;
                margin-bottom: 1rem !important;
            }

            .results-actions {
                flex-wrap: wrap;
            }

            .results-search {
                width: 100%;
                flex: 1 0 100%;
            }

            .results-actions .btn {
                flex: 1 1 0;
            }

            .data-card {
                border-radius: 14px;
                background: transparent;
                box-shadow: none !important;
                overflow: visible;
            }

            .results-table-wrapper {
                overflow: visible;
                padding-bottom: 0.25rem;
            }

            .results-table {
                border-collapse: separate;
                border-spacing: 0;
            }

            .results-table thead {
                display: none;
            }

            .results-table,
            .results-table tbody,
            .results-table tr,
            .results-table td {
                display: block;
                width: 100%;
            }

            .results-table tbody tr {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
                overflow: hidden;
                margin-bottom: 16px;
            }

            .results-table tbody tr:last-child {
                margin-bottom: 0;
            }

            .results-table tbody td {
                border-bottom: 1px solid #f1f5f9;
                display: flex;
                justify-content: space-between;
                gap: 1rem;
                padding: 0.85rem 1rem !important;
                text-align: right !important;
            }

            .results-table tbody td::before {
                content: attr(data-label);
                color: #64748b;
                flex: 0 0 42%;
                font-size: 0.76rem;
                font-weight: 700;
                letter-spacing: 0.02em;
                text-align: left;
                text-transform: uppercase;
            }

            .results-table tbody td:last-child {
                border-bottom: 0;
            }

            .results-table .result-identity {
                background: #f8fafc;
                display: block;
                text-align: left !important;
            }

            .results-table .result-identity::before {
                display: block;
                margin-bottom: 0.35rem;
            }

            .results-table .result-action {
                display: block;
                text-align: left !important;
            }

            .results-table .result-action::before {
                display: block;
                margin-bottom: 0.5rem;
            }

            .result-action-btn {
                width: 100%;
            }

            .results-table .empty-state-row {
                border: 1px dashed #cbd5e1;
                box-shadow: none;
            }

            .results-table .empty-state-row td {
                display: block;
                text-align: center !important;
            }

            .results-table .empty-state-row td::before {
                content: none;
            }

            .results-pagination {
                align-items: stretch !important;
                background: white !important;
                border-radius: 14px;
                flex-direction: column;
                padding: 1rem !important;
            }

            .results-pagination nav,
            .results-pagination .pagination {
                width: 100%;
            }

            .results-pagination .pagination {
                flex-wrap: wrap;
                justify-content: center;
                margin-bottom: 0;
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
                <i class="bi bi-clipboard-check-fill me-2"></i> Hasil Jawaban Kuesioner
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <p class="mb-0 fw-semibold" style="font-size: 14px;">Admin</p>
                    <small class="text-muted" style="font-size: 12px;">Sistem StressAnalyzer</small>
                </div>
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Aditya" alt="Avatar" class="rounded-circle border" width="40" height="40">
            </div>
        </header>

        <div class="container-fluid py-2">
            <div class="results-toolbar d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Tabulasi Data Kuesioner</h4>
                    <p class="text-muted small mb-0">
                        Input variabel X1 (Tekanan) & X2 (Manajemen Waktu) untuk komparasi Fuzzy.
                    </p>
                </div>

                <div class="results-actions d-flex">
                    <form method="GET" action="{{ url()->current() }}" class="results-search">
                        <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari responden...">
                    </form>
                    <a href="{{ route('hasil.import') }}" class="btn btn-sm btn-light border rounded-pill">
                        <i class="bi bi-file-earmark-arrow-up"></i> Impor
                    </a>
                    <a href="{{ route('hasil.export', request()->only('q')) }}" class="btn btn-sm btn-light border rounded-pill">
                        <i class="bi bi-file-earmark-arrow-down"></i> Ekspor
                    </a>
                </div>
            </div>

            <!-- Questionnaire Table with Comparative Results -->
            <div class="data-card shadow-sm border-0">
                <div class="table-responsive results-table-wrapper">
                    <table class="table table-hover align-middle mb-0 results-table">
                        <thead class="bg-light text-muted">
                            <tr class="small text-uppercase">
                                <th class="ps-4 py-3">Identitas Responden</th>
                                <th>Tekanan Skripsi (X1)</th>
                                <th>Manajemen Waktu (X2)</th>
                                <th>Tsukamoto (Z)</th>
                                <th>Mamdani (Z)</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($results->isEmpty())
                                <tr class="empty-state-row">
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data kuesioner.
                                    </td>
                                </tr>
                            @else
                                @foreach($results as $result)
                                    @php
                                        $tpsCat = $result->tps >= 30 && $result->tps < 70 ? 'Sedang' : ($result->tps >= 70 ? 'Tinggi' : 'Rendah');
                                        $tpsCatColor = $result->tps >= 70 ? 'text-danger' : ($result->tps >= 30 ? 'text-warning' : 'text-success');

                                        $mwCat = $result->mw >= 30 && $result->mw < 70 ? 'Cukup' : ($result->mw >= 70 ? 'Baik' : 'Buruk');
                                        $mwCatColor = $result->mw >= 70 ? 'text-success' : ($result->mw >= 30 ? 'text-primary' : 'text-danger');

                                        $tsukColor = $result->tsukamoto['kategori'] === 'Tinggi' ? 'text-danger' : ($result->tsukamoto['kategori'] === 'Sedang' ? 'text-warning' : 'text-success');
                                        $mandColor = $result->mamdani['kategori'] === 'Tinggi' ? 'text-danger' : ($result->mamdani['kategori'] === 'Sedang' ? 'text-warning' : 'text-success');
                                    @endphp
                                    <tr>
                                        <td class="ps-4 result-identity" data-label="Responden">
                                            <div class="fw-bold">{{ $result->nama }}</div>
                                            <div class="table-indicator">{{ $result->kampus }} - {{ $result->prodi }}</div>
                                        </td>
                                        <td data-label="Tekanan (X1)">
                                            <div class="fw-bold">{{ number_format($result->tps, 2) }}</div>
                                            <div class="table-indicator {{ $tpsCatColor }}">{{ $tpsCat }}</div>
                                        </td>
                                        <td data-label="Manajemen (X2)">
                                            <div class="fw-bold">{{ number_format($result->mw, 2) }}</div>
                                            <div class="table-indicator {{ $mwCatColor }}">{{ $mwCat }}</div>
                                        </td>
                                        <td data-label="Tsukamoto">
                                            <span class="fw-bold {{ $tsukColor }}">{{ number_format($result->tsukamoto['nilai'], 2) }}</span>
                                            <div class="table-indicator">{{ $result->tsukamoto['kategori'] }}</div>
                                        </td>
                                        <td data-label="Mamdani">
                                            <span class="fw-bold {{ $mandColor }}">{{ number_format($result->mamdani['nilai'], 2) }}</span>
                                            <div class="table-indicator">{{ $result->mamdani['kategori'] }}</div>
                                        </td>
                                        <td class="text-end pe-4 result-action" data-label="Aksi">
                                            <button class="btn btn-sm btn-light border rounded-pill result-action-btn" onclick="showComparativeDetail({{ $result->id }})">
                                                <i class="bi bi-intersect"></i> Bandingkan
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="p-4 border-top bg-light d-flex justify-content-between align-items-center results-pagination">
                    <small class="text-muted">Total {{ $results->total() }} Responden</small>
                    <nav>
                        {{ $results->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparative Modal -->
    <div class="modal fade" id="aiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header ai-btn border-0 text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-intersect"></i> Analisis Perbandingan Defuzzifikasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="ai-loader" class="text-center py-5 d-none">
                        <div class="spinner-border text-primary mb-3"></div>
                        <p class="text-muted">Memuat data perbandingan...</p>
                    </div>
                    <div id="ai-result"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const aiModal = new bootstrap.Modal(document.getElementById('aiModal'));
        const aiResult = document.getElementById('ai-result');
        const aiLoader = document.getElementById('ai-loader');

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        async function showComparativeDetail(id) {
            aiResult.innerHTML = "";
            aiLoader.classList.remove('d-none');
            aiModal.show();

            try {
                const response = await fetch(`/hasil-kuesioner/${id}/detail`);
                const data = await response.json();

                aiLoader.classList.add('d-none');

                const html = `
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h6 class="fw-bold text-primary mb-2">${data.nama}</h6>
                            <small class="text-muted d-block">${data.kampus} - ${data.prodi}</small>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold mb-2">INPUT VARIABEL</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted">X1 (Tekanan Skripsi):</td>
                                    <td class="fw-bold text-end">${parseFloat(data.x1_tps).toFixed(2)}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">X2 (Manajemen Waktu):</td>
                                    <td class="fw-bold text-end">${parseFloat(data.x2_mw).toFixed(2)}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold mb-2">OUTPUT DEFUZZIFIKASI</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted">Tsukamoto (Z):</td>
                                    <td class="fw-bold text-end text-danger">${parseFloat(data.tsukamoto.nilai).toFixed(2)} (${data.tsukamoto.kategori})</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Mamdani (Z):</td>
                                    <td class="fw-bold text-end text-primary">${parseFloat(data.mamdani.nilai).toFixed(2)} (${data.mamdani.kategori})</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 mb-3">
                        <strong>Selisih Defuzzifikasi:</strong> <span class="text-danger fw-bold">${parseFloat(data.selisih).toFixed(2)}</span> (Perbedaan antara metode Tsukamoto dan Mamdani)
                    </div>

                    <div class="alert alert-light border-1 border-warning">
                        <h6 class="text-warning mb-2">📊 Deskripsi Singkat</h6>
                        <p class="mb-0 small">${data.deskripsi}</p>
                    </div>
                `;

                aiResult.innerHTML = html;
            } catch (err) {
                aiLoader.classList.add('d-none');
                aiResult.innerHTML = '<div class="alert alert-danger">Gagal memuat data detail.</div>';
                console.error(err);
            }
        }
    </script>
@endsection
