@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    <!-- HERO SECTION -->
    <section class="hero text-center text-lg-start" style="background-color: #CFECF3">
        <div class="container">
            <div class="row align-items-center">

                <!-- TEXT -->
                <div class="col-lg-6">

                    <!-- Badge kecil -->
                    {{-- <span class="badge bg-light text-primary mb-3 px-3 py-2 shadow-sm">
                    Sistem Berbasis Fuzzy
                </span> --}}

                    <!-- Judul -->
                    <h1 class="fw-bold mb-3" style="font-size: 2.8rem; line-height: 1.3;">
                        Analisis Stres Mahasiswa <br>
                        <span class="text-primary">Berbasis Fuzzy</span>
                    </h1>

                    <!-- Deskripsi -->
                    <p class="text-muted mb-4" style="max-width: 500px;">
                        Sistem ini digunakan untuk menganalisis tingkat stres mahasiswa dalam proses penyusunan skripsi
                        melalui pengisian kuesioner. Hasil analisis diproses otomatis menggunakan metode
                        fuzzy Tsukamoto dan Mamdani untuk memberikan hasil yang objektif dan akurat.
                    </p>

                    <!-- Button -->
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ url('/kuesioner') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                            Isi Kuesioner
                        </a>

                        <a href="{{ url('/tentang') }}" class="btn btn-outline-secondary btn-lg px-4">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>

                </div>

                <!-- IMAGE -->
                <div class="col-lg-6 text-center mt-5 mt-lg-0 position-relative">

                    <!-- background blur effect -->
                    <div class="hero-bg"></div>

                    <img src="{{ asset('images/exploration.png') }}" alt="analysis" class="img-fluid hero-img">
                </div>

            </div>
        </div>
    </section>
    <section class="py-3 position-relative" style="background-color: #F9B2D7">
        <div class="container">

            <!-- TITLE -->
            <div class="text-center mb-3">
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

                        <div class="d-flex mb-4">
                            <div class="icon-box me-3">📊</div>
                            <div>
                                <h6 class="fw-bold mb-1">Analisis Otomatis</h6>
                                <p class="text-muted small mb-0">
                                    Data diproses langsung menggunakan logika fuzzy tanpa perhitungan manual.
                                </p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="icon-box me-3">🎯</div>
                            <div>
                                <h6 class="fw-bold mb-1">Hasil Objektif</h6>
                                <p class="text-muted small mb-0">
                                    Memberikan hasil yang terukur dan dapat dipertanggungjawabkan.
                                </p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="icon-box me-3">⚡</div>
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
            <div class="text-center mt-3">
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

@endsection
