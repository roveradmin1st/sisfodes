@extends('layouts.dashboard')

@section('page-title', 'Kelola Akun')

@section('dashboard-content')

<style>
    /* ===== SMOOTH SCROLL ===== */
    html {
        scroll-behavior: smooth;
    }

    /* ===== CARD STYLING ===== */
    .card {
        border-radius: 16px !important;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.06) !important;
    }
    .card-header {
        border-bottom: none !important;
        padding: 18px 24px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
    }
    .card-header .card-title {
        font-weight: 700;
        color: #1a472a;
        font-size: 0.95rem;
    }
    .card-body {
        padding: 24px;
    }

    /* ===== SECTION TITLE ===== */
    .section-title {
        font-weight: 700;
        color: #1a472a;
        font-size: 0.95rem;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e9ecef;
    }

    /* ===== FORM ELEMENTS ===== */
    .form-label {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.85rem;
        margin-bottom: 4px;
    }

    .form-control {
        border-radius: 12px;
        padding: 10px 16px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        background: #f8f9fa;
        font-size: 0.9rem;
        color: #1a1a1a;
    }
    .form-control:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
        background: white;
    }
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
    }
    .form-control::placeholder {
        color: #adb5bd;
        font-size: 0.85rem;
    }

    /* ===== FILE INPUT ===== */
    .file-input {
        padding: 10px 16px !important;
        border-radius: 12px !important;
        border: 2px solid #e9ecef !important;
        background: #f8f9fa !important;
        transition: all 0.3s ease !important;
    }
    .file-input:focus {
        border-color: #1a472a !important;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08) !important;
        background: white !important;
    }

    /* ===== BUTTON STYLING ===== */
    .btn-action {
        padding: 10px 28px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-action:hover {
        transform: translateY(-2px) scale(1.03);
    }
    .btn-action:active {
        transform: scale(0.95);
    }

    .btn-upload {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.2);
    }
    .btn-upload:hover {
        box-shadow: 0 6px 25px rgba(26, 71, 42, 0.3);
        color: white;
    }

    .btn-hapus-foto {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }
    .btn-hapus-foto:hover {
        box-shadow: 0 4px 15px rgba(114, 28, 36, 0.2);
        color: #721c24;
    }

    .btn-update-password {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #1a1a1a;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);
    }
    .btn-update-password:hover {
        box-shadow: 0 6px 25px rgba(255, 193, 7, 0.3);
        color: #1a1a1a;
    }

    /* ===== DIVIDER ===== */
    .divider-custom {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, #e9ecef, #1a472a, #e9ecef);
        margin: 24px 0;
        opacity: 0.3;
    }

    /* ===== ALERT ===== */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 14px 20px;
        animation: slideDown 0.5s ease forwards;
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
        border-left: 4px solid #17a2b8;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .alert .btn-close {
        padding: 12px;
    }
    .alert ul {
        padding-left: 20px;
        margin-bottom: 0;
    }

    /* ===== PROFILE IMAGE ===== */
    .profile-img-container {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #1a472a;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(26, 71, 42, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }
    .profile-img-container:hover {
        border-color: #2d6a4f;
        box-shadow: 0 8px 30px rgba(26, 71, 42, 0.15);
        transform: scale(1.02);
    }
    .profile-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-img-container .placeholder-icon {
        font-size: 3.5rem;
        color: #adb5bd;
        opacity: 0.5;
    }

    /* ===== USER INFO ===== */
    .user-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .user-info .user-name {
        font-weight: 700;
        color: #1a472a;
        font-size: 1rem;
    }
    .user-info .user-email {
        color: #6c757d;
        font-size: 0.85rem;
    }
    .user-info .badge-role {
        font-size: 0.7rem;
        padding: 4px 14px;
        border-radius: 20px;
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
    }

    /* ============================================================ */
    /* RESPONSIVE MOBILE - ULTIMATE PRO MAX                        */
    /* ============================================================ */
    
    /* Tablet (≤992px) */
    @media (max-width: 992px) {
        .card-body {
            padding: 20px;
        }
        .row.align-items-center {
            flex-direction: column;
            align-items: center !important;
        }
        .row.align-items-center .col-md-4 {
            margin-bottom: 16px;
            width: 100%;
        }
        .row.align-items-center .col-md-8 {
            width: 100%;
        }
        .form-control {
            padding: 8px 14px;
            font-size: 0.85rem;
        }
        .btn-action {
            padding: 8px 20px;
            font-size: 0.8rem;
        }
        .d-flex.gap-2 {
            flex-wrap: wrap;
            justify-content: center;
        }
        .section-title {
            font-size: 0.9rem;
        }
        .profile-img-container {
            width: 110px;
            height: 110px;
        }
        .profile-img-container .placeholder-icon {
            font-size: 3rem;
        }
        .user-info .user-name {
            font-size: 0.95rem;
        }
        .alert-info {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 8px;
        }
    }

    /* Mobile L (≤768px) */
    @media (max-width: 768px) {
        .card-body {
            padding: 16px;
        }
        .card-header {
            padding: 14px 18px;
        }
        .card-header .card-title {
            font-size: 0.9rem;
        }
        .section-title {
            font-size: 0.85rem;
            margin-bottom: 12px;
        }
        .form-label {
            font-size: 0.8rem;
        }
        .form-control {
            padding: 8px 12px;
            font-size: 0.85rem;
            border-radius: 10px;
        }
        .btn-action {
            padding: 8px 18px;
            font-size: 0.8rem;
        }
        .profile-img-container {
            width: 100px;
            height: 100px;
        }
        .profile-img-container .placeholder-icon {
            font-size: 2.8rem;
        }
        .user-info .user-name {
            font-size: 0.9rem;
        }
        .user-info .user-email {
            font-size: 0.8rem;
        }
        .divider-custom {
            margin: 18px 0;
        }
        .alert-info {
            padding: 12px 16px;
        }
        .d-flex.gap-2 {
            gap: 6px !important;
        }
    }

    /* Mobile (≤576px) */
    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .card-header {
            flex-direction: column;
            align-items: stretch !important;
            gap: 10px;
            padding: 12px 14px;
        }
        .card-header .card-title {
            font-size: 0.85rem;
            text-align: center;
        }
        .section-title {
            font-size: 0.8rem;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }
        .form-label {
            font-size: 0.75rem;
        }
        .form-control {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }
        .file-input {
            padding: 6px 10px !important;
            font-size: 0.75rem !important;
        }
        .btn-action {
            padding: 6px 16px;
            font-size: 0.7rem;
            width: 100%;
            justify-content: center;
            border-radius: 8px;
        }
        .d-flex.gap-2 {
            flex-direction: column;
            gap: 6px !important;
        }
        .d-flex.gap-2 .btn-action {
            width: 100%;
        }
        .profile-img-container {
            width: 85px;
            height: 85px;
            border-width: 2px;
        }
        .profile-img-container .placeholder-icon {
            font-size: 2.2rem;
        }
        .user-info {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 4px;
            width: 100%;
        }
        .user-info .user-name {
            font-size: 0.85rem;
        }
        .user-info .user-email {
            font-size: 0.7rem;
        }
        .user-info .badge-role {
            font-size: 0.6rem;
            padding: 3px 12px;
            margin-left: 0 !important;
        }
        .alert-info {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 10px;
        }
        .alert-info .badge-role {
            margin-left: 0 !important;
        }
        .divider-custom {
            margin: 14px 0;
        }
        .alert .btn-close {
            padding: 8px;
        }
        .row.align-items-center .col-md-4 {
            margin-bottom: 12px;
        }
        .row.align-items-center .col-md-8 {
            padding: 0;
        }
        .mt-3 {
            margin-top: 8px !important;
        }
        .mb-3 {
            margin-bottom: 8px !important;
        }
    }

    /* Mobile extra kecil (≤400px) */
    @media (max-width: 400px) {
        .card-body {
            padding: 10px;
        }
        .card-header {
            padding: 10px 12px;
        }
        .card-header .card-title {
            font-size: 0.8rem;
        }
        .section-title {
            font-size: 0.7rem;
        }
        .form-label {
            font-size: 0.65rem;
        }
        .form-control {
            padding: 5px 10px;
            font-size: 0.7rem;
            border-radius: 6px;
        }
        .btn-action {
            padding: 5px 12px;
            font-size: 0.65rem;
            border-radius: 6px;
        }
        .profile-img-container {
            width: 70px;
            height: 70px;
            border-width: 2px;
        }
        .profile-img-container .placeholder-icon {
            font-size: 1.8rem;
        }
        .user-info .user-name {
            font-size: 0.8rem;
        }
        .user-info .user-email {
            font-size: 0.65rem;
        }
        .alert-info {
            padding: 8px 12px;
            font-size: 0.7rem;
        }
        .divider-custom {
            margin: 10px 0;
        }
        .mb-3 {
            margin-bottom: 6px !important;
        }
        .file-input {
            padding: 4px 8px !important;
            font-size: 0.65rem !important;
        }
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">
            Kelola Akun
        </h5>
    </div>
    <div class="card-body">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                Terjadi kesalahan:
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- ========================================== -->
        <!-- UBAH FOTO PROFIL                          -->
        <!-- ========================================== -->
        <h6 class="section-title">Ubah Foto Profil</h6>

        <!-- Foto + Upload bersampingan -->
        <div class="row align-items-center">
            <!-- Foto Profil -->
            <div class="col-md-4 text-center">
                <label class="form-label">Foto Profil</label>
                <div class="d-flex justify-content-center">
                    @if($user->foto)
                        <div class="profile-img-container">
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil">
                        </div>
                    @else
                        <div class="profile-img-container">
                            <i class="fas fa-user placeholder-icon"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form Upload -->
            <div class="col-md-8">
                <form action="{{ route('kelola-akun.update-foto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <input type="file" class="form-control file-input" name="foto" accept="image/*" required>
                        <small class="text-muted">Upload foto (JPG, PNG) max 2MB</small>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn-action btn-upload">Upload</button>
                        @if($user->foto)
                            <a href="{{ route('kelola-akun.hapus-foto') }}" 
                               class="btn-action btn-hapus-foto" 
                               onclick="return confirm('Yakin hapus foto profil?')">
                                Hapus
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- GARIS PEMBATAS (HR)                      -->
        <!-- ========================================== -->
        <hr class="divider-custom">

        <!-- ========================================== -->
        <!-- UBAH PASSWORD                             -->
        <!-- ========================================== -->
        <h6 class="section-title">Ubah Password</h6>

        <form action="{{ route('kelola-akun.update-password') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Password Lama -->
            <div class="mb-3">
                <label class="form-label">Password Lama</label>
                <input type="password" class="form-control" name="password_lama" placeholder="Masukkan password lama" required>
            </div>

            <!-- Password Baru -->
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" class="form-control" name="password_baru" placeholder="Masukkan password baru" required>
                <small class="text-muted">Password minimal 8 karakter</small>
            </div>

            <!-- Konfirmasi Password Baru -->
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" name="password_baru_confirmation" placeholder="Konfirmasi password baru" required>
            </div>

            <button type="submit" class="btn-action btn-update-password">Update Password</button>
        </form>

        <!-- ========================================== -->
        <!-- INFORMASI USER                           -->
        <!-- ========================================== -->
        <hr class="divider-custom">

        <div class="alert alert-info">
            <div class="user-info">
                <div>
                    <span class="user-name">{{ $user->nama }}</span>
                    <span class="badge-role ms-2">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                </div>
                <div>
                    <span class="user-email">{{ $user->email ?? '-' }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection