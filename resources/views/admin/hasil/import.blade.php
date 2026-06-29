@extends('admin.layouts.app')

@section('title', 'StressAnalyzer - Impor Data Kuesioner')

@section('content')

    <style>
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
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header-import {
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }

        .card-body-import {
            padding: 20px;
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
                <i class="bi bi-file-earmark-arrow-up me-2"></i> Impor Data Kuesioner
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
            <!-- Page Title -->

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Impor Data Kuesioner</h4>
                    <p class="text-muted small mb-0">
                        Unggah file CSV atau Excel untuk menambah data responden. Sistem akan
                        otomatis menghitung TPS, MW, Tsukamoto, dan Mamdani.
                    </p>
                </div>

                <a href="{{ route('hasil.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <strong><i class="bi bi-exclamation-circle-fill"></i> Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Content Row -->
            <div class="row g-3">
                <!-- Form Column -->
                <div class="col-lg-8">
                    <!-- Upload Card -->
                    <div class="data-card shadow-sm mb-3">
                        <div class="card-header-import">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-upload"></i> Unggah File Data
                            </h6>
                        </div>
                        <div class="card-body-import">
                            <form action="{{ route('hasil.storeImport') }}" method="POST" enctype="multipart/form-data"
                                id="importForm">
                                @csrf

                                <!-- File Input -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Pilih File</label>
                                    <input type="file" name="file" id="fileInput"
                                        class="form-control form-control-sm @error('file') is-invalid @enderror"
                                        accept=".csv,.txt,.xlsx,.xls" required>
                                    <div class="small text-muted mt-2">
                                        <i class="bi bi-info-circle"></i> Format: CSV, TXT, XLSX, XLS (max. 5 MB)
                                    </div>
                                </div>

                                <!-- Requirements Grid -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <div class="small">
                                            <h6 class="fw-bold mb-2">Data Diri</h6>
                                            <div class="list-group list-group-flush">
                                                <div class="list-group-item border-0 py-1 px-0">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Email
                                                </div>
                                                <div class="list-group-item border-0 py-1 px-0">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Nama
                                                </div>
                                                <div class="list-group-item border-0 py-1 px-0">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Gender
                                                </div>
                                                <div class="list-group-item border-0 py-1 px-0">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Umur
                                                </div>
                                                <div class="list-group-item border-0 py-1 px-0">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Jenjang
                                                </div>
                                                <div class="list-group-item border-0 py-1 px-0">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Kampus
                                                </div>
                                                <div class="list-group-item border-0 py-1 px-0">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Jurusan
                                                </div>
                                                <div class="list-group-item border-0 py-1 px-0">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Prodi
                                                </div>
                                                <div class="list-group-item border-0 py-1 px-0">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Status
                                                </div>
                                                <div class="list-group-item border-0 py-1 px-0">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Tahun
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small">
                                            <h6 class="fw-bold mb-2">Pertanyaan & Hasil</h6>

                                            <div class="mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                q1 s/d q10 (Skala 1–5)
                                            </div>

                                            <div class="bg-light p-2 rounded">
                                                <strong class="d-block text-dark mb-1">
                                                    Sistem hitung otomatis:
                                                </strong>

                                                <small class="text-muted">
                                                    <div>→ TPS = rata-rata(q1-q5) × 20</div>
                                                    <div>→ MW = rata-rata(q6-q10) × 20</div>
                                                    <div>→ Tsukamoto defuzzifikasi</div>
                                                    <div>→ Mamdani defuzzifikasi</div>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2 d-md-flex">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-upload"></i> Impor Data
                                    </button>
                                    <a href="{{ route('hasil.index') }}" class="btn btn-outline-secondary">
                                        Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Template Card -->
                    <div class="data-card shadow-sm">
                        <div class="card-header-import">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-file-earmark-text"></i> Format File Template
                            </h6>
                        </div>
                        <div class="card-body-import">
                            <!-- Header -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Header (Baris Pertama)</label>
                                <div class="bg-light p-2 rounded overflow-auto"
                                    style="font-family: 'Courier New', monospace; font-size: 11px; line-height: 1.5;">
                                    email,nama,gender,umur,jenjang,kampus,jurusan,prodi,status,tahun,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10
                                </div>
                            </div>

                            <!-- Sample Data -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Contoh Data</label>
                                <div class="bg-light p-2 rounded overflow-auto"
                                    style="font-family: 'Courier New', monospace; font-size: 11px; line-height: 1.5;">
                                    aditya@gmail.com,Aditya,Laki-laki,21,D4/S1,Politeknik Negeri Indramayu,Teknik
                                    Informatika,RPL,Proses,2026,5,3,4,2,2,5,5,4,2,5
                                </div>
                            </div>

                            <!-- Reference Info -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="alert alert-light border small py-2 px-3 mb-0">
                                        <strong class="d-block text-dark small mb-1">Gender</strong>
                                        <small class="text-muted">Laki-laki / Perempuan</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="alert alert-light border small py-2 px-3 mb-0">
                                        <strong class="d-block text-dark small mb-1">Status</strong>
                                        <small class="text-muted">Proses / Selesai, atau label lengkap dari formulir</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Download Button -->
                            <button type="button" class="btn btn-outline-primary w-100 btn-sm"
                                onclick="downloadTemplate()">
                                <i class="bi bi-download"></i> Download Template CSV
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="col-lg-4">
                    <div class="data-card shadow-sm sticky-lg-top" style="top: 30px;">
                        <div class="card-header-import">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-lightbulb"></i> Panduan Langkah Demi Langkah
                            </h6>
                        </div>
                        <div class="card-body-import">
                            <!-- Step 1 -->
                            <div class="d-flex gap-3 mb-4">
                                <div>
                                    <div class="badge bg-primary rounded-circle"
                                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        1</div>
                                </div>
                                <div>
                                    <h6 class="fw-bold small mb-1">Siapkan Data</h6>
                                    <p class="small text-muted mb-0">Buat file CSV atau Excel mengikuti format template
                                        yang disediakan.</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="d-flex gap-3 mb-4">
                                <div>
                                    <div class="badge bg-primary rounded-circle"
                                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        2</div>
                                </div>
                                <div>
                                    <h6 class="fw-bold small mb-1">Pilih File</h6>
                                    <p class="small text-muted mb-0">Klik "Pilih File" dan pilih file CSV atau Excel Anda
                                        dari komputer.</p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="d-flex gap-3 mb-4">
                                <div>
                                    <div class="badge bg-primary rounded-circle"
                                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        3</div>
                                </div>
                                <div>
                                    <h6 class="fw-bold small mb-1">Impor Data</h6>
                                    <p class="small text-muted mb-0">Klik tombol "Impor Data" untuk mengunggah dan
                                        memproses file.</p>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="d-flex gap-3 mb-0">
                                <div>
                                    <div class="badge bg-primary rounded-circle"
                                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        4</div>
                                </div>
                                <div>
                                    <h6 class="fw-bold small mb-1">Proses Otomatis</h6>
                                    <p class="small text-muted mb-0">Sistem akan validasi, hitung, dan simpan semua data ke
                                        database secara otomatis.</p>
                                </div>
                            </div>

                            <hr class="my-3">

                            <!-- Info Box -->
                            <div class="alert alert-info border-0 py-2 px-3 small mb-0">
                                <i class="bi bi-info-circle-fill"></i> <strong>Tip:</strong> Download template terlebih
                                dahulu untuk memastikan format data Anda benar.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadTemplate() {
            const header =
                'email,nama,gender,umur,jenjang,kampus,jurusan,prodi,status,tahun,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10';
            const example =
                'aditya@gmail.com,Aditya,Laki-laki,21,D4/S1,Politeknik Negeri Indramayu,Teknik Informatika,RPL,Proses,2026,5,3,4,2,2,5,5,4,2,5';
            const csv = header + '\n' + example + '\n';

            const blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'template_kuesioner.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }
    </script>

@endsection
