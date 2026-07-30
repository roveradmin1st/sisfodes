@extends('layouts.dashboard')

@section('page-title', 'Detail Data Penduduk')

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

    /* ===== PROFILE HEADER ===== */
    .profile-header {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        border-radius: 16px;
        padding: 24px 30px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.05), transparent 70%);
        border-radius: 50%;
    }
    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.03), transparent 70%);
        border-radius: 50%;
    }
    .profile-header .profile-icon {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.1);
        flex-shrink: 0;
    }
    .profile-header .profile-name {
        color: white;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .profile-header .profile-nik {
        color: rgba(255,255,255,0.7);
        font-size: 0.85rem;
    }
    .profile-header .profile-status {
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .profile-header .profile-status.tetap {
        background: rgba(76, 175, 80, 0.25);
        color: #81c784;
        border: 1px solid rgba(76, 175, 80, 0.3);
    }
    .profile-header .profile-status.sementara {
        background: rgba(255, 193, 7, 0.25);
        color: #ffd54f;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    /* ===== TABLE STYLING ===== */
    .detail-table {
        margin-bottom: 0;
    }
    .detail-table tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }
    .detail-table tr:last-child {
        border-bottom: none;
    }
    .detail-table tr:hover {
        background: linear-gradient(90deg, #f8f9fa, #ffffff);
    }
    .detail-table th {
        font-weight: 600;
        color: #495057;
        padding: 12px 16px 12px 0;
        width: 40%;
        font-size: 0.85rem;
        position: relative;
    }
    .detail-table th::after {
        content: ':';
        position: absolute;
        right: 8px;
        color: #adb5bd;
    }
    .detail-table td {
        padding: 12px 16px;
        color: #212529;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .detail-table td strong {
        color: #1a472a;
    }

    /* ===== SECTION DIVIDER ===== */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 20px 0 16px 0;
    }
    .section-divider .line {
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, #e9ecef, transparent);
    }
    .section-divider .label {
        font-weight: 600;
        color: #1a472a;
        font-size: 0.85rem;
        white-space: nowrap;
        padding: 0 8px;
    }
    .section-divider .label i {
        margin-right: 6px;
        color: #1a472a;
    }

    /* ===== BADGE STYLING ===== */
    .badge-custom {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .badge-success-custom {
        background: linear-gradient(135deg, #d4edda, #a8e0b0);
        color: #1a472a;
    }
    .badge-secondary-custom {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
    }
    .badge-warning-custom {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
    }

    /* ===== BUTTON STYLING ===== */
    .btn-action {
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-action i {
        font-size: 0.9rem;
    }
    .btn-action:hover {
        transform: translateY(-2px) scale(1.03);
    }
    .btn-action:active {
        transform: scale(0.95);
    }
    .btn-edit {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
    }
    .btn-edit:hover {
        box-shadow: 0 6px 25px rgba(133, 100, 4, 0.25);
        color: #856404;
    }
    .btn-back {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
    }
    .btn-back:hover {
        box-shadow: 0 6px 25px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
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
        .card-body {
            padding: 16px;
        }
        .profile-header {
            padding: 18px 20px;
            flex-direction: column !important;
            text-align: center;
        }
        .profile-header .profile-icon {
            margin: 0 auto 12px auto;
            width: 60px;
            height: 60px;
            font-size: 2rem;
        }
        .profile-header .profile-name {
            font-size: 1.2rem;
        }
        .profile-header .ms-3 {
            margin-left: 0 !important;
        }
        .detail-table th {
            font-size: 0.75rem;
            padding: 10px 12px 10px 0;
        }
        .detail-table td {
            font-size: 0.8rem;
            padding: 10px 12px;
        }
        .btn-action {
            padding: 8px 16px;
            font-size: 0.75rem;
        }
        .section-divider .label {
            font-size: 0.75rem;
        }
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 8px !important;
        }
        .d-flex.gap-3 .btn-action {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .profile-header {
            padding: 14px 16px;
        }
        .profile-header .profile-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }
        .profile-header .profile-name {
            font-size: 1rem;
        }
        .profile-header .profile-nik {
            font-size: 0.7rem;
        }
        .detail-table th {
            font-size: 0.65rem;
            padding: 8px 8px 8px 0;
            width: 35%;
        }
        .detail-table td {
            font-size: 0.7rem;
            padding: 8px 8px;
        }
        .detail-table th::after {
            right: 4px;
        }
        .badge-custom {
            font-size: 0.6rem;
            padding: 4px 10px;
        }
        .btn-action {
            padding: 6px 12px;
            font-size: 0.65rem;
        }
        .section-divider .label {
            font-size: 0.65rem;
        }
    }
</style>

<!-- ============================================================ -->
<!-- PROFILE HEADER                                               -->
<!-- ============================================================ -->
<div class="profile-header d-flex align-items-center animate-on-scroll" style="animation-delay: 0.1s;">
    <div class="profile-icon">
        <i class="fas fa-user-circle"></i>
    </div>
    <div class="ms-3 flex-grow-1">
        <div class="profile-name">{{ $penduduk->nama }}</div>
        <div class="profile-nik">
            <i class="fas fa-id-card me-1"></i>NIK: {{ $penduduk->nik }}
        </div>
    </div>
    <div class="text-end">
        <span class="profile-status {{ $penduduk->status_penduduk == 'tetap' ? 'tetap' : 'sementara' }}">
            <i class="fas fa-{{ $penduduk->status_penduduk == 'tetap' ? 'check-circle' : 'clock' }} me-1"></i>
            {{ ucfirst($penduduk->status_penduduk) }}
        </span>
        <br>
        <span class="badge-custom {{ $penduduk->is_kepala_keluarga ? 'badge-success-custom' : 'badge-secondary-custom' }}" style="margin-top: 4px;">
            <i class="fas fa-{{ $penduduk->is_kepala_keluarga ? 'check-circle' : 'times-circle' }} me-1"></i>
            {{ $penduduk->is_kepala_keluarga ? 'Kepala Keluarga' : 'Anggota Keluarga' }}
        </span>
    </div>
</div>

<!-- ============================================================ -->
<!-- DETAIL DATA                                                  -->
<!-- ============================================================ -->
<div class="card shadow-sm animate-on-scroll" style="animation-delay: 0.2s;">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">
            <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Lengkap
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <div class="section-divider">
                    <span class="label"><i class="fas fa-user"></i>Data Pribadi</span>
                    <span class="line"></span>
                </div>
                <table class="table table-borderless detail-table">
                    <tr>
                        <th>NIK</th>
                        <td><strong>{{ $penduduk->nik }}</strong></td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><strong>{{ $penduduk->nama }}</strong></td>
                    </tr>
                    <tr>
                        <th>No. Kartu Keluarga</th>
                        <td>{{ $penduduk->no_kk }}</td>
                    </tr>
                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td>{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>
                            <span class="badge-custom {{ $penduduk->jenis_kelamin == 'L' ? 'badge-success-custom' : 'badge-warning-custom' }}">
                                <i class="fas fa-{{ $penduduk->jenis_kelamin == 'L' ? 'mars' : 'venus' }} me-1"></i>
                                {{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Agama</th>
                        <td>{{ $penduduk->agama }}</td>
                    </tr>
                    <tr>
                        <th>Pendidikan</th>
                        <td>{{ $penduduk->pendidikan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status Perkawinan</th>
                        <td>{{ $penduduk->status_perkawinan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            
            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <div class="section-divider">
                    <span class="label"><i class="fas fa-home"></i>Data Alamat & Lainnya</span>
                    <span class="line"></span>
                </div>
                <table class="table table-borderless detail-table">
                    <tr>
                        <th>Alamat</th>
                        <td><strong>{{ $penduduk->alamat }}</strong></td>
                    </tr>
                    <tr>
                        <th>Dusun</th>
                        <td>{{ $penduduk->dusun ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>RT / RW</th>
                        <td>{{ $penduduk->rt ?? '-' }} / {{ $penduduk->rw ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>{{ $penduduk->pekerjaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kewarganegaraan</th>
                        <td>{{ $penduduk->kewarganegaraan ?? 'WNI' }}</td>
                    </tr>
                    <tr>
                        <th>Status Penduduk</th>
                        <td>
                            <span class="badge-custom {{ $penduduk->status_penduduk == 'tetap' ? 'badge-success-custom' : 'badge-warning-custom' }}">
                                <i class="fas fa-{{ $penduduk->status_penduduk == 'tetap' ? 'check-circle' : 'clock' }} me-1"></i>
                                {{ ucfirst($penduduk->status_penduduk) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Kepala Keluarga</th>
                        <td>
                            <span class="badge-custom {{ $penduduk->is_kepala_keluarga ? 'badge-success-custom' : 'badge-secondary-custom' }}">
                                <i class="fas fa-{{ $penduduk->is_kepala_keluarga ? 'check-circle' : 'times-circle' }} me-1"></i>
                                {{ $penduduk->is_kepala_keluarga ? 'Ya' : 'Tidak' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $penduduk->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $penduduk->email ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="mt-4 d-flex gap-3 flex-wrap">
            <a href="{{ route('penduduk.edit', $penduduk->id_penduduk) }}" class="btn btn-action btn-edit">
                <i class="fas fa-edit"></i>Edit Data
            </a>
            <a href="{{ route('penduduk.index') }}" class="btn btn-action btn-back">
                <i class="fas fa-arrow-left"></i>Kembali
            </a>
        </div>
    </div>
</div>

<script>
    // ==========================================
    // SCROLL ANIMATION
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
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