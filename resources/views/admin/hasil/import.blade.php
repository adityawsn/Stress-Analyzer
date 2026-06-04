@extends('admin.layouts.app')

@section('title', 'Impor Data Kuesioner')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <i class="bi bi-file-earmark-arrow-up"></i> Impor Data Kuesioner
                </h2>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <!-- Import Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-upload"></i> Unggah File Data
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong>
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
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('hasil.storeImport') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-file-earmark-spreadsheet"></i> Pilih File (CSV/Excel)
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="file" id="fileInput" class="form-control" accept=".csv,.txt,.xlsx,.xls" required>
                                <small class="text-muted d-block mt-2">
                                    Format yang didukung: CSV, TXT, XLSX, XLS (max 5 MB)
                                </small>
                            </div>
                        </div>

                        <div class="mb-4 p-3 bg-light rounded">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-info-circle"></i> Struktur File yang Diperlukan
                            </h6>
                            <p class="text-muted small mb-3">
                                File harus memiliki kolom berikut (header pada baris pertama):
                            </p>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Data Diri</th>
                                            <th>Pertanyaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <small>
                                                    nama, email, gender<br>
                                                    umur, jenjang, kampus<br>
                                                    jurusan, prodi, status<br>
                                                    tahun
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    q1, q2, q3, q4, q5<br>
                                                    q6, q7, q8, q9, q10<br>
                                                    (nilai: 1-5)
                                                </small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mb-4 p-3 bg-info bg-opacity-10 rounded border border-info border-opacity-25">
                            <h6 class="fw-bold mb-2 text-info">
                                <i class="bi bi-lightning-fill"></i> Sistem akan otomatis:
                            </h6>
                            <ul class="small mb-0 text-muted">
                                <li>Menghitung <strong>TPS</strong> dari rata-rata q1-q5 × 20</li>
                                <li>Menghitung <strong>MW</strong> dari rata-rata q6-q10 × 20</li>
                                <li>Menghitung hasil <strong>Tsukamoto</strong> dan <strong>Mamdani</strong></li>
                                <li>Menyimpan semua data ke database</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-upload"></i> Impor Data
                            </button>
                            <a href="{{ route('hasil.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Template Download Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-file-download"></i> Template File
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-4">
                        Gunakan template CSV sebagai referensi untuk format file yang benar.
                    </p>

                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">Contoh Format Baris:</h6>
                        <div class="bg-light p-2 rounded small" style="overflow-x: auto; font-family: monospace;">
nama,email,gender,umur,jenjang,kampus,jurusan,prodi,status,tahun,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10<br>
Aditya,aditya@gmail.com,Laki-laki,21,D4 / S1,Politeknik,Informatika,RPL,Proses,2026,5,3,4,2,2,5,5,4,2,5
                        </div>
                    </div>

                    <div class="alert alert-warning small mb-3">
                        <strong>Catatan:</strong> Gender harus "Laki-laki" atau "Perempuan", status harus "Proses" atau "Selesai"
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary w-100" onclick="downloadTemplate()">
                        <i class="bi bi-download"></i> Download Template CSV
                    </button>
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
