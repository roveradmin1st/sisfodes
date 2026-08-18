<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Sidomulyo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #0d2b5e;
            --primary-light: #e8f1fd;
            --primary-gradient: linear-gradient(135deg, #0d2b5e, #1a4a7a);
            --text-dark: #1f2937;
            --text-muted: #6b7280;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            padding-top: 80px;
            background: #f8fafc;
            color: var(--text-dark);
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9998;
            width: 100%;
            border-bottom: 1px solid rgba(13, 43, 94, 0.08);
        }
        
        .navbar-custom .navbar-brand {
            color: var(--primary-dark) !important;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 0;
        }
        
        .navbar-custom .navbar-brand img {
            height: 45px;
            width: auto;
            border-radius: 6px;
        }
        
        .navbar-custom .navbar-brand .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .navbar-custom .navbar-brand .brand-text .main {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-dark);
        }
        
        .navbar-custom .nav-link {
            color: #4b5563 !important;
            font-weight: 500;
            padding: 8px 15px;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }
        
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: var(--primary-dark) !important;
            font-weight: 600;
        }
        
        .navbar-custom .btn-login {
            background: linear-gradient(135deg, #0d2b5e, #1a4a7a);
            color: #fff !important;
            padding: 8px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-left: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 43, 94, 0.2);
        }
        
        .navbar-custom .btn-login:hover {
            background: linear-gradient(135deg, #0a2148, #0d2b5e);
            box-shadow: 0 6px 20px rgba(13, 43, 94, 0.35);
            color: #fff !important;
            transform: translateY(-1px);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: linear-gradient(135deg, #0a2148, #0d2b5e);
            color: #d1d5db;
            padding: 60px 0 30px 0;
            margin-top: 60px;
        }
        
        .footer a { 
            color: rgba(255,255,255,0.7); 
            text-decoration: none; 
        }
        
        .footer a:hover { 
            color: #fff; 
        }
        
        .footer h5 { 
            color: #fff; 
            font-weight: 600; 
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .navbar-custom .navbar-brand img {
                height: 40px;
            }
            .navbar-custom .navbar-brand .brand-text .main {
                font-size: 1rem;
            }
            .navbar-custom .navbar-brand .brand-text .sub {
                font-size: 0.7rem;
            }
            .navbar-custom .btn-login {
                margin-left: 0;
                margin-top: 10px;
                display: inline-block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- ==================== NAVBAR ==================== -->
<nav class="navbar navbar-expand-lg navbar-custom" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('storage/logo-deli-serdang.png') }}" 
                 alt="Logo Deli Serdang" 
                 onerror="this.style.display='none'">
            <div class="brand-text">
                <span class="main">Desa Sidomulyo</span>
                <small class="sub text-muted" style="font-size: 0.72rem; font-weight: 500; display: block; margin-top: -2px;">Kabupaten Deli Serdang</small>
            </div>
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.profil') ? 'active' : '' }}" href="{{ route('public.profil') }}">Profil Desa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.perangkat') ? 'active' : '' }}" href="{{ route('public.perangkat') }}">Perangkat Desa</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs(['public.informasi', 'public.bantuan', 'public.apbdesa', 'public.umkm']) ? 'active' : '' }}" href="#" id="informasiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Informasi Desa
                    </a>
                    <ul class="dropdown-menu border-0 shadow" aria-labelledby="informasiDropdown">
                        <li><a class="dropdown-item" href="{{ route('public.informasi') }}">Berita</a></li>
                        <li><a class="dropdown-item" href="{{ route('public.bantuan') }}">Info Bantuan</a></li>
                        <li><a class="dropdown-item" href="{{ route('public.apbdesa') }}">Transparansi APBDes</a></li>
                        <li><a class="dropdown-item" href="{{ route('public.umkm') }}">Produk UMKM Desa</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-login" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ==================== PAGE CONTENT ==================== -->
<main style="min-height: 70vh;">
    @yield('public-content')
</main>

<!-- ==================== FOOTER ==================== -->
<footer class="footer">
    <div class="container">
        <div class="row gx-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <h4 class="text-white fw-bold mb-3">Desa Sidomulyo</h4>
                <p class="mb-4 opacity-75 pe-md-5" style="font-size: 0.9rem; line-height: 1.8;">
                    Kantor Kepala Desa Sidomulyo, Kec. Biru-Biru,<br>
                    Kab. Deli Serdang, Sumatera Utara. Melayani<br>
                    dengan hati untuk kemajuan negeri.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <h6 class="text-white text-uppercase fw-bold mb-4" style="font-size: 0.85rem; letter-spacing: 1px;">Navigasi Cepat</h6>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="#" class="opacity-75">Kontak Kami</a></li>
                    <li class="mb-3"><a href="#" class="opacity-75">Peta Situs</a></li>
                </ul>
            </div>
            
            <div class="col-md-3 col-6">
                <h6 class="text-white text-uppercase fw-bold mb-4" style="font-size: 0.85rem; letter-spacing: 1px;">Informasi</h6>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="#" class="opacity-75">Kebijakan Privasi</a></li>
                    <li class="mb-3"><a href="#" class="opacity-75">Media Sosial</a></li>
                </ul>
            </div>
        </div>
        
        <hr class="border-light opacity-10 my-4">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center opacity-50" style="font-size: 0.8rem;">
            <div>&copy; 2026 Pemerintah Desa Sidomulyo. Seluruh Hak Cipta Dilindungi.</div>
        </div>
    </div>
</footer>

<!-- ==================== SCRIPTS ==================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>