@extends('admin.layouts.app')

@section('title', 'StressAnalyzer - Data Mahasiswa')
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

        .avatar-circle {
            width: 40px;
            height: 40px;
            background-color: var(--soft-blue);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
        }

        .fuzzy-badge {
            font-size: 10px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
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
                <i class="bi bi-person-badge-fill me-2"></i> Manajemen Data Mahasiswa
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
                    <h4 class="fw-bold mb-0">Daftar Mahasiswa Teranalisis</h4>
                    <p class="text-muted small mb-0">
                        Total {{ $students->total() }} Responden - Data Pribadi Mahasiswa.
                    </p>
                </div>

                {{-- <div class="d-flex gap-3">
                    <button class="btn btn-success rounded-pill px-4" onclick="importData()">
                        <i class="bi bi-upload me-2"></i> Impor
                    </button>

                    <button class="btn btn-primary rounded-pill px-4" onclick="exportData()">
                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Ekspor
                    </button>
                </div> --}}

                <form method="GET" action="{{ url()->current() }}" class="d-flex" role="search" style="width: 500px;">
                    <input type="search" name="q" value="{{ request('q') }}"
                        class="form-control form-control-sm me-2" placeholder="Cari nama, kampus, jurusan, atau prodi...">
                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                </form>
            </div>

            <!-- Data Mahasiswa -->
            <div class="data-card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-muted text-uppercase">
                                <th class="ps-4 py-3">Nama Mahasiswa</th>
                                <th>Asal Kampus</th>
                                <th>Program Studi</th>
                                <th>Status</th>
                                <th>Tahun</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($students->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data mahasiswa.
                                    </td>
                                </tr>
                            @else
                                @foreach ($students as $student)
                                    @php
                                        $nameParts = preg_split('/\s+/', trim($student->nama));
                                        $initials = '';
                                        foreach ($nameParts as $part) {
                                            if ($part !== '') {
                                                $initials .= strtoupper(mb_substr($part, 0, 1));
                                            }
                                            if (mb_strlen($initials) >= 2) {
                                                break;
                                            }
                                        }
                                        $program = $student->prodi ?: $student->jurusan;
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-circle">{{ $initials }}</div>
                                                <div>
                                                    <div class="fw-bold">{{ $student->nama }}</div>
                                                    <small class="text-muted">{{ $student->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $student->kampus }}</td>
                                        <td>{{ $program }}</td>
                                        <td>{{ $student->status_label }}</td>
                                        <td>{{ $student->tahun }}</td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                                <button class="btn btn-white btn-sm px-3"
                                                    onclick="showFullDetail('{{ addslashes($student->nama) }}', '{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}', '{{ $student->email }}', {{ $student->umur }}, '{{ $student->jenjang }}', '{{ addslashes($student->kampus) }}', '{{ addslashes($student->jurusan) }}', '{{ addslashes($student->prodi) }}', '{{ $student->status_label }}', {{ $student->tahun }})">Detail</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @if ($students->hasPages())
                    <div class="p-3 border-top bg-light d-flex justify-content-end">
                        {{ $students->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Detail Lengkap -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold text-primary"><i class="bi bi-person-lines-fill me-2"></i> Profil Lengkap
                        Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase border-bottom pb-2 mb-3">Informasi Pribadi
                            </h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted w-50">Nama Lengkap:</td>
                                    <td class="fw-bold" id="det-nama">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jenis Kelamin:</td>
                                    <td class="fw-bold" id="det-jk">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Email:</td>
                                    <td class="fw-bold" id="det-email">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Umur:</td>
                                    <td class="fw-bold" id="det-umur">-</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase border-bottom pb-2 mb-3">Informasi Akademik
                            </h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted w-50">Asal Kampus:</td>
                                    <td class="fw-bold" id="det-kampus">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Fakultas / Jurusan:</td>
                                    <td class="fw-bold" id="det-fakultas">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Prodi:</td>
                                    <td class="fw-bold" id="det-prodi">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jenjang:</td>
                                    <td class="fw-bold" id="det-jenjang">-</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 mt-0">
                            <div class="p-3 rounded-4" style="background-color: var(--accent-yellow);">
                                <h6 class="text-warning-emphasis small fw-bold text-uppercase mb-2">Status Pengerjaan
                                    Skripsi</h6>
                                <div class="row text-center">
                                    <div class="col-6 border-end">
                                        <small class="text-muted d-block">Status Saat Ini</small>
                                        <span class="fw-bold text-dark" id="det-status">-</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Tahun Mulai</small>
                                        <span class="fw-bold text-dark" id="det-tahun">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        function showFullDetail(nama, jk, email, umur, jenjang, kampus, fakultas, prodi, status, tahun) {
            document.getElementById('det-nama').innerText = nama;
            document.getElementById('det-jk').innerText = jk;
            document.getElementById('det-email').innerText = email;
            document.getElementById('det-umur').innerText = umur + " Tahun";
            document.getElementById('det-jenjang').innerText = jenjang;
            document.getElementById('det-kampus').innerText = kampus;
            document.getElementById('det-fakultas').innerText = fakultas;
            document.getElementById('det-prodi').innerText = prodi;
            document.getElementById('det-status').innerText = status;
            document.getElementById('det-tahun').innerText = tahun;
            detailModal.show();
        }
    </script>
@endsection
