<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon Logo -->
    <link rel="icon" type="image/png" href="{{ asset('storage/logo-deli-serdang.png') }}">
    {{-- <link rel="apple-touch-icon" href="{{ asset('storage/logo-deli-serdang.png') }}"> --}}
    
    <title>@yield('title', 'Sistem Informasi Desa Sidomulyo')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* ===== LOADING PAGE STYLES ===== */
        #loadingScreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        #loadingScreen.hide {
            opacity: 0;
            visibility: hidden;
        }

        .loading-kaur {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        }

        .loading-kaur .loader-logo {
            background: linear-gradient(135deg, #1a472a, #2d6a4f);
            box-shadow: 0 10px 50px rgba(26, 71, 42, 0.4);
        }

        .loading-kaur .loader-logo::after {
            border-color: rgba(76, 175, 80, 0.3);
        }

        .loading-kaur .spinner-dot {
            background: #4caf50;
        }

        .loading-kaur .spinner-dot:nth-child(2) {
            background: #66bb6a;
        }

        .loading-kaur .spinner-dot:nth-child(3) {
            background: #81c784;
        }

        .loading-kaur .spinner-dot:nth-child(4) {
            background: #a5d6a7;
        }

        .loading-kaur .spinner-dot:nth-child(5) {
            background: #c8e6c9;
        }

        .loading-kades {
            background: linear-gradient(135deg, #0d1b2a, #1b3a5c, #1e5631);
        }

        .loading-kades .loader-logo {
            background: linear-gradient(135deg, #0d47a1, #1976d2);
            box-shadow: 0 10px 50px rgba(13, 71, 161, 0.4);
        }

        .loading-kades .loader-logo::after {
            border-color: rgba(33, 150, 243, 0.3);
        }

        .loading-kades .spinner-dot {
            background: #2196f3;
        }

        .loading-kades .spinner-dot:nth-child(2) {
            background: #42a5f5;
        }

        .loading-kades .spinner-dot:nth-child(3) {
            background: #64b5f6;
        }

        .loading-kades .spinner-dot:nth-child(4) {
            background: #90caf9;
        }

        .loading-kades .spinner-dot:nth-child(5) {
            background: #bbdefb;
        }

        .loading-penduduk {
            background: linear-gradient(135deg, #1a0e0e, #3d1f0e, #5d2e0e);
        }

        .loading-penduduk .loader-logo {
            background: linear-gradient(135deg, #e65100, #ff9800);
            box-shadow: 0 10px 50px rgba(230, 81, 0, 0.4);
        }

        .loading-penduduk .loader-logo::after {
            border-color: rgba(255, 152, 0, 0.3);
        }

        .loading-penduduk .spinner-dot {
            background: #ff9800;
        }

        .loading-penduduk .spinner-dot:nth-child(2) {
            background: #ffa726;
        }

        .loading-penduduk .spinner-dot:nth-child(3) {
            background: #ffb74d;
        }

        .loading-penduduk .spinner-dot:nth-child(4) {
            background: #ffcc80;
        }

        .loading-penduduk .spinner-dot:nth-child(5) {
            background: #ffe0b2;
        }

        .loader-container {
            text-align: center;
            position: relative;
            padding: 20px;
        }

        .loader-logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 25px auto;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: white;
            animation: logoPulse 2s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }

        .loader-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .loader-logo::after {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            border: 3px solid;
            animation: ringSpin 3s linear infinite;
            pointer-events: none;
        }

        @keyframes logoPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes ringSpin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loader-title {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .loader-subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            font-weight: 300;
            margin-bottom: 30px;
        }

        .role-badge {
            display: inline-block;
            padding: 8px 24px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        .role-badge.show {
            opacity: 1;
        }

        .role-badge i {
            margin-right: 8px;
        }

        .role-badge-kaur {
            background: rgba(76, 175, 80, 0.2);
            color: #81c784;
            border-color: rgba(76, 175, 80, 0.3);
        }

        .role-badge-kades {
            background: rgba(33, 150, 243, 0.2);
            color: #64b5f6;
            border-color: rgba(33, 150, 243, 0.3);
        }

        .role-badge-penduduk {
            background: rgba(255, 152, 0, 0.2);
            color: #ffb74d;
            border-color: rgba(255, 152, 0, 0.3);
        }

        .welcome-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            font-weight: 300;
            margin-bottom: 25px;
            animation: fadeInUp 0.6s ease forwards 0.2s;
            opacity: 0;
        }

        .welcome-text strong {
            font-weight: 600;
            color: white;
        }

        .spinner-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .spinner-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            animation: dotBounce 1.4s ease-in-out infinite both;
        }

        .spinner-dot:nth-child(1) {
            animation-delay: -0.32s;
        }

        .spinner-dot:nth-child(2) {
            animation-delay: -0.16s;
        }

        .spinner-dot:nth-child(3) {
            animation-delay: 0s;
        }

        .spinner-dot:nth-child(4) {
            animation-delay: 0.16s;
        }

        .spinner-dot:nth-child(5) {
            animation-delay: 0.32s;
        }

        @keyframes dotBounce {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }

        .progress-container {
            width: 280px;
            margin: 0 auto 15px auto;
            position: relative;
        }

        .progress-track {
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-custom {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #1a472a, #4caf50, #1a472a);
            background-size: 200% 100%;
            border-radius: 10px;
            transition: width 0.3s ease;
            animation: shimmerProgress 2s linear infinite;
        }

        .loading-kades .progress-bar-custom {
            background: linear-gradient(90deg, #0d47a1, #42a5f5, #0d47a1);
            background-size: 200% 100%;
        }

        .loading-penduduk .progress-bar-custom {
            background: linear-gradient(90deg, #e65100, #ffa726, #e65100);
            background-size: 200% 100%;
        }

        @keyframes shimmerProgress {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .progress-text {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            font-weight: 300;
            margin-top: 8px;
            display: block;
        }

        /* ===== PARTICLES ===== */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            animation: floatParticle 15s linear infinite;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }

            10% {
                opacity: 0.5;
            }

            90% {
                opacity: 0.5;
            }

            100% {
                transform: translateY(-100vh) scale(1);
                opacity: 0;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================================ */
        /* LAYOUT UTAMA                                                */
        /* ============================================================ */
        body {
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            height: 100vh;
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(0);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 10px;
            margin: 4px 12px;
            transition: all 0.25s ease;
            font-size: 14px;
            text-decoration: none;
            display: block;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        /* ===== MAIN CONTENT WRAPPER ===== */
        .main-wrapper {
            margin-left: 280px;
            transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            background: #f8f9fa;
        }

        .main-content {
            padding: 24px;
            width: 100%;
            overflow-x: hidden;
        }

        /* ===== MOBILE NAVBAR ===== */
        .mobile-navbar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1020;
            background: linear-gradient(135deg, #1a472a, #2d6a4f);
            padding: 10px 14px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
            align-items: center;
            justify-content: space-between;
            min-height: 56px;
        }

        .mobile-navbar .toggle-btn {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.3rem;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .mobile-navbar .toggle-btn:active {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(0.9);
        }

        .mobile-navbar .brand-center {
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            text-align: center;
            flex: 1;
            padding: 0 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .mobile-navbar .brand-center img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .mobile-navbar .close-btn {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.3rem;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .mobile-navbar .close-btn.visible {
            opacity: 1;
            visibility: visible;
            pointer-events: all;
        }

        .mobile-navbar .close-btn:active {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(0.9);
        }

        /* ============================================================ */
        /* RESPONSIVE ≤992px                                           */
        /* ============================================================ */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
                width: 280px;
                top: 56px;
                height: calc(100vh - 56px);
                height: calc(100dvh - 56px);
                z-index: 1010;
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 30px rgba(0, 0, 0, 0.2);
            }

            .mobile-navbar {
                display: flex;
            }

            .main-wrapper {
                margin-left: 0 !important;
                padding-top: 56px;
            }

            .main-content {
                padding: 16px;
            }

            .loader-logo {
                width: 70px;
                height: 70px;
                font-size: 2.5rem;
            }

            .loader-title {
                font-size: 1.2rem;
            }

            .progress-container {
                width: 200px;
            }
        }

        /* ============================================================ */
        /* RESPONSIVE ≤576px                                           */
        /* ============================================================ */
        @media (max-width: 576px) {
            .sidebar {
                width: 280px;
                top: 50px;
                height: calc(100vh - 50px);
                height: calc(100dvh - 50px);
            }

            .mobile-navbar {
                padding: 8px 10px;
                min-height: 50px;
            }

            .mobile-navbar .brand-center {
                font-size: 0.85rem;
            }

            .mobile-navbar .brand-center img {
                width: 24px;
                height: 24px;
            }

            .mobile-navbar .toggle-btn,
            .mobile-navbar .close-btn {
                width: 36px;
                height: 36px;
                font-size: 1.1rem;
            }

            .main-wrapper {
                padding-top: 50px;
            }

            .main-content {
                padding: 12px;
            }

            .sidebar .nav-link {
                font-size: 13px;
                padding: 10px 16px;
                margin: 3px 8px;
            }

            .loader-logo {
                width: 60px;
                height: 60px;
                font-size: 2rem;
            }

            .loader-title {
                font-size: 1rem;
            }

            .loader-subtitle {
                font-size: 0.75rem;
            }

            .progress-container {
                width: 160px;
            }
        }

        /* ===== STAT CARD ===== */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
            border-left: 4px solid #1a472a;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .btn-primary-custom {
            background: #1a472a;
            border-color: #1a472a;
        }

        .btn-primary-custom:hover {
            background: #2d6a4f;
            border-color: #2d6a4f;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: #1a472a;
            color: white;
            font-weight: 500;
            padding: 12px 16px;
        }

        .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
        }

        .badge-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .badge-diproses {
            background: #cce5ff;
            color: #004085;
        }

        .badge-selesai {
            background: #d4edda;
            color: #155724;
        }

        .badge-ditolak {
            background: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .stat-card {
                padding: 16px;
            }

            .stat-card .icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }

            .table thead th {
                font-size: 0.7rem;
                padding: 8px 10px;
            }

            .table tbody td {
                font-size: 0.75rem;
                padding: 8px 10px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- ============================================================ -->
    <!-- MOBILE NAVBAR (≤992px)                                       -->
    <!-- ============================================================ -->
    @php
        $userRole = Auth::check() ? Auth::user()->role : 'guest';
        $userName = Auth::check() ? Auth::user()->nama : '';

        $roleConfig = [
            'kaur_umum' => [
                'class' => 'loading-kaur',
                'icon' => 'fa-user-tie',
                'badge_class' => 'role-badge-kaur',
                'badge_text' => 'Kaur Umum',
                'welcome' => 'Selamat Datang,',
                'title' => 'Dashboard Kaur Umum',
                'subtitle' => 'Kelola Data Desa & Administrasi'
            ],
            'kepala_desa' => [
                'class' => 'loading-kades',
                'icon' => 'fa-user-cog',
                'badge_class' => 'role-badge-kades',
                'badge_text' => 'Kepala Desa',
                'welcome' => 'Selamat Datang,',
                'title' => 'Dashboard Kepala Desa',
                'subtitle' => 'Kelola & Pantau Seluruh Data Desa'
            ],
            'penduduk' => [
                'class' => 'loading-penduduk',
                'icon' => 'fa-user',
                'badge_class' => 'role-badge-penduduk',
                'badge_text' => 'Penduduk',
                'welcome' => 'Selamat Datang,',
                'title' => 'Dashboard Penduduk',
                'subtitle' => 'Akses Layanan & Informasi Desa'
            ]
        ];
        $config = $roleConfig[$userRole] ?? $roleConfig['penduduk'];
    @endphp

    <div class="mobile-navbar" id="mobileNavbar">
        <!-- Toggle (Kiri) -->
        <button class="toggle-btn" id="mobileToggleBtn" aria-label="Buka Menu">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Logo + Nama Desa (Tengah) -->
        <div class="brand-center">
            <img src="{{ asset('storage/logo-deli-serdang.png') }}" alt="Logo Desa Sidomulyo">
            Desa Sidomulyo
        </div>

        <!-- Close (Kanan) -->
        <button class="close-btn" id="mobileCloseBtn" aria-label="Tutup Menu">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- ============================================================ -->
    <!-- LOADING SCREEN                                              -->
    <!-- ============================================================ -->
    <div id="loadingScreen" class="{{ $config['class'] }}">
        <div class="particles" id="particles"></div>
        <div class="loader-container">
            <div class="role-badge {{ $config['badge_class'] }} show">
                {{ $config['badge_text'] }}
            </div>
            <div class="welcome-text">
                {{ $config['welcome'] }} <strong>{{ $userName ?: 'Pengguna' }}</strong>
            </div>
            <div class="loader-logo">
                <img src="{{ asset('storage/logo-deli-serdang.png') }}" alt="Logo Desa Sidomulyo">
            </div>
            <h2 class="loader-title">{{ $config['title'] }}</h2>
            <p class="loader-subtitle">{{ $config['subtitle'] }}</p>
            <div class="spinner-container">
                <div class="spinner-dot"></div>
                <div class="spinner-dot"></div>
                <div class="spinner-dot"></div>
                <div class="spinner-dot"></div>
                <div class="spinner-dot"></div>
            </div>
            <div class="progress-container">
                <div class="progress-track">
                    <div class="progress-bar-custom" id="progressBar"></div>
                </div>
                <span class="progress-text" id="progressText">Memuat 0%</span>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- WRAPPER UTAMA (Sidebar + Content)                            -->
    <!-- ============================================================ -->
    <div class="main-wrapper" id="mainWrapper">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ==========================================
            // SIDEBAR TOGGLE
            // ==========================================
            const sidebar = document.querySelector('.sidebar');
            const mainWrapper = document.getElementById('mainWrapper');
            const mobileToggleBtn = document.getElementById('mobileToggleBtn');
            const mobileCloseBtn = document.getElementById('mobileCloseBtn');
            let isSidebarOpen = false;

            function openSidebar() {
                if (!sidebar || window.innerWidth > 992) return;
                isSidebarOpen = true;
                sidebar.classList.add('open');
                if (mobileToggleBtn) mobileToggleBtn.style.display = 'none';
                if (mobileCloseBtn) mobileCloseBtn.classList.add('visible');
            }

            function closeSidebar() {
                if (!sidebar || window.innerWidth > 992) return;
                isSidebarOpen = false;
                sidebar.classList.remove('open');
                if (mobileToggleBtn) mobileToggleBtn.style.display = 'flex';
                if (mobileCloseBtn) mobileCloseBtn.classList.remove('visible');
            }

            if (mobileToggleBtn) {
                mobileToggleBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    if (isSidebarOpen) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            }

            if (mobileCloseBtn) {
                mobileCloseBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    closeSidebar();
                });
            }

            if (mainWrapper) {
                mainWrapper.addEventListener('click', function (e) {
                    if (window.innerWidth <= 992 && isSidebarOpen) {
                        if (sidebar && !sidebar.contains(e.target)) {
                            closeSidebar();
                        }
                    }
                });
            }

            if (sidebar) {
                const navLinks = sidebar.querySelectorAll('.nav-link[href]:not(#btnLogout)');
                navLinks.forEach(link => {
                    link.addEventListener('click', function () {
                        if (window.innerWidth <= 992 && isSidebarOpen) {
                            setTimeout(() => closeSidebar(), 150);
                        }
                    });
                });
            }

            window.addEventListener('resize', function () {
                if (window.innerWidth > 992) {
                    closeSidebar();
                    if (sidebar) sidebar.classList.remove('open');
                    if (mainWrapper) mainWrapper.style.marginLeft = '';
                }
            });

            // ==========================================
            // ==========================================
            // INSTANT LOADING SCREEN HIDE
            // ==========================================
            const loadingScreen = document.getElementById('loadingScreen');
            if (loadingScreen) {
                loadingScreen.classList.add('hide');
            }
            if (typeof pageReady === 'function') pageReady();

            // ==========================================
            // LOGOUT
            // ==========================================
            const btnLogout = document.getElementById('btnLogout');
            const logoutForm = document.getElementById('logoutForm');
            if (btnLogout && logoutForm) {
                btnLogout.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Konfirmasi Logout',
                        html: `<div style="text-align: center;"><p style="font-size: 1.1rem; margin-bottom: 15px; color: #333;">Apakah Anda Yakin Ingin Logout?</p></div>`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Logout',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        background: 'white',
                        backdrop: 'rgba(0,0,0,0.5)',
                        customClass: {
                            popup: 'rounded-4',
                            title: 'fw-bold text-dark fs-4',
                            confirmButton: 'btn btn-danger px-4 py-2',
                            cancelButton: 'btn btn-secondary px-4 py-2',
                            htmlContainer: 'text-center'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Logout!',
                                text: 'Anda telah berhasil keluar dari sistem.',
                                timer: 1500,
                                showConfirmButton: false,
                                customClass: { popup: 'rounded-4', title: 'fw-bold text-success' }
                            }).then(() => logoutForm.submit());
                        }
                    });
                });
            }
        });
    </script>

    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", timer: 3000, showConfirmButton: false });
        </script>
    @endif
    @stack('scripts')
</body>

</html>