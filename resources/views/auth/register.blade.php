@extends('layouts.public')

@section('title', 'Registrasi - Sistem Informasi Desa Sidomulyo')
{{-- @section('page-title', 'Registrasi') --}}

@section('public-content')

    <style>
        /* ===== SMOOTH SCROLL ===== */
        html {
            scroll-behavior: smooth;
        }

        /* ===== BACKGROUND ANIMATION ===== */
        .register-wrapper {
            position: relative;
            min-height: 80vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            overflow: hidden;
            padding: 40px 0;
        }

        .register-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 70% 30%, rgba(26, 71, 42, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 30% 70%, rgba(26, 71, 42, 0.03) 0%, transparent 50%);
        }

        /* ===== DECORATIVE ELEMENTS ===== */
        .register-wrapper .deco-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.05;
            pointer-events: none;
        }

        .register-wrapper .deco-circle:nth-child(1) {
            width: 350px;
            height: 350px;
            background: #1a472a;
            top: -120px;
            left: -100px;
        }

        .register-wrapper .deco-circle:nth-child(2) {
            width: 250px;
            height: 250px;
            background: #2d6a4f;
            bottom: -80px;
            right: -80px;
        }

        /* ===== REGISTER CARD ===== */
        .register-card {
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

        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1a472a, #4caf50, #1a472a);
            background-size: 200% 100%;
            animation: gradientMoveReg 3s ease-in-out infinite;
        }

        @keyframes gradientMoveReg {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .register-card:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.5);
        }

        .register-card .card-header {
            background: transparent;
            border-bottom: none;
            padding: 35px 35px 0 35px;
            position: relative;
        }

        .register-card .card-header::after {
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

        .register-card .card-body {
            padding: 30px 35px 20px 35px;
        }

        .register-card .card-footer {
            background: transparent;
            border-top: none;
            padding: 0 35px 35px 35px;
        }

        /* ===== LOGO ICON ===== */
        .register-icon {
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

        .register-card:hover .register-icon {
            transform: scale(1.05) rotate(5deg);
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

        /* ===== REGISTER BUTTON ===== */
        .btn-register {
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

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.6s ease;
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 35px rgba(26, 71, 42, 0.4);
            color: white;
        }

        .btn-register:active {
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

        .register-card:hover .divider::before,
        .register-card:hover .divider::after {
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
            animation: slideDownReg 0.5s ease forwards;
        }

        @keyframes slideDownReg {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }

        .alert-danger ul {
            padding-left: 20px;
            margin-bottom: 0;
            list-style: none;
        }

        .alert-danger ul li {
            position: relative;
            padding-left: 20px;
        }

        .alert-danger ul li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #721c24;
            font-weight: bold;
        }

        .alert .btn-close {
            padding: 12px;
        }

        .text-danger.small {
            font-size: 0.8rem;
            margin-top: 4px !important;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .text-danger.small::before {
            content: '⚠';
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 576px) {
            .register-card .card-header {
                padding: 25px 20px 0 20px;
            }

            .register-card .card-body {
                padding: 20px;
            }

            .register-card .card-footer {
                padding: 0 20px 25px 20px;
            }

            .register-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .register-card .card-header h4 {
                font-size: 1.3rem;
            }

            .form-control {
                padding: 11px 14px;
                font-size: 0.9rem;
            }

            .btn-register {
                padding: 13px;
                font-size: 0.95rem;
            }

            .register-wrapper {
                min-height: 70vh;
                padding: 20px 0;
            }

            .register-wrapper .deco-circle {
                display: none;
            }

            .alert-danger ul {
                padding-left: 0;
            }
        }

        @media (max-width: 400px) {
            .register-card .card-header {
                padding: 20px 15px 0 15px;
            }

            .register-card .card-body {
                padding: 15px;
            }

            .register-card .card-footer {
                padding: 0 15px 20px 15px;
            }

            .register-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
    </style>

    <div class="register-wrapper">
        <!-- Decorative Circles -->
        <div class="deco-circle"></div>
        <div class="deco-circle"></div>

        <div class="row justify-content-center w-100" style="position: relative; z-index: 1;">
            <div class="col-lg-6 col-md-8 col-12">

                <div class="card register-card">

                    <!-- Card Header -->
                    <div class="card-header text-center">
                        <div class="register-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h4 class="fw-bold mb-1" style="color: #1a472a;">Daftar Akun</h4>
                        <p class="text-muted small mb-0" style="font-size: 0.85rem;">Isi data berikut untuk mendaftar</p>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- NIK -->
                            <div class="mb-3">
                                <label for="nik" class="form-label">
                                    <i class="fas fa-id-card me-1" style="color: #1a472a;"></i>
                                    NIK
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                        name="nik" value="{{ old('nik') }}" placeholder="Masukkan 16 digit NIK" required
                                        maxlength="16">
                                </div>
                                @error('nik')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    <i class="fas fa-user me-1" style="color: #1a472a;"></i>
                                    Nama Lengkap
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                        name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                                </div>
                                @error('nama')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="fas fa-user-tag me-1" style="color: #1a472a;"></i>
                                    Username
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user-tag"></i>
                                    </span>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username') }}"
                                        placeholder="Masukkan username" required>
                                </div>
                                @error('username')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1" style="color: #1a472a;"></i>
                                    Password
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Masukkan password (min. 8 karakter)"
                                        required>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    <i class="fas fa-info-circle me-1"></i>Password minimal 8 karakter
                                </small>
                            </div>

                            <!-- Register Button -->
                            <button type="submit" class="btn btn-register">
                                <i class="fas fa-user-plus me-2"></i>Daftar
                            </button>

                        </form>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer text-center">

                        <div class="divider">
                            <span>atau</span>
                        </div>

                        <p class="mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="auth-link">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </p>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection