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
            border-radius: 16px;
            overflow: hidden;
        }

        .table-indicator {
            font-size: 11px;
            color: #94a3b8;
            font-style: italic;
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
                <i class="bi bi-file-earmark-arrow-up me-2"></i> Impor Data Kuesioner
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
                    <h4 class="fw-bold mb-0">Impor Data Kuesioner</h4>
                    <p class="text-muted small mb-0">
                        Unggah file CSV atau Excel untuk import responden baru. Sistem akan otomatis menghitung TPS, MW, Tsukamoto, dan Mamdani.
                    </p>
                </div>
                <a href="{{ route('hasil.index') }}" class="btn btn-sm btn-light border rounded-pill">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Import Form Card -->
                    <div class="data-card shadow-sm border-0 mb-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="bi bi-exclamation-circle"></i> Gagal!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('warning'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> {{ session('warning') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-x-circle"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('hasil.storeImport') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-bold">Pilih File CSV atau Excel</label>
                                <input type="file" name="file" id="fileInput" class="form-control" accept=".csv,.txt,.xlsx,.xls" required>
                                <small class="text-muted d-block mt-2">
                                    Format yang didukung: CSV, TXT, XLSX, XLS (max 5 MB)
                                </small>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Data Diri Responden</h6>
                                    <ul class="small text-muted list-unstyled">
                                        <li>✓ nama</li>
                                        <li>✓ email</li>
                                        <li>✓ gender</li>
                                        <li>✓ umur</li>
                                        <li>✓ jenjang</li>
                                        <li>✓ kampus</li>
                                        <li>✓ jurusan</li>
                                        <li>✓ prodi</li>
                                        <li>✓ status</li>
                                        <li>✓ tahun</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Pertanyaan & Hasil</h6>
                                    <ul class="small text-muted list-unstyled">
                                        <li>✓ q1 s/d q10 (nilai 1-5)</li>
                                        <li class="mt-2"><strong>Sistem hitung otomatis:</strong></li>
                                        <li>→ TPS = avg(q1-q5) × 20</li>
                                        <li>→ MW = avg(q6-q10) × 20</li>
                                        <li>→ Tsukamoto</li>
                                        <li>→ Mamdani</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-upload"></i> Impor Data
                                </button>
                                <a href="{{ route('hasil.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Template Guide Card -->
                <div class="data-card shadow-sm border-0">
                    <div class="table-responsive">
                        <div class="p-4 border-bottom">
                            <h6 class="fw-bold mb-3"><i class="bi bi-file-earmark-text"></i> Format Template CSV</h6>
                            <div class="bg-light p-3 rounded small" style="overflow-x: auto; font-family: 'Courier New';">
                                <div class="text-muted mb-2">Header (baris pertama):</div>
nama,email,gender,umur,jenjang,kampus,jurusan,prodi,status,tahun,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10
                                <div class="text-muted mt-3 mb-2">Contoh data (baris kedua dst):</div>
Aditya,aditya@gmail.com,Laki-laki,21,D4 / S1,Politeknik,Informatika,RPL,Proses,2026,5,3,4,2,2,5,5,4,2,5
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <strong class="d-block mb-2">Gender</strong>
                                        <span class="small text-muted">Laki-laki atau Perempuan</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <strong class="d-block mb-2">Status</strong>
                                        <span class="small text-muted">Proses atau Selesai</span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary w-100" onclick="downloadTemplate()">
                                <i class="bi bi-download"></i> Download Template CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="col-lg-4">
                <div class="data-card shadow-sm border-0">
                    <div class="p-4 border-bottom">
                        <h6 class="fw-bold mb-2"><i class="bi bi-info-circle"></i> Informasi</h6>
                    </div>
                    <div class="p-4">
                        <div class="mb-3">
                            <strong class="d-block mb-2 small">✓ Unggah File</strong>
                            <p class="small text-muted mb-0">Pilih file CSV atau Excel dengan format sesuai template.</p>
                        </div>
                        <div class="mb-3">
                            <strong class="d-block mb-2 small">✓ Validasi Data</strong>
                            <p class="small text-muted mb-0">Sistem akan validasi setiap baris data yang diimpor.</p>
                        </div>
                        <div class="mb-3">
                            <strong class="d-block mb-2 small">✓ Hitung Otomatis</strong>
                            <p class="small text-muted mb-0">Sistem akan hitung TPS, MW, Tsukamoto & Mamdani secara otomatis.</p>
                        </div>
                        <div>
                            <strong class="d-block mb-2 small">✓ Simpan Database</strong>
                            <p class="small text-muted mb-0">Semua data responden baru disimpan ke database.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    function downloadTemplate() {
        const header = 'nama,email,gender,umur,jenjang,kampus,jurusan,prodi,status,tahun,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10';
        const sample = 'Aditya Wisnu,aditya@gmail.com,Laki-laki,21,D4 / S1,Politeknik Negeri Indramayu,Teknik Informatika,Rekayasa Perangkat Lunak,Proses,2026,5,3,4,2,2,5,5,4,2,5';
        
        const csv = header + '\n' + sample;
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'template_kuesioner.csv';
        link.click();
    }

    // Show selected file name
    document.getElementById('fileInput').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih file...';
        const label = document.querySelector('.file-upload-wrapper .form-control');
        if (e.target.files.length > 0) {
            label.value = fileName;
        }
    });
</script>
@endsection
