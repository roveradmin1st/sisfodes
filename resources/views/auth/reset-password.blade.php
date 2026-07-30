@extends('layouts.public')

@section('title', 'Reset Password - Sistem Informasi Desa Sidomulyo')

@section('public-content')

    <style>
        /* ===== SMOOTH SCROLL ===== */
        html {
            scroll-behavior: smooth;
        }

        /* ===== BACKGROUND ANIMATION ===== */
        .reset-wrapper {
            position: relative;
            min-height: 80vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            overflow: hidden;
            padding: 40px 0;
        }
        .reset-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 50% 30%, rgba(26, 71, 42, 0.03) 0%, transparent 50%),
                        radial-gradient(circle at 50% 70%, rgba(26, 71, 42, 0.03) 0%, transparent 50%);
            animation: bgMoveReset 20s ease-in-out infinite;
        }
        @keyframes bgMoveReset {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -20px); }
        }

        /* ===== DECORATIVE ELEMENTS ===== */
        .reset-wrapper .deco-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.05;
            pointer-events: none;
        }
        .reset-wrapper .deco-circle:nth-child(1) {
            width: 300px;
            height: 300px;
            background: #1a472a;
            top: -100px;
            right: -50px;
            animation: floatCircleReset 16s ease-in-out infinite;
        }
        .reset-wrapper .deco-circle:nth-child(2) {
            width: 200px;
            height: 200px;
            background: #2d6a4f;
            bottom: -50px;
            left: -30px;
            animation: floatCircleReset 20s ease-in-out infinite reverse;
        }
        @keyframes floatCircleReset {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-20px, 30px) scale(1.1); }
        }

        /* ===== RESET CARD ===== */
        .reset-card {
            max-width: 420px;
            margin: 0 auto;
            border: none;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 0 0 1px rgba(255,255,255,0.5);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        .reset-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1a472a, #4caf50, #1a472a);
            background-size: 200% 100%;
            animation: gradientMoveReset 3s ease-in-out infinite;
        }
        @keyframes gradientMoveReset {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .reset-card:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 30px 80px rgba(0,0,0,0.12), 0 0 0 1px rgba(255,255,255,0.5);
        }
        .reset-card .card-header {
            background: transparent;
            border-bottom: none;
            padding: 35px 35px 0 35px;
            position: relative;
        }
        .reset-card .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #1a472a, #4caf50);
            border-radius: 10px;
        }
        .reset-card .card-body {
            padding: 30px 35px 20px 35px;
        }
        .reset-card .card-footer {
            background: transparent;
            border-top: none;
            padding: 0 35px 35px 35px;
        }

        /* ===== LOGO ICON ===== */
        .reset-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 15px auto;
            background: linear-gradient(135deg, #1a472a, #2d6a4f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            box-shadow: 0 8px 30px rgba(26, 71, 42, 0.3);
            transition: all 0.3s ease;
        }
        .reset-card:hover .reset-icon {
            transform: scale(1.05) rotate(-5deg);
            box-shadow: 0 12px 40px rgba(26, 71, 42, 0.4);
        }

        /* ===== FORM ELEMENTS ===== */
        .form-control {
            border-radius: 12px;
            padding: 13px 16px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            background: #f8f9fa;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #1a472a;
            box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.1);
            background: white;
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        }

        /* ===== INPUT GROUP ===== */
        .input-group-text {
            background: #f8f9fa;
            border-right: none;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #6c757d;
            padding: 0 16px;
            transition: all 0.3s ease;
        }
        .input-group .form-control {
            border-radius: 0 12px 12px 0;
            border-left: none;
            background: #f8f9fa;
        }
        .input-group .form-control:focus {
            border-left: none;
            background: white;
        }
        .input-group:focus-within .input-group-text {
            border-color: #1a472a;
            background: white;
            color: #1a472a;
        }
        .input-group:focus-within .form-control {
            border-color: #1a472a;
        }

        /* ===== LABEL ===== */
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #2d3748;
            margin-bottom: 6px;
        }

        /* ===== RESET BUTTON ===== */
        .btn-reset {
            background: linear-gradient(135deg, #1a472a, #2d6a4f);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        .btn-reset::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.6s ease;
        }
        .btn-reset:hover::before {
            left: 100%;
        }
        .btn-reset:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 35px rgba(26, 71, 42, 0.4);
            color: white;
        }
        .btn-reset:active {
            transform: translateY(0) scale(0.98);
        }

        /* ===== DIVIDER ===== */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .divider:not(:empty)::before {
            margin-right: 16px;
        }
        .divider:not(:empty)::after {
            margin-left: 16px;
        }
        .divider span {
            color: #adb5bd;
            font-size: 0.85rem;
            font-weight: 500;
            background: white;
            padding: 0 12px;
        }
        .reset-card:hover .divider::before,
        .reset-card:hover .divider::after {
            border-color: #1a472a;
        }

        /* ===== LINKS ===== */
        .auth-link {
            color: #1a472a;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }
        .auth-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #1a472a, #4caf50);
            transition: width 0.3s ease;
        }
        .auth-link:hover::after {
            width: 100%;
        }
        .auth-link:hover {
            color: #1a472a;
        }
        .auth-link i {
            transition: transform 0.3s ease;
        }
        .auth-link:hover i {
            transform: translateX(-3px);
        }

        /* ===== ALERT ===== */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 14px 18px;
            animation: slideDownReset 0.5s ease forwards;
        }
        @keyframes slideDownReset {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }
        .alert-info {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
        }
        .alert ul {
            padding-left: 20px;
            margin-bottom: 0;
            list-style: none;
        }
        .alert ul li {
            position: relative;
            padding-left: 20px;
        }
        .alert ul li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #721c24;
            font-weight: bold;
        }
        .alert .btn-close {
            padding: 12px;
        }
        .alert-info strong {
            display: block;
            font-size: 1rem;
        }
        .alert-info .text-muted {
            font-size: 0.8rem;
        }

        /* ===== STEP INDICATOR ===== */
        .step-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }
        .step-indicator .step {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }
        .step-indicator .step::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        .step-indicator .step.active {
            background: #1a472a;
            color: white;
            box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
        }
        .step-indicator .step.active::after {
            border-color: rgba(26, 71, 42, 0.3);
        }
        .step-indicator .step.done {
            background: #4caf50;
            color: white;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }
        .step-indicator .step.done::after {
            border-color: rgba(76, 175, 80, 0.3);
        }
        .step-indicator .step.inactive {
            background: #e9ecef;
            color: #adb5bd;
        }
        .step-indicator .line {
            width: 40px;
            height: 2px;
            background: #e9ecef;
            transition: all 0.6s ease;
            border-radius: 10px;
            position: relative;
        }
        .step-indicator .line::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0;
            border-radius: 10px;
            transition: width 0.6s ease;
        }
        .step-indicator .line.done::after {
            width: 100%;
            background: #4caf50;
        }
        .step-indicator .line.active::after {
            width: 100%;
            background: #1a472a;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 576px) {
            .reset-card .card-header {
                padding: 25px 20px 0 20px;
            }
            .reset-card .card-body {
                padding: 20px;
            }
            .reset-card .card-footer {
                padding: 0 20px 25px 20px;
            }
            .reset-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            .reset-card .card-header h4 {
                font-size: 1.3rem;
            }
            .form-control {
                padding: 11px 14px;
                font-size: 0.9rem;
            }
            .btn-reset {
                padding: 13px;
                font-size: 0.95rem;
            }
            .reset-wrapper {
                min-height: 70vh;
                padding: 20px 0;
            }
            .reset-wrapper .deco-circle {
                display: none;
            }
            .step-indicator .line {
                width: 20px;
            }
            .step-indicator .step {
                width: 30px;
                height: 30px;
                font-size: 0.7rem;
            }
            .alert-info span {
                font-size: 1.5rem !important;
                letter-spacing: 4px !important;
            }
            .alert-danger ul {
                padding-left: 0;
            }
        }

        @media (max-width: 400px) {
            .reset-card .card-header {
                padding: 20px 15px 0 15px;
            }
            .reset-card .card-body {
                padding: 15px;
            }
            .reset-card .card-footer {
                padding: 0 15px 20px 15px;
            }
            .reset-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
    </style>

    <div class="reset-wrapper">
        <!-- Decorative Circles -->
        <div class="deco-circle"></div>
        <div class="deco-circle"></div>

        <div class="row justify-content-center w-100" style="position: relative; z-index: 1;">
            <div class="col-lg-6 col-md-8 col-12">

                <div class="card reset-card">

                    <!-- Card Header -->
                    <div class="card-header text-center">
                        <div class="reset-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <h4 class="fw-bold mb-1" style="color: #1a472a;">Reset Password</h4>
                        <p class="text-muted small mb-0" style="font-size: 0.85rem;">Masukkan email untuk reset password</p>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Step Indicator -->
                        <div class="step-indicator">
                            <div class="step {{ $step == 1 ? 'active' : ($step > 1 ? 'done' : 'inactive') }}">1</div>
                            <div class="line {{ $step > 1 ? 'done' : ($step == 1 ? 'active' : '') }}"></div>
                            <div class="step {{ $step == 2 ? 'active' : ($step > 2 ? 'done' : 'inactive') }}">2</div>
                            <div class="line {{ $step > 2 ? 'done' : ($step == 2 ? 'active' : '') }}"></div>
                            <div class="step {{ $step == 3 ? 'active' : 'inactive' }}">3</div>
                        </div>

                        <!-- ========================================== -->
                        <!-- STEP 1: Masukkan Email                    -->
                        <!-- ========================================== -->
                        @if($step == 1)
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1" style="color: #1a472a;"></i>E-mail
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email"
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               placeholder="Masukkan email Anda" 
                                               required>
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-reset">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Kode
                                </button>

                            </form>
                        @endif

                        <!-- ========================================== -->
                        <!-- STEP 2: Masukkan Kode                     -->
                        <!-- ========================================== -->
                        @if($step == 2)
                            <div class="alert alert-info text-center">
                                <i class="fas fa-qrcode fa-2x d-block mb-2" style="color: #1a472a;"></i>
                                <strong>Kode Verifikasi Anda:</strong><br>
                                <span style="font-size: 2rem; font-weight: bold; letter-spacing: 8px; color: #1a472a;">
                                    {{ session('reset_token') }}
                                </span>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>Kode ini berlaku 5 menit
                                </small>
                            </div>

                            <form method="POST" action="{{ route('password.verify') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">

                                <div class="mb-3">
                                    <label for="code" class="form-label">
                                        <i class="fas fa-qrcode me-1" style="color: #1a472a;"></i>Masukkan Kode
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-qrcode"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control @error('code') is-invalid @enderror" 
                                               id="code"
                                               name="code" 
                                               placeholder="Masukkan kode verifikasi" 
                                               required>
                                    </div>
                                    @error('code')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-reset">
                                    <i class="fas fa-check-circle me-2"></i>Verifikasi
                                </button>

                            </form>

                            <div class="text-center mt-3">
                                <a href="{{ route('password.request') }}" class="btn btn-sm btn-link text-muted" style="transition: all 0.3s ease;">
                                    <i class="fas fa-redo me-1"></i>Kirim Ulang Kode
                                </a>
                            </div>
                        @endif

                        <!-- ========================================== -->
                        <!-- STEP 3: Password Baru                     -->
                        <!-- ========================================== -->
                        @if($step == 3)
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">

                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-1" style="color: #1a472a;"></i>Password Baru
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password"
                                               name="password" 
                                               placeholder="Masukkan password baru" 
                                               required>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        <i class="fas fa-info-circle me-1"></i>Password minimal 8 karakter
                                    </small>
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-check-circle me-1" style="color: #1a472a;"></i>Konfirmasi Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                        <input type="password" 
                                               class="form-control" 
                                               id="password_confirmation"
                                               name="password_confirmation" 
                                               placeholder="Konfirmasi password baru" 
                                               required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-reset">
                                    <i class="fas fa-save me-2"></i>Reset Password
                                </button>

                            </form>
                        @endif

                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer text-center">

                        <div class="divider">
                            <span>atau</span>
                        </div>

                        <p class="mb-0">
                            <a href="{{ route('login') }}" class="auth-link">
                                <i class="fas fa-sign-in-alt me-1"></i>Kembali ke Login
                            </a>
                        </p>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection