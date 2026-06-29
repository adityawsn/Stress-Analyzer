<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">StressAnalyzer</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
            aria-controls="nav" aria-expanded="false" aria-label="Buka menu navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/tentang') }}">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/kuesioner') }}">Kuesioner</a></li>
            </ul>
        </div>
    </div>
</nav>
