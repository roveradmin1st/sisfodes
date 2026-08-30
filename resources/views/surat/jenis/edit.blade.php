@extends('layouts.dashboard')

@section('page-title', 'Edit Jenis Surat')

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

    /* ===== FORM ELEMENTS ===== */
    .form-label {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.85rem;
        margin-bottom: 4px;
    }
    .form-label .text-danger {
        color: #dc3545 !important;
        font-weight: 700;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 10px 16px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        background: #f8f9fa;
        font-size: 0.9rem;
        color: #1a1a1a;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
        background: white;
    }
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
    }
    .form-control.is-invalid:focus, .form-select.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
    }
    .form-control::placeholder {
        color: #adb5bd;
        font-size: 0.85rem;
    }
    .form-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 12px;
        padding-right: 40px;
    }

    /* ===== TEMPLATE BOX ===== */
    .template-box {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 16px 20px;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }
    .template-box:hover {
        border-color: #1a472a;
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

    .btn-batal {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
    }
    .btn-batal:hover {
        box-shadow: 0 6px 25px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    .btn-update {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #1a1a1a;
        box-shadow: 0 4px 20px rgba(255, 193, 7, 0.25);
    }
    .btn-update:hover {
        box-shadow: 0 8px 30px rgba(255, 193, 7, 0.35);
        color: #1a1a1a;
    }

    .btn-kembali {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
        border: none;
        padding: 8px 18px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }
    .btn-kembali:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 4px 15px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    /* ===== ALERT ===== */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 14px 20px;
        animation: slideDown 0.5s ease forwards;
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-body {
            padding: 16px;
        }
        .card-header {
            flex-direction: column;
            align-items: stretch !important;
            gap: 12px;
        }
        .card-header .btn-kembali {
            width: 100%;
            text-align: center;
        }
        .form-control, .form-select {
            padding: 8px 14px;
            font-size: 0.85rem;
        }
        .btn-action {
            padding: 8px 18px;
            font-size: 0.8rem;
            width: 100%;
            justify-content: center;
        }
        .mt-4 .btn-action {
            width: 100%;
            justify-content: center;
        }
        .mt-4 .btn-action:not(:last-child) {
            margin-bottom: 8px;
        }
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 8px !important;
        }
        .template-box {
            padding: 12px 16px;
        }
        .template-box .row {
            flex-direction: column;
            gap: 10px;
        }
        .template-box .col-md-4 {
            text-align: left !important;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .form-control, .form-select {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }
        .form-label {
            font-size: 0.75rem;
        }
        .btn-action {
            padding: 6px 14px;
            font-size: 0.7rem;
        }
        .template-box {
            padding: 10px 12px;
        }
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">
            Edit Jenis Surat
        </h5>
        <a href="{{ route('surat.jenis.index') }}" class="btn btn-kembali">
            Kembali
        </a>
    </div>
    <div class="card-body">
        
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

        <form method="POST" action="{{ route('surat.jenis.update', $jenisSurat->id_jenis_surat) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- ========================================== -->
                <!-- NAMA JENIS SURAT                          -->
                <!-- ========================================== -->
                <div class="col-12">
                    <label class="form-label">Nama Jenis Surat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_surat') is-invalid @enderror" 
                           name="nama_surat" value="{{ old('nama_surat', $jenisSurat->nama_surat) }}" placeholder="Ketik nama jenis surat" required>
                    @error('nama_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ========================================== -->
                <!-- FORMAT SURAT + UPLOAD TEMPLATE            -->
                <!-- ========================================== -->
                <div class="col-12">
                    <label class="form-label">Format Surat (Template Word .docx)</label>
                    <div class="alert alert-info py-2 mb-2" style="font-size: 0.85rem;">
                        <strong><i class="fas fa-info-circle"></i> Cara Pakai Template Otomatis:</strong><br>
                        Buat surat di Microsoft Word (.docx), lalu ketik kode variabel berikut di posisi data yang Anda inginkan:<br>
                        <code>${nama}</code>, <code>${nik}</code>, <code>${no_kk}</code>, <code>${tempat_lahir}</code>, <code>${tanggal_lahir}</code>, <code>${jenis_kelamin}</code>, <code>${agama}</code>, <code>${pekerjaan}</code>, <code>${status_perkawinan}</code>, <code>${alamat}</code>, <code>${keperluan}</code>, <code>${tanggal_cetak}</code>, <code>${nomor_surat}</code>, serta variabel khusus kematian: <code>${tanggal_meninggal}</code> dan <code>${tempat_meninggal}</code>.
                        <br>Sistem akan otomatis mengganti kode tersebut dengan data asli warga saat dicetak.
                    </div>
                    <div class="template-box">
                        @if($jenisSurat->template_surat)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $jenisSurat->template_surat) }}" target="_blank" class="btn btn-sm" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb); color: #0d47a1; border: none; border-radius: 8px; padding: 6px 16px; font-weight: 600; transition: all 0.3s ease;">
                                    Lihat Template Saat Ini
                                </a>
                            </div>
                        @else
                            <p class="text-muted mb-2">Belum ada template</p>
                        @endif
                        <div class="row g-3 align-items-center">
                            <div class="col-md-8">
                                <input type="file" class="form-control @error('template_surat') is-invalid @enderror" 
                                       name="template_surat" accept=".docx">
                                <small class="text-muted">Upload File Template Surat HANYA berformat (.docx) - Kosongkan jika tidak diubah</small>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <span class="badge" style="background: linear-gradient(135deg, #1a472a, #2d6a4f); color: white; padding: 4px 14px; border-radius: 20px; font-weight: 600; font-size: 0.7rem;">Max 2MB</span>
                            </div>
                        </div>
                        @error('template_surat')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- DESKRIPSI                                  -->
                <!-- ========================================== -->
                <div class="col-12">
                    <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              name="deskripsi" rows="4" placeholder="Masukkan deskripsi surat">{{ old('deskripsi', $jenisSurat->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ========================================== -->
                <!-- PERSYARATAN                                -->
                <!-- ========================================== -->
                <div class="col-12">
                    <label class="form-label">Persyaratan <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('syarat') is-invalid @enderror" 
                              name="syarat" rows="5" placeholder="Masukkan persyaratan surat (pisahkan dengan enter)">{{ old('syarat', $jenisSurat->syarat) }}</textarea>
                    <small class="text-muted">Pisahkan setiap persyaratan dengan baris baru (Enter)</small>
                    @error('syarat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TOMBOL AKSI                                -->
            <!-- ========================================== -->
            <div class="mt-4 d-flex gap-3 flex-wrap">
                <a href="{{ route('surat.jenis.index') }}" class="btn btn-action btn-batal">Batalkan</a>
                <button type="submit" class="btn btn-action btn-update">Update</button>
            </div>

        </form>
    </div>
</div>

@endsection