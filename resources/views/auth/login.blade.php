<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - StressAnalyzer Polindra</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #cfecf3;
            --accent-yellow: #fff9e6;
            --soft-blue: #e0f2fe;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #adc6cc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        /* Background Decor */
        .bg-decor {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: radial-gradient(circle at 10% 20%, rgba(59, 130, 246, 0.05) 0%, transparent 20%),
                        radial-gradient(circle at 90% 80%, rgba(245, 158, 11, 0.05) 0%, transparent 20%);
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }

        .brand-logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .brand-logo span {
            color: #f9b2d7;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background-color: #fcfdfe;
            transition: all 0.2s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            border-color: var(--primary-color);
        }

        .btn-login {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }

        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 30px 0;
            position: relative;
        }

        .divider::before {
            content: "Admin Research";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 0 15px;
            font-size: 11px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .footer-text {
            font-size: 12px;
            color: #94a3b8;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="bg-decor"></div>

    <div class="login-card">
        <div class="text-center mb-4">
            <div class="brand-logo">Stress<span>Analyzer</span></div>
            <p class="text-muted small">Sistem Analisis Stres Mahasiswa</p>
        </div>

        <form action="index.html" method="GET">
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Nama Pengguna</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Masukkan Nama Pengguna" required>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between">
                    <label class="form-label small fw-bold text-muted">Kata Sandi</label>
                    <a href="#" class="text-decoration-none small text-muted">Lupa Sandi?</a>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" class="form-control border-start-0" placeholder="Masukkan kata sandi" required>
                </div>
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label small text-muted" for="rememberMe">Ingat saya di perangkat ini</label>
            </div>

            <a href="/dashboard" class="btn btn-primary btn-login w-100">
                Masuk ke Dashboard <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </form>

        <div class="divider"></div>

        <div class="footer-text">
            &copy; 2026 Gigglee - NIM 2205031<br>
            Jurusan Teknik Informatika - POLINDRA
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
