<nav id="sidebar">
    <div class="sidebar-header text-center">
        <h4 class="mb-0 fw-bold" style="color: #CFECF3;">Stress<span style="color: #F9B2D7;">Analyzer</span></h4>
        <small class="text-muted">Sistem Analisis Stres</small>
    </div>

    <div class="mt-4">
        <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <a href="{{ url('/data-mahasiswa') }}" class="nav-link {{ request()->is('data-mahasiswa*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Data Mahasiswa
        </a>

        {{-- <a href="{{ url('/pengaturan-fuzzy') }}" class="nav-link {{ request()->is('pengaturan-fuzzy') ? 'active' : '' }}">
            <i class="bi bi-calculator"></i> Pengaturan Fuzzy
        </a> --}}

        <a href="{{ url('/hasil-kuesioner') }}"
            class="nav-link {{ request()->is('hasil-kuesioner*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Hasil Kuesioner
        </a>
        <div class="px-4 mt-4 mb-2"><small class="text-uppercase text-muted fw-bold" style="font-size: 10px;">Laporan
                Penelitian</small></div>
        <a href="{{ url('/analisis-statistik') }}"
            class="nav-link {{ request()->is('analisis-statistik') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i> Analisis Statistik
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

        <a href="#" class="nav-link text-danger" onclick="confirmLogout(event)">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
    </div>
</nav>
