@extends('layouts.dashboard')

@section('page-title', 'Dashboard Penduduk')

@section('dashboard-content')

    <style>
        /* ===== SMOOTH SCROLL ===== */
        html {
            scroll-behavior: smooth;
        }

        /* ===== STATISTICS CARDS ===== */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-left: 4px solid #1a472a;
            position: relative;
            overflow: hidden;
            cursor: default;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(26, 71, 42, 0.05), transparent 70%);
            border-radius: 50%;
            transform: translate(30px, -30px);
            transition: all 0.6s ease;
        }

        .stat-card:hover::before {
            transform: translate(50px, -50px) scale(1.5);
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        }

        .stat-card .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 2px;
            background: linear-gradient(135deg, #1a472a, #2d6a4f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .stat-card .stat-label {
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0;
        }

        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.4s ease;
        }

        .stat-card:hover .icon {
            transform: scale(1.1) rotate(-5deg);
        }

        .stat-card .icon.bg-success {
            background: linear-gradient(135deg, #d4edda, #a8e0b0) !important;
            color: #1a472a;
        }

        .stat-card .icon.bg-primary {
            background: linear-gradient(135deg, #cfe2ff, #9ec5fe) !important;
            color: #0d6efd;
        }

        .stat-card .icon.bg-danger {
            background: linear-gradient(135deg, #f8d7da, #f5b8b8) !important;
            color: #dc3545;
        }

        /* ===== NOTIFICATION CARDS ===== */
        .notification-item {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            border-radius: 14px;
            padding: 16px 20px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
            cursor: default;
        }

        .notification-item::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            border-radius: 0 3px 3px 0;
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            transform: translateX(5px) translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
            border-color: rgba(0, 0, 0, 0.06);
        }

        .notification-item .badge-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .notification-item:hover .badge-icon {
            transform: scale(1.1);
        }

        .notification-item .badge-icon.bg-primary {
            background: linear-gradient(135deg, #cfe2ff, #9ec5fe) !important;
            color: #0d6efd;
        }

        .notification-item .badge-icon.bg-danger {
            background: linear-gradient(135deg, #f8d7da, #f5b8b8) !important;
            color: #dc3545;
        }

        .notification-item .badge-icon.bg-success {
            background: linear-gradient(135deg, #d4edda, #a8e0b0) !important;
            color: #1a472a;
        }

        .notification-item .stat-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.2;
        }

        .notification-item .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .notification-item .stat-status {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 12px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 2px;
        }

        .notification-item .stat-status.text-primary {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .notification-item .stat-status.text-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .notification-item .stat-status.text-success {
            background: rgba(26, 71, 42, 0.1);
            color: #1a472a;
        }

        /* ===== CARD STYLING ===== */
        .card {
            border-radius: 16px !important;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none !important;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06) !important;
        }

        .card-header {
            border-bottom: none !important;
            padding: 18px 24px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
        }

        .card-header .card-title {
            font-weight: 700;
            color: #1a472a;
            font-size: 1rem;
        }

        .card-header .card-title i {
            color: #ff9800;
        }

        .card-body {
            padding: 24px;
        }

        /* ===== BUTTON STYLING ===== */
        .btn-ajukan {
            background: linear-gradient(135deg, #1a472a, #2d6a4f);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 40px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(26, 71, 42, 0.25);
        }

        .btn-ajukan::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.6s ease;
        }

        .btn-ajukan:hover::before {
            left: 100%;
        }

        .btn-ajukan:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 10px 40px rgba(26, 71, 42, 0.35);
            color: white;
        }

        .btn-ajukan:active {
            transform: translateY(0) scale(0.97);
        }

        /* ===== ANIMATIONS ===== */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1),
                transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .stat-card .stat-number {
                font-size: 1.8rem;
            }

            .stat-card {
                padding: 18px;
            }

            .notification-item {
                padding: 14px 16px;
            }

            .btn-ajukan {
                padding: 12px 28px;
                font-size: 0.95rem;
            }

            .card-header {
                padding: 14px 18px;
            }

            .card-body {
                padding: 18px;
            }
        }

        @media (max-width: 576px) {
            .stat-card .stat-number {
                font-size: 1.5rem;
            }

            .stat-card .icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }

            .notification-item .stat-value {
                font-size: 1.1rem;
            }

            .btn-ajukan {
                padding: 10px 20px;
                font-size: 0.85rem;
                width: 100%;
            }
        }
    </style>

    <!-- ============================================================ -->
    <!-- STATISTICS CARDS                                              -->
    <!-- ============================================================ -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Data Penerima Bantuan -->
        <div class="col-md-4 animate-on-scroll" style="animation-delay: 0.1s;">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label mb-1">
                            <i class="fas fa-hand-holding-heart me-1" style="color: #1a472a;"></i>
                            Data Penerima Bantuan
                        </p>
                        <h3 class="stat-number">{{ $totalBantuan ?? 0 }}</h3>
                    </div>
                    <div class="icon bg-success">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Status Surat -->
        <div class="col-md-4 animate-on-scroll" style="animation-delay: 0.2s;">
            <div class="stat-card" style="border-left-color: #0d6efd;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label mb-1">
                            <i class="fas fa-file-alt me-1" style="color: #0d6efd;"></i>
                            Status Surat
                        </p>
                        <h3 class="stat-number"
                            style="background: linear-gradient(135deg, #0d6efd, #0a58ca); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">
                            {{ $totalPengajuan ?? 0 }}</h3>
                    </div>
                    <div class="icon bg-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Kritik & Saran -->
        <div class="col-md-4 animate-on-scroll" style="animation-delay: 0.3s;">
            <div class="stat-card" style="border-left-color: #dc3545;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label mb-1">
                            <i class="fas fa-comment me-1" style="color: #dc3545;"></i>
                            Kritik & Saran
                        </p>
                        <h3 class="stat-number"
                            style="background: linear-gradient(135deg, #dc3545, #b02a37); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">
                            {{ $kritikSaran->count() }}</h3>
                    </div>
                    <div class="icon bg-danger">
                        <i class="fas fa-comment"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- NOTIFIKASI                                                    -->
    <!-- ============================================================ -->
    <div class="row g-4 mb-4">
        <div class="col-12 animate-on-scroll" style="animation-delay: 0.4s;">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-bell me-2 text-warning"></i>Notifikasi
                        <span class="badge bg-danger rounded-pill ms-2"
                            style="background: linear-gradient(135deg, #dc3545, #b02a37);">{{ $notifikasiCount ?? 0 }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Notifikasi 1: Status Surat -->
                        <div class="col-md-4">
                            <div class="notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="badge-icon bg-primary me-3">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="stat-value">{{ $totalPengajuan ?? 0 }}</div>
                                        <div class="stat-label">Total pengajuan surat</div>
                                        <span class="stat-status text-primary">
                                            <i class="fas fa-clock me-1"></i>Status surat Anda
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notifikasi 2: Kritik & Saran -->
                        <div class="col-md-4">
                            <div class="notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="badge-icon bg-danger me-3">
                                        <i class="fas fa-comment"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="stat-value">{{ $kritikSaran->count() }}</div>
                                        <div class="stat-label">Kritik & saran</div>
                                        <span class="stat-status text-danger">
                                            <i class="fas fa-hourglass-half me-1"></i>Belum dibalas
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notifikasi 3: Data Bantuan -->
                        <div class="col-md-4">
                            <div class="notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="badge-icon bg-success me-3">
                                        <i class="fas fa-hand-holding-heart"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="stat-value">{{ $totalBantuan ?? 0 }}</div>
                                        <div class="stat-label">Data penerima bantuan</div>
                                        <span class="stat-status text-success">
                                            <i class="fas fa-check-circle me-1"></i>Telah diterima
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- AJUKAN SURAT KETERANGAN (Tombol)                             -->
    <!-- ============================================================ -->
    <div class="row g-4">
        <div class="col-12 animate-on-scroll" style="animation-delay: 0.5s;">
            <div class="card shadow-sm" style="background: linear-gradient(145deg, #f8f9fa, #ffffff);">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-pen" style="font-size: 3rem; color: #1a472a; opacity: 0.2;"></i>
                    </div>
                    <a href="{{ route('surat.permohonan.create') }}" class="btn btn-ajukan">
                        <i class="fas fa-pen me-2"></i>Ajukan Surat Keterangan
                    </a>
                    <p class="text-muted mt-3 small" style="font-size: 0.85rem;">
                        <i class="fas fa-info-circle me-1"></i>
                        Ajukan surat keterangan secara online tanpa harus datang ke kantor desa
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ===== SCROLL ANIMATION USING INTERSECTION OBSERVER =====
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.animate-on-scroll');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            elements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>

@endsection