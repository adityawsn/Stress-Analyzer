@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <style>
        .home-page {
            overflow-x: hidden;
        }

        .home-hero {
            background-color: #CFECF3;
            padding: clamp(44px, 7vw, 85px) 0;
        }

        .home-hero-title {
            font-size: clamp(2rem, 5vw, 2.8rem);
            line-height: 1.2;
        }

        .home-hero-copy {
            max-width: 520px;
        }

        .home-hero-actions {
            gap: 0.75rem;
        }

        .home-hero-visual {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 260px;
        }

        .home-hero .hero-bg {
            width: min(56vw, 250px);
            height: min(56vw, 250px);
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .home-hero .hero-img {
            width: min(100%, 420px);
            max-height: 320px;
            object-fit: contain;
        }

        .home-info-section {
            background-color: #F9B2D7;
            padding: 48px 0;
        }

        .home-section-heading {
            max-width: 680px;
            margin: 0 auto;
        }

        .home-section-heading h2 {
            font-size: clamp(1.6rem, 4vw, 2rem);
            line-height: 1.25;
        }

        .home-page .premium-card {
            padding: clamp(1.1rem, 3vw, 1.5rem);
        }

        .home-benefit-item,
        .home-page .step-item {
            align-items: flex-start;
            gap: 0.9rem;
        }

        .home-page .icon-box,
        .home-page .step-number {
            flex: 0 0 auto;
        }

        .home-page .icon-box {
            color: #0d6efd;
            font-size: 1.15rem;
        }

        .home-cta {
            max-width: 680px;
            margin: 0 auto;
        }

        @media (max-width: 991.98px) {
            .home-hero {
                padding: 48px 0 36px;
                text-align: center;
            }

            .home-hero-copy {
                margin-left: auto;
                margin-right: auto;
            }

            .home-hero-actions {
                justify-content: center;
            }

            .home-hero-visual {
                min-height: 220px;
            }

            .home-info-section {
                padding: 40px 0;
            }

            .home-page .hero-img:hover,
            .home-page .premium-card:hover {
                transform: none;
            }
        }

        @media (max-width: 575.98px) {
            .home-hero {
                padding: 36px 0 28px;
            }

            .home-hero-actions .btn,
            .home-cta .btn {
                width: 100%;
            }

            .home-hero .hero-img {
                max-height: 220px;
            }

            .home-hero-visual {
                min-height: 190px;
            }

            .home-info-section {
                padding: 32px 0 36px;
            }

            .home-page .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .home-page .premium-card {
                border-radius: 16px;
            }

            .home-page .icon-box,
            .home-page .step-number {
                width: 40px;
                min-width: 40px;
                height: 40px;
            }
        }
    </style>

    <main class="home-page">

    <!-- HERO SECTION -->
    <section class="hero home-hero text-center text-lg-start">
        <div class="container">
            <div class="row align-items-center g-4">

                <!-- TEXT -->
                <div class="col-lg-6">

                    <!-- Badge kecil -->
                    {{-- <span class="badge bg-light text-primary mb-3 px-3 py-2 shadow-sm">
                    Sistem Berbasis Fuzzy
                </span> --}}

                    <!-- Judul -->
                    <h1 class="home-hero-title fw-bold mb-3">
                        Analisis Stres Mahasiswa <br>
                        <span class="text-primary">Berbasis Fuzzy</span>
                    </h1>

                    <!-- Deskripsi -->
                    <p class="home-hero-copy text-muted mb-4">
                        Sistem ini digunakan untuk menganalisis tingkat stres mahasiswa dalam proses penyusunan skripsi
                        melalui pengisian kuesioner. Hasil analisis diproses otomatis menggunakan metode
                        fuzzy Tsukamoto dan Mamdani untuk memberikan hasil yang objektif dan akurat.
                    </p>

                    <!-- Button -->
                    <div class="home-hero-actions d-flex flex-wrap">
                        <a href="{{ url('/kuesioner') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                            Isi Kuesioner
                        </a>

                        <a href="{{ url('/tentang') }}" class="btn btn-outline-secondary btn-lg px-4">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>

                </div>

                <!-- IMAGE -->
                <div class="col-lg-6 text-center position-relative home-hero-visual">

                    <!-- background blur effect -->
                    <div class="hero-bg"></div>

                    <img src="{{ asset('images/exploration.png') }}" alt="analysis" class="img-fluid hero-img">
                </div>

            </div>
        </div>
    </section>
    <section class="home-info-section position-relative">
        <div class="container">

            <!-- TITLE -->
            <div class="home-section-heading text-center mb-4">
                <h2 class="fw-bold">Mengapa & Bagaimana Sistem Ini Bekerja</h2>
                <p class="text-muted">
                    Sistem dirancang untuk memberikan analisis stres mahasiswa secara akurat dan mudah digunakan.
                </p>
            </div>

            <div class="row g-4">

                <!-- LEFT CARD -->
                <div class="col-lg-6">
                    <div class="premium-card h-100">

                        <h4 class="fw-bold mb-4 text-primary">Mengapa Menggunakan Sistem Ini?</h4>

                        <div class="home-benefit-item d-flex mb-4">
                            <div class="icon-box"><i class="bi bi-bar-chart-line"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Analisis Otomatis</h6>
                                <p class="text-muted small mb-0">
                                    Data diproses langsung menggunakan logika fuzzy tanpa perhitungan manual.
                                </p>
                            </div>
                        </div>

                        <div class="home-benefit-item d-flex mb-4">
                            <div class="icon-box"><i class="bi bi-bullseye"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Hasil Objektif</h6>
                                <p class="text-muted small mb-0">
                                    Memberikan hasil yang terukur dan dapat dipertanggungjawabkan.
                                </p>
                            </div>
                        </div>

                        <div class="home-benefit-item d-flex">
                            <div class="icon-box"><i class="bi bi-lightning-charge"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Cepat & Mudah</h6>
                                <p class="text-muted small mb-0">
                                    Proses cepat dengan antarmuka yang sederhana dan mudah digunakan.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT CARD -->
                <div class="col-lg-6">
                    <div class="premium-card h-100">

                        <h4 class="fw-bold mb-4 text-primary">Cara Kerja Sistem</h4>

                        <div class="step-item mb-4">
                            <span class="step-number">1</span>
                            <div>
                                <h6 class="fw-bold mb-1">Isi Kuesioner</h6>
                                <p class="text-muted small mb-0">
                                    Mahasiswa mengisi pertanyaan sesuai kondisi yang dialami.
                                </p>
                            </div>
                        </div>

                        <div class="step-item mb-4">
                            <span class="step-number">2</span>
                            <div>
                                <h6 class="fw-bold mb-1">Proses Fuzzy</h6>
                                <p class="text-muted small mb-0">
                                    Data diolah menggunakan metode Tsukamoto dan Mamdani.
                                </p>
                            </div>
                        </div>

                        <div class="step-item">
                            <span class="step-number">3</span>
                            <div>
                                <h6 class="fw-bold mb-1">Hasil Analisis</h6>
                                <p class="text-muted small mb-0">
                                    Sistem menampilkan tingkat stres secara otomatis.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- CTA -->
            <div class="home-cta text-center mt-4">
                <h4 class="fw-bold mb-3">Mulai Analisis Sekarang</h4>
                <p class="text-muted mb-4">
                    Isi kuesioner dan dapatkan hasil analisis tingkat stres Anda secara instan.
                </p>

                <a href="{{ url('/kuesioner') }}" class="btn btn-primary btn-lg px-5 shadow mb-3">
                    Mulai Kuesioner
                </a>
            </div>

        </div>
    </section>
    </main>

@endsection
