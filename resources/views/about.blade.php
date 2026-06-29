@extends('layouts.app')

@section('title', 'Tentang')

@section('content')
    <style>
        .about-page {
            overflow-x: hidden;
        }

        .about-page h1,
        .about-page h2 {
            line-height: 1.25;
        }

        .about-page h1 {
            font-size: clamp(2rem, 5vw, 2.75rem);
        }

        .about-page h2 {
            font-size: clamp(1.6rem, 4vw, 2.25rem);
        }

        .about-hero,
        .about-workflow {
            padding: clamp(2.25rem, 5vw, 3.5rem) 0;
        }

        .about-detail-section {
            background-color: #F9B2D7;
            padding: clamp(2rem, 5vw, 3rem) 0;
        }

        .about-copy {
            line-height: 1.75;
        }

        .about-visual {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 230px;
        }

        .about-page .hero-img {
            width: min(100%, 300px);
            max-height: 300px;
            object-fit: contain;
        }

        .about-workflow .hero-img {
            width: min(100%, 340px);
        }

        .about-page .premium-card,
        .about-info-card {
            border-radius: 16px;
        }

        .about-page .premium-card {
            padding: clamp(1.1rem, 3vw, 1.5rem);
        }

        .about-feature-list li:not(:last-child) {
            margin-bottom: 0.95rem;
        }

        .about-info-card {
            padding: clamp(1.1rem, 3vw, 1.5rem);
        }

        .about-variable-item {
            align-items: flex-start;
            gap: 0.9rem;
        }

        .about-page .icon-box-about {
            flex: 0 0 auto;
            margin-right: 0;
        }

        .about-check-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.45rem;
            line-height: 1.55;
        }

        .about-check-list i {
            flex: 0 0 auto;
            margin-top: 0.12rem;
        }

        @media (max-width: 991.98px) {
            .about-hero,
            .about-workflow {
                padding: 2.25rem 0;
                text-align: center;
            }

            .about-copy {
                max-width: 720px;
                margin-left: auto;
                margin-right: auto;
            }

            .about-visual {
                min-height: 210px;
            }

            .about-page .hero-img:hover,
            .about-page .premium-card:hover {
                transform: none;
            }
        }

        @media (max-width: 575.98px) {
            .about-hero,
            .about-workflow {
                padding: 1.75rem 0;
            }

            .about-detail-section {
                padding: 1.75rem 0 2rem;
            }

            .about-page .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .about-visual {
                min-height: 170px;
            }

            .about-page .hero-img {
                max-height: 190px;
            }

            .about-page .premium-card,
            .about-info-card {
                border-radius: 14px;
            }

            .about-page .icon-box-about {
                width: 42px;
                height: 42px;
                font-size: 18px;
            }
        }
    </style>

    <main class="about-page">

    <section class="about-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-3 position-relative hero-bg-about about-visual">
                    <img src="{{ asset('images/stres.png') }}" alt="stres" class="img-fluid hero-img">
                    {{-- <div class="about-bg"></div> --}}
                </div>
                <div class="col-lg-5">
                    <h1 class="fw-bold mb-3">Apa Itu <span class="text-primary">StressAnalyzer?</span></h1>
                    <p class="about-copy text-muted mb-2">
                        StressAnalyzer merupakan sistem analisis yang dikembangkan untuk membantu mahasiswa dalam memahami
                        kondisi stres yang dialami selama proses penyusunan skripsi. Proses ini seringkali menjadi tahap
                        yang
                        menantang karena melibatkan berbagai tekanan akademik, seperti revisi berulang, kesulitan bimbingan,
                        serta tuntutan penyelesaian tepat waktu.
                    </p>
                    <p class="about-copy text-muted mb-2">
                        Kondisi tersebut dapat memicu stres yang berdampak pada konsentrasi, motivasi belajar, dan kesehatan
                        mental.
                        Oleh karena itu, diperlukan suatu sistem yang mampu memberikan gambaran tingkat stres secara
                        terstruktur
                        dan mudah dipahami.
                    </p>
                    {{-- <p class="text-muted">
                        Tujuan kami adalah memberikan tools yang mudah digunakan namun akurat untuk membantu institusi
                        pendidikan dalam memahami dan mengatasi masalah stres mahasiswa.
                    </p> --}}
                </div>
                <div class="col-lg-4">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-star me-2"></i>Fitur Utama</h5>
                        <ul class="about-feature-list list-unstyled mb-0">
                            <li>
                                <strong>✓ Kuesioner Terstruktur</strong>
                                <p class="text-muted small mb-0">Pertanyaan yang disusun berdasarkan indikator penelitian
                                </p>
                            </li>
                            <li>
                                <strong>✓ Analisis Fuzzy Logic</strong>
                                <p class="text-muted small mb-0">Pengolahan data menggunakan metode Tsukamoto & Mamdani</p>
                            </li>
                            <li>
                                <strong>✓ Hasil Instan</strong>
                                <p class="text-muted small mb-0">Dapatkan hasil analisis tingkat stres secara real-time</p>
                            </li>
                            <li>
                                <strong>✓ User-Friendly</strong>
                                <p class="text-muted small mb-0">Antarmuka yang sederhana dan mudah digunakan</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="about-workflow">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-3">Bagaimana<span class="text-primary"> Sistem Ini Bekerja?</span></h2>
                    <p class="about-copy text-muted mb-2">
                        Sistem StressAnalyzer bekerja dengan mengolah data yang diperoleh dari kuesioner yang diisi oleh
                        pengguna. Pertanyaan dalam kuesioner dirancang berdasarkan dua variabel utama, yaitu tekanan dalam
                        penyusunan skripsi dan manajemen waktu.
                    </p>
                    <p class="about-copy text-muted mb-2">
                        Setelah data dikumpulkan, sistem akan melakukan proses analisis menggunakan tahapan logika fuzzy,
                        yaitu fuzzifikasi, inferensi, dan defuzzifikasi. Pada tahap ini, metode Tsukamoto menghasilkan nilai
                        output yang bersifat tegas (crisp), sedangkan metode Mamdani menghasilkan output melalui proses
                        agregasi dan perhitungan titik pusat (centroid).
                    </p>
                    <p class="about-copy text-muted mb-0">
                        Hasil akhir dari proses ini berupa tingkat stres mahasiswa yang dikategorikan menjadi tiga tingkat,
                        yaitu stres rendah, sedang, dan tinggi.
                    </p>
                </div>
                <div class="col-lg-4 text-center position-relative about-visual">
                    <div class="hero-bg-about"></div>
                    <img src="{{ asset('images/content-management-system.png') }}" alt="content-management-system" class="img-fluid hero-img">
                </div>
            </div>
        </div>
    </section>
    <section class="about-detail-section">
        <div class="container">
            <div class="row g-4 align-items-stretch">

                <!-- Variabel -->
                <div class="col-md-4">
                    <div class="about-info-card shadow-sm bg-white h-100 d-flex flex-column">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-graph-up me-2"></i>Variabel yang Digunakan
                        </h5>

                        <!-- Item 1 -->
                        <div class="about-variable-item d-flex mb-3 variable-item">
                            <div class="icon-box-about bg-blue">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                            <div>
                                <p class="fw-semibold mb-1">1. Tekanan Penyusunan Skripsi</p>
                                <ul class="about-check-list text-muted small mb-0 list-unstyled">
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Kesulitan menentukan judul</li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Kesulitan bimbingan dengan
                                        dosen</li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Beban revisi</li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Tuntutan kelulusan tepat waktu
                                    </li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Kecemasan terhadap hasil
                                        skripsi</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="about-variable-item d-flex mb-3 variable-item">
                            <div class="icon-box-about bg-green">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <p class="fw-semibold mb-1">2. Manajemen Waktu</p>
                                <ul class="about-check-list text-muted small mb-0 list-unstyled">
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Perencanaan jadwal</li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Kedisiplinan mengerjakan
                                        skripsi</li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Kemampuan menentukan prioritas
                                    </li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Konsistensi belajar</li>
                                    <li><i class="bi bi-check-circle-fill text-success"></i> Pengendalian penundaan</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="about-variable-item d-flex variable-item">
                            <div class="icon-box-about bg-purple">
                                <i class="bi bi-bar-chart-line"></i>
                            </div>
                            <div>
                                <p class="fw-semibold mb-1">3. Output</p>
                                <p class="text-muted small mb-0">
                                    Tingkat stres: <strong>Rendah, Sedang, atau Tinggi</strong>
                                </p>
                            </div>
                        </div>

                        <p class="text-muted small mt-3 mb-0">
                            Sumber: Indikator Penelitian
                        </p>

                    </div>
                </div>

                <!-- Tujuan -->
                <div class="col-md-8">
                    <div class="row g-4">

                        <!-- Tujuan -->
                        <div class="col-md-6">
                            <div class="about-info-card shadow-sm bg-white h-100 d-flex flex-column">
                                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-bullseye me-2"></i>Tujuan</h5>
                                <p class="text-muted small mb-2">
                                    Sistem ini bertujuan untuk menganalisis tingkat stres mahasiswa
                                    dalam proses penyusunan skripsi menggunakan metode fuzzy
                                    Tsukamoto dan Mamdani, serta membandingkan hasil dari kedua
                                    metode tersebut untuk memperoleh hasil yang lebih representatif.
                                </p>
                                <p class="text-muted small">
                                    Analisis ini diharapkan dapat memberikan gambaran kondisi mahasiswa secara
                                    lebih objektif dan terukur.
                                </p>
                            </div>
                        </div>

                        <!-- Manfaat -->
                        <div class="col-md-6">
                            <div class="about-info-card shadow-sm bg-white h-100 d-flex flex-column">
                                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-lightbulb me-2"></i>Manfaat</h5>
                                <p class="text-muted small mb-2">
                                    Sistem ini diharapkan dapat membantu mahasiswa memahami kondisi
                                    stres yang dialami, meningkatkan kesadaran dalam mengelola waktu
                                    dan tekanan, serta menjadi bahan evaluasi bagi pihak akademik.
                                </p>
                                <p class="text-muted small">
                                    Hasil analisis juga dapat digunakan sebagai dasar pengambilan keputusan yang
                                    lebih baik dalam proses akademik.
                                </p>
                            </div>
                        </div>

                        <!-- Dasar Penelitian -->
                        <div class="col-12">
                            <div class="about-info-card shadow-sm bg-white h-100 d-flex flex-column">
                                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-journal me-2"></i>Dasar Penelitian
                                </h5>
                                <p class="text-muted small mb-2">
                                    Sistem ini dikembangkan berdasarkan penelitian mengenai analisis tingkat stres
                                    mahasiswa dalam proses penyusunan skripsi yang dipengaruhi oleh tekanan penyusunan skripsi
                                    dan manajemen waktu, menggunakan metode logika fuzzy Tsukamoto dan Mamdani.
                                </p>
                                <p class="text-muted small mb-0">
                                    Pendekatan ini digunakan karena mampu mengolah data yang bersifat subjektif
                                    menjadi hasil yang lebih objektif dan terukur, serta memungkinkan perbandingan
                                    hasil untuk memperoleh analisis yang lebih representatif.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </section>
    </main>
@endsection
