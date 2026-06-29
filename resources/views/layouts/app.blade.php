<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <!-- Custom Style -->
    <style>
        body {
            background: #CFECF3;
            font-family: 'Poppins', sans-serif;
            padding-top: 65px;
        }

        /* HERO */
.hero {
    min-height: auto;
    padding: 85px 0;
    display: flex;
    align-items: center;
}

/* Background blur di belakang gambar */
.hero-bg {
    position: absolute;
    width: 250px;
    height: 250px;
    background: #7db9ff;
    filter: blur(120px);
    opacity: 0.4;
    border-radius: 50%;
    top: 20%;
    left: 50%;
    transform: translateX(-50%);
    z-index: 0;
}

/* Gambar naik dikit + smooth */
.hero-img {
    position: relative;
    z-index: 1;
    max-height: 320px;
    transition: transform 0.3s ease;
}

.hero-img:hover {
    transform: translateY(-8px);
}

.hero p {
    line-height: 1.7;
    max-width: 520px;
}
.btn-primary {
    background: linear-gradient(135deg, #7db9ff, #5aa3f5);
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.btn-primary:hover {
    transform: translateY(-2px);
}

        .card-custom {
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* CARD */
.premium-card {
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.premium-card:hover {
    transform: translateY(-8px);
}

/* ICON BULAT */
.icon-box {
    width: 45px;
    height: 45px;
    background: #eaf4ff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* STEP */
.step-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.step-number {
    min-width: 35px;
    height: 35px;
    background: #7db9ff;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.footer-premium {
    background: #FFE3B0;
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(0,0,0,0.05);
}

.footer-link {
    text-decoration: none;
    color: #6c757d;
    transition: all 0.2s ease;
}

.footer-link:hover {
    color: #0d6efd;
    padding-left: 5px;
}

.about-img {
    max-width: 100%;
    height: auto;
    object-fit: contain;
}
.icon-box-about {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-right: 15px;
    color: #fff;
}

.bg-blue {
    background: #6ea8fe;
}

.bg-green {
    background: #63e6be;
}

.bg-purple {
    background: #b197fc;
}

.variable-item {
    align-items: flex-start;
}
    </style>
</head>

<body>

    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
