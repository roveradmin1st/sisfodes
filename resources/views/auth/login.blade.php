@extends('layouts.public')

@section('title', 'Login - Sistem Informasi Desa Sidomulyo')

@section('public-content')

    <style>
        /* ===== SMOOTH SCROLL ===== */
        html {
            scroll-behavior: smooth;
        }

        /* ===== BACKGROUND ANIMATION ===== */
        .login-wrapper {
            position: relative;
            min-height: 80vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            overflow: hidden;
            padding: 40px 0;
        }

        .login-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 50%, rgba(26, 71, 42, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(26, 71, 42, 0.03) 0%, transparent 50%);
        }

        /* ===== DECORATIVE ELEMENTS ===== */
        .login-wrapper .deco-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.05;
            pointer-events: none;
        }

        .login-wrapper .deco-circle:nth-child(1) {
            width: 300px;
            height: 300px;
            background: #1a472a;
            top: -100px;
            right: -100px;
        }

        .login-wrapper .deco-circle:nth-child(2) {
            width: 200px;
            height: 200px;
            background: #2d6a4f;
            bottom: -50px;
            left: -50px;
        }

        /* ===== LOGIN CARD ===== */
        .login-card {
            max-width: 420px;
            margin: 0 auto;
            border: none;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1a472a, #4caf50, #1a472a);
            background-size: 200% 100%;
            animation: gradientMove 3s ease-in-out infinite;
        }

        @keyframes gradientMove {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .login-card:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.5);
        }

        .login-card .card-header {
            background: transparent;
            border-bottom: none;
            padding: 35px 35px 0 35px;
            position: relative;
        }

        .login-card .card-header::after {
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

        .login-card .card-body {
            padding: 30px 35px 20px 35px;
        }

        .login-card .card-footer {
            background: transparent;
            border-top: none;
            padding: 0 35px 35px 35px;
        }

        /* ===== LOGO ICON ===== */
        .login-icon {
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

        .login-card:hover .login-icon {
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

        /* ===== LOGIN BUTTON ===== */
        .btn-login {
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

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.6s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 35px rgba(26, 71, 42, 0.4);
            color: white;
        }

        .btn-login:active {
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

        .login-card:hover .divider::before,
        .login-card:hover .divider::after {
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
            animation: slideDown 0.5s ease forwards;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }

        .alert .btn-close {
            padding: 12px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 576px) {
            .login-card .card-header {
                padding: 25px 20px 0 20px;
            }

            .login-card .card-body {
                padding: 20px;
            }

            .login-card .card-footer {
                padding: 0 20px 25px 20px;
            }

            .login-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .login-card .card-header h4 {
                font-size: 1.3rem;
            }

            .form-control {
                padding: 11px 14px;
                font-size: 0.9rem;
            }

            .btn-login {
                padding: 13px;
                font-size: 0.95rem;
            }

            .login-wrapper {
                min-height: 70vh;
                padding: 20px 0;
            }

            .login-wrapper .deco-circle {
                display: none;
            }
        }

        @media (max-width: 400px) {
            .login-card .card-header {
                padding: 20px 15px 0 15px;
            }

            .login-card .card-body {
                padding: 15px;
            }

            .login-card .card-footer {
                padding: 0 15px 20px 15px;
            }

            .login-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
    </style>

    <div class="login-wrapper">
        <!-- Decorative Circles -->
        <div class="deco-circle"></div>
        <div class="deco-circle"></div>

        <div class="row justify-content-center w-100" style="position: relative; z-index: 1;">
            <div class="col-lg-6 col-md-8 col-12">

                <div class="card login-card">

                    <!-- Card Header -->
                    <div class="card-header text-center">
                        <div class="login-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-1" style="color: #1a472a;">Login</h4>
                        <p class="text-muted small mb-0" style="font-size: 0.85rem;">Silakan login untuk mengakses sistem
                        </p>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="fas fa-user me-1" style="color: #1a472a;"></i>Username
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username') }}"
                                        placeholder="Masukkan username" autofocus required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-key me-1" style="color: #1a472a;"></i>Password
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Masukkan password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Login Button -->
                            <button type="submit" class="btn btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>

                        </form>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer text-center">

                        <div class="divider">
                            <span>atau</span>
                        </div>

                        <p class="mb-2">
                            Belum Punya Akun?
                            <a href="{{ route('register') }}" class="auth-link">
                                <i class="fas fa-user-plus me-1"></i>Registrasi
                            </a>
                        </p>
                        <p class="mb-0">
                            <a href="{{ route('password.request') }}" class="auth-link small">
                                <i class="fas fa-key me-1"></i>Lupa Password? Reset Password
                            </a>
                        </p>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection