@extends('layouts.dashboard')

@section('page-title', 'Detail Pengajuan Surat')

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
        font-size: 0.9rem;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e9ecef;
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
        padding: 10px 16px 10px 0;
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
        padding: 10px 16px;
        color: #212529;
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* ===== BADGE STATUS ===== */
    .badge-status {
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-menunggu {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
    }
    .badge-diproses {
        background: linear-gradient(135deg, #cfe2ff, #9ec5fe);
        color: #0d6efd;
    }
    .badge-selesai {
        background: linear-gradient(135deg, #d4edda, #a8e0b0);
        color: #1a472a;
    }
    .badge-ditolak {
        background: linear-gradient(135deg, #f8d7da, #f5b8b8);
        color: #dc3545;
    }

    /* ===== BUTTON STYLING ===== */
    .btn-action {
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-action:hover {
        transform: translateY(-2px) scale(1.03);
    }
    .btn-action:active {
        transform: scale(0.95);
    }

    .btn-dokumen {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #0d47a1;
    }
    .btn-dokumen:hover {
        box-shadow: 0 4px 15px rgba(13, 71, 161, 0.2);
        color: #0d47a1;
    }

    .btn-surat {
        background: linear-gradient(135deg, #d4edda, #a8e0b0);
        color: #1a472a;
    }
    .btn-surat:hover {
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.2);
        color: #1a472a;
    }

    .btn-update {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #1a1a1a;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);
    }
    .btn-update:hover {
        box-shadow: 0 6px 25px rgba(255, 193, 7, 0.3);
        color: #1a1a1a;
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

    .btn-back {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
    }
    .btn-back:hover {
        box-shadow: 0 4px 15px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    /* ===== FORM ELEMENTS ===== */
    .form-control, .form-select {
        border-radius: 10px;
        padding: 8px 14px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        background: #f8f9fa;
        font-size: 0.85rem;
        color: #1a1a1a;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
        background: white;
    }
    .form-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 36px;
    }

    /* ===== ALERT ===== */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 14px 20px;
        animation: slideDown 0.5s ease forwards;
    }
    .alert-info {
        background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        color: #0c5460;
        border-left: 4px solid #17a2b8;
    }
    .alert-info strong {
        color: #0c5460;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== BORDER TOP ===== */
    .border-top-section {
        border-top: 2px solid #e9ecef;
        padding-top: 20px;
        margin-top: 20px;
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
        .detail-table th {
            font-size: 0.75rem;
            padding: 8px 10px 8px 0;
            width: 45%;
        }
        .detail-table td {
            font-size: 0.8rem;
            padding: 8px 10px;
        }
        .detail-table th::after {
            right: 4px;
        }
        .btn-action {
            padding: 6px 14px;
            font-size: 0.75rem;
            width: 100%;
            justify-content: center;
        }
        .row.mt-3 .col-md-6 {
            margin-bottom: 12px;
        }
        .row.mt-3 .col-md-6:last-child {
            margin-bottom: 0;
        }
        .border-top-section .row.g-3 {
            flex-direction: column;
            gap: 8px;
        }
        .border-top-section .row.g-3 .col-md-4,
        .border-top-section .row.g-3 .col-md-5,
        .border-top-section .row.g-3 .col-md-3 {
            width: 100%;
        }
        .border-top-section .row.g-3 .col-md-3 .btn-action {
            width: 100%;
        }
        .border-top-section .row.g-3.mt-2 {
            flex-direction: column;
            gap: 8px;
        }
        .border-top-section .row.g-3.mt-2 .col-md-7,
        .border-top-section .row.g-3.mt-2 .col-md-3 {
            width: 100%;
        }
        .border-top-section .row.g-3.mt-2 .col-md-3 .btn-action {
            width: 100%;
        }
        .mt-4 .btn-action {
            width: 100%;
            justify-content: center;
        }
        .mt-4 .btn-action:not(:last-child) {
            margin-bottom: 8px;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .section-title {
            font-size: 0.8rem;
        }
        .detail-table th {
            font-size: 0.65rem;
            padding: 6px 6px 6px 0;
            width: 50%;
        }
        .detail-table td {
            font-size: 0.7rem;
            padding: 6px 6px;
        }
        .badge-status {
            font-size: 0.6rem;
            padding: 4px 12px;
        }
        .btn-action {
            padding: 5px 10px;
            font-size: 0.65rem;
        }
        .form-control, .form-select {
            padding: 6px 10px;
            font-size: 0.75rem;
            border-radius: 8px;
        }
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">
            Detail Pengajuan Surat
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="section-title">Data Pemohon</h6>
                <table class="table table-borderless detail-table">
                    <tr><th>Nama</th><td>{{ $permohonan->penduduk->nama ?? '-' }}</td></tr>
                    <tr><th>NIK</th><td>{{ $permohonan->penduduk->nik ?? '-' }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $permohonan->penduduk->alamat ?? '-' }}</td></tr>
                    <tr><th>Dusun</th><td>{{ $permohonan->penduduk->dusun ?? '-' }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="section-title">Data Pengajuan</h6>
                <table class="table table-borderless detail-table">
                    <tr><th>Jenis Surat</th><td>{{ $permohonan->jenisSurat->nama_surat ?? '-' }}</td></tr>
                    <tr><th>Tanggal Pengajuan</th><td>{{ $permohonan->tanggal_pengajuan->format('d/m/Y H:i') }}</td></tr>
                    <tr><th>Keperluan</th><td>{{ $permohonan->keperluan }}</td></tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge-status badge-{{ $permohonan->status_permohonan }}">
                                {{ ucfirst($permohonan->status_permohonan) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <h6 class="section-title">Dokumen Persyaratan</h6>
                @php
                    $docs = [];
                    if ($permohonan->file_persyaratan) {
                        $decoded = json_decode($permohonan->file_persyaratan, true);
                        if (is_array($decoded)) {
                            $docs = $decoded;
                        } else {
                            $docs = [['label' => 'Dokumen Persyaratan Utama', 'file' => $permohonan->file_persyaratan]];
                        }
                    }
                @endphp

                @if(count($docs) > 0)
                    <div class="d-flex flex-column gap-2 mt-2">
                        @foreach($docs as $doc)
                            <div class="d-flex align-items-center justify-content-between p-2 px-3 border rounded-3 bg-light">
                                <span class="fw-bold small text-dark me-2">
                                    <i class="fas fa-file-alt text-success me-2"></i> {{ $doc['label'] ?? 'Dokumen Persyaratan' }}
                                </span>
                                @if(!empty($doc['file']))
                                    <a href="{{ asset('storage/' . $doc['file']) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                                        <i class="fas fa-external-link-alt me-1"></i> Lihat Berkas
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <span class="text-muted">Belum ada dokumen</span>
                @endif
            </div>
            <div class="col-md-6">
                <h6 class="section-title">Surat Selesai</h6>
                @if($permohonan->file_surat_scan)
                    <a href="{{ asset('storage/' . $permohonan->file_surat_scan) }}" target="_blank" class="btn-action btn-surat">
                        Lihat Surat (Sudah TTD)
                    </a>
                @else
                    <span class="text-muted">Surat belum diupload</span>
                    @if(in_array(Auth::user()->role, ['kaur_umum', 'kepala_desa']) && in_array($permohonan->status_permohonan, ['diproses', 'selesai']))
                        <div class="mt-2">
                            <a href="{{ route('surat.permohonan.cetak', $permohonan->id_permohonan) }}" target="_blank" class="btn-action" style="background: linear-gradient(135deg, #0dcaf0, #31d2f2); color: white; box-shadow: 0 4px 15px rgba(13, 202, 240, 0.2);">
                                @if($permohonan->jenisSurat && $permohonan->jenisSurat->template_surat && str_ends_with(strtolower($permohonan->jenisSurat->template_surat), '.docx'))
                                    <i class="fas fa-file-word"></i> Download Draft Surat (Word)
                                @else
                                    <i class="fas fa-file-pdf"></i> Cetak Draft PDF (Default)
                                @endif
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        
        @if($permohonan->catatan)
            <div class="alert alert-info mt-3">
                <strong>Catatan:</strong> {{ $permohonan->catatan }}
            </div>
        @endif
        
        @if(in_array(Auth::user()->role, ['kaur_umum', 'kepala_desa']))
            <div class="border-top-section">
                <h6 class="section-title">Verifikasi Pengajuan</h6>
                
                @if(Auth::user()->role == 'kaur_umum')
                    <form method="POST" action="{{ route('surat.permohonan.verifikasi', $permohonan->id_permohonan) }}" class="row g-3">
                        @csrf
                        <div class="col-md-3">
                            <select class="form-select" name="status" required>
                                <option value="">Ubah Status</option>
                                <option value="diproses" {{ $permohonan->status_permohonan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $permohonan->status_permohonan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $permohonan->status_permohonan == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="nomor_surat"
                                placeholder="Nomor Surat (contoh: 470/001/VIII/2026)"
                                value="{{ old('nomor_surat', $permohonan->nomor_surat ?? \App\Http\Controllers\SuratController::generateNomorSurat($permohonan)) }}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="catatan" placeholder="Catatan (opsional)" value="{{ old('catatan', $permohonan->catatan) }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn-action btn-update w-100">Update</button>
                        </div>
                    </form>
                @endif
                
                @if(Auth::user()->role == 'kaur_umum' && in_array($permohonan->status_permohonan, ['diproses', 'selesai']))
                    <form method="POST" action="{{ route('surat.permohonan.upload-surat', $permohonan->id_permohonan) }}" class="row g-3 mt-2" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-7">
                            <input type="file" class="form-control" name="file_surat_scan" accept=".pdf" required>
                            <small class="text-muted">Upload file PDF surat yang sudah ditandatangani</small>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn-action btn-upload w-100">Upload Surat</button>
                        </div>
                    </form>
                @endif
            </div>
        @endif
        
        <div class="mt-4">
            <a href="{{ route('surat.permohonan.index') }}" class="btn-action btn-back">Kembali</a>
        </div>
    </div>
</div>
@endsection