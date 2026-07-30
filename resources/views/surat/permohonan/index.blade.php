@extends('layouts.dashboard')

@section('page-title', 'Pengajuan Surat Keterangan')

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

    /* ===== BUTTON TAMBAH ===== */
    .btn-tambah {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 2px 10px rgba(26, 71, 42, 0.2);
        position: relative;
        overflow: hidden;
    }
    .btn-tambah::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.6s ease;
    }
    .btn-tambah:hover::before {
        left: 100%;
    }
    .btn-tambah:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 6px 25px rgba(26, 71, 42, 0.35);
        color: white;
    }
    .btn-tambah:active {
        transform: scale(0.95);
    }

    /* ===== FILTER ===== */
    .filter-select {
        border-radius: 10px !important;
        border: 2px solid #e9ecef !important;
        padding: 6px 12px !important;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
        cursor: pointer;
    }
    .filter-select:focus {
        border-color: #1a472a !important;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08) !important;
        background: white;
    }
    .btn-filter {
        border-radius: 10px !important;
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        border: 2px solid #1a472a;
        padding: 6px 18px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-filter:hover {
        background: linear-gradient(135deg, #2d6a4f, #1a472a);
        color: white;
        transform: scale(1.02);
    }
    .btn-reset-filter {
        border-radius: 10px !important;
        background: #dc3545;
        color: white;
        border: 2px solid #dc3545;
        padding: 6px 14px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        margin-left: 6px;
    }
    .btn-reset-filter:hover {
        background: #b02a37;
        border-color: #b02a37;
        color: white;
        transform: scale(1.02);
    }
    .btn-lihat-semua {
        border-radius: 10px !important;
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white;
        border: none;
        padding: 6px 18px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-lihat-semua:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        color: white;
    }

    /* ===== TABLE STYLING ===== */
    .table {
        margin-bottom: 0;
        font-size: 0.85rem;
    }
    .table thead th {
        color: white;
        font-weight: 600;
        padding: 12px 16px;
        border-bottom: none;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    .table thead th:first-child {
        border-radius: 10px 0 0 0;
    }
    .table thead th:last-child {
        border-radius: 0 10px 0 0;
    }
    .table thead.bg-primary {
        background: linear-gradient(135deg, #1a472a, #2d6a4f) !important;
    }
    .table thead.bg-success {
        background: linear-gradient(135deg, #0d6efd, #0a58ca) !important;
    }
    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }
    .table tbody tr {
        transition: all 0.3s ease;
    }
    .table tbody tr:hover {
        background: linear-gradient(90deg, #f8f9fa, #ffffff);
        transform: scale(1.005);
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    .table tbody tr:nth-child(even) {
        background: #fafbfc;
    }
    .table tbody tr:nth-child(even):hover {
        background: linear-gradient(90deg, #f8f9fa, #ffffff);
    }

    /* ===== BADGE STATUS ===== */
    .badge-status {
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
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

    /* ===== BADGE VERIFIKASI ===== */
    .badge-verif {
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    .badge-verif-lengkap {
        background: linear-gradient(135deg, #d4edda, #a8e0b0);
        color: #1a472a;
    }
    .badge-verif-ditolak {
        background: linear-gradient(135deg, #f8d7da, #f5b8b8);
        color: #dc3545;
    }
    .badge-verif-menunggu {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
    }

    /* ===== ACTION BUTTONS ===== */
    .btn-group .btn {
        border-radius: 8px !important;
        padding: 6px 10px;
        font-size: 0.7rem;
        transition: all 0.3s ease;
        margin: 0 2px;
        border: none;
        font-weight: 600;
    }
    .btn-detail {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #0d47a1;
    }
    .btn-detail:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(13, 71, 161, 0.2);
        color: #0d47a1;
    }
    .btn-cetak {
        background: linear-gradient(135deg, #d4edda, #a8e0b0);
        color: #1a472a;
    }
    .btn-cetak:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.2);
        color: #1a472a;
    }
    .btn-setujui {
        background: linear-gradient(135deg, #d4edda, #a8e0b0);
        color: #1a472a;
    }
    .btn-setujui:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.2);
        color: #1a472a;
    }
    .btn-tolak {
        background: linear-gradient(135deg, #f8d7da, #f5b8b8);
        color: #721c24;
    }
    .btn-tolak:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(114, 28, 36, 0.2);
        color: #721c24;
    }
    .btn-lihat-pdf {
        background: linear-gradient(135deg, #f8d7da, #f5b8b8);
        color: #721c24;
    }
    .btn-lihat-pdf:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(114, 28, 36, 0.2);
        color: #721c24;
    }
    .btn-upload {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white;
    }
    .btn-upload:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        color: white;
    }

    /* ===== PAGINATION ===== */
    .pagination {
        margin-bottom: 0;
        gap: 4px;
    }
    .pagination .page-item .page-link {
        border: none;
        border-radius: 8px !important;
        padding: 8px 14px;
        color: #1a472a;
        font-weight: 500;
        transition: all 0.3s ease;
        background: transparent;
        font-size: 0.85rem;
    }
    .pagination .page-item .page-link:hover {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #1a472a;
        transform: scale(1.05);
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
    }
    .pagination .page-item.disabled .page-link {
        color: #adb5bd;
        background: transparent;
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
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .alert .btn-close {
        padding: 12px;
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
        .card-header .btn-tambah {
            width: 100%;
            text-align: center;
        }
        .table thead th {
            font-size: 0.6rem;
            padding: 6px 8px;
        }
        .table tbody td {
            padding: 6px 8px;
            font-size: 0.7rem;
        }
        .btn-group .btn {
            padding: 3px 6px;
            font-size: 0.55rem;
        }
        .row.mb-3 {
            flex-direction: column;
            gap: 10px;
        }
        .row.mb-3 .col-md-6 {
            width: 100%;
        }
        .row.mb-3 .col-md-6 .d-flex {
            flex-wrap: wrap;
            gap: 6px;
        }
        .filter-select {
            max-width: 100% !important;
            flex: 1;
        }
        .text-md-end {
            text-align: left !important;
        }
        .btn-lihat-semua {
            width: 100%;
            text-align: center;
        }
        /* Tabel 2 upload form */
        .d-flex.gap-1 {
            flex-direction: column;
            gap: 4px !important;
        }
        .d-flex.gap-1 input[type="file"] {
            max-width: 100% !important;
            width: 100%;
        }
        .d-flex.gap-1 button {
            width: 100%;
        }
        .mt-3 .d-flex.gap-3 {
            flex-direction: column;
            gap: 8px !important;
        }
        .mt-3 .d-flex.gap-3 .d-flex {
            flex-direction: column;
            gap: 4px !important;
        }
        .mt-3 .d-flex.gap-3 input[type="file"] {
            max-width: 100% !important;
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .table thead th {
            font-size: 0.5rem;
            padding: 4px 4px;
        }
        .table tbody td {
            padding: 4px 4px;
            font-size: 0.6rem;
        }
        .btn-group .btn {
            padding: 2px 4px;
            font-size: 0.5rem;
        }
        .badge-status, .badge-verif {
            font-size: 0.5rem;
            padding: 2px 8px;
        }
        .pagination .page-item .page-link {
            padding: 4px 8px;
            font-size: 0.7rem;
        }
        .btn-tambah {
            font-size: 0.75rem;
            padding: 6px 14px;
        }
    }
</style>

@php
    $isKepalaDesa = Auth::user()->role == 'kepala_desa';
@endphp

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">
            Daftar Permohonan Pengajuan Surat
        </h5>
        @if(Auth::user()->role == 'penduduk')
            <a href="{{ route('surat.permohonan.create') }}" class="btn btn-tambah">
                + Ajukan Surat
            </a>
        @endif
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

        <!-- Filter Status -->
        <div class="row mb-3 align-items-center">
            <div class="col-md-6">
                <form action="{{ route('surat.permohonan.index') }}" method="GET" class="d-flex align-items-center">
                    <select name="status" class="form-select filter-select me-2" style="max-width: 200px;">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <button type="submit" class="btn btn-filter">Filter</button>
                    @if(request('status'))
                        <a href="{{ route('surat.permohonan.index') }}" class="btn btn-reset-filter">✕</a>
                    @endif
                </form>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('surat.permohonan.index') }}" class="btn btn-lihat-semua">
                    Lihat Semua
                </a>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TABEL 1: DAFTAR PERMOHONAN PENGAJUAN SURAT -->
        <!-- ========================================== -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>ID Surat</th>
                        <th>Nama</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keperluan</th>
                        <th>Dokumen</th>
                        <th>Verifikasi</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permohonan as $item)
                    <tr>
                        <td><span class="fw-bold" style="color: #1a472a;">{{ $loop->iteration + ($permohonan->currentPage() - 1) * $permohonan->perPage() }}</span></td>
                        <td><span class="fw-bold" style="color: #1a472a;">S-{{ str_pad($item->id_permohonan, 4, '0', STR_PAD_LEFT) }}</span></td>
                        <td>{{ $item->penduduk->nama ?? '-' }}</td>
                        <td>{{ $item->jenisSurat->nama_surat ?? '-' }}</td>
                        <td>{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge-status badge-{{ $item->status_permohonan }}">
                                {{ ucfirst($item->status_permohonan) }}
                            </span>
                        </td>
                        <td>{{ Str::limit($item->keperluan, 20) }}</td>
                        <td>
                            @if($item->file_persyaratan)
                                <a href="{{ asset('storage/' . $item->file_persyaratan) }}" target="_blank" class="btn btn-detail" style="font-size: 0.65rem; padding: 4px 10px;">
                                    Lihat
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($item->status_permohonan == 'selesai')
                                <span class="badge-verif badge-verif-lengkap" style="white-space: nowrap;">
                                    Selesai
                                </span>
                            @elseif($item->status_permohonan == 'ditolak')
                                <span class="badge-verif badge-verif-ditolak" style="white-space: nowrap;">
                                    Ditolak
                                </span>
                            @elseif($item->status_permohonan == 'diproses')
                                <span class="badge-verif badge-diproses" style="white-space: nowrap;">
                                    Diproses
                                </span>
                            @else
                                <span class="badge-verif badge-verif-menunggu" style="white-space: nowrap;">
                                    Menunggu verifikasi
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <!-- Detail -->
                                <a href="{{ route('surat.permohonan.show', $item->id_permohonan) }}" 
                                   class="btn btn-detail" title="Detail">
                                    Detail
                                </a>

                                <!-- Cetak Draft PDF resmi -->
                                <a href="{{ route('surat.permohonan.cetak', $item->id_permohonan) }}" target="_blank" 
                                   class="btn btn-info text-white" title="Cetak Draft PDF">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>

                                <!-- Cetak (jika selesai) -->
                                @if($item->status_permohonan == 'selesai' && $item->file_surat_scan)
                                    <a href="{{ asset('storage/' . $item->file_surat_scan) }}" target="_blank" 
                                       class="btn btn-cetak" title="Cetak Hasil Scan">
                                        Scan PDF
                                    </a>
                                @endif

                                <!-- Setujui (Kepala Desa & Kaur Umum) -->
                                @if(in_array(Auth::user()->role, ['kaur_umum', 'kepala_desa']) && $item->status_permohonan == 'menunggu')
                                    <button type="button" 
                                            class="btn btn-setujui btn-setujui" 
                                            data-id="{{ $item->id_permohonan }}"
                                            title="Setujui">
                                        Setujui
                                    </button>
                                @endif

                                <!-- Tolak (Kepala Desa & Kaur Umum) -->
                                @if(in_array(Auth::user()->role, ['kaur_umum', 'kepala_desa']) && $item->status_permohonan == 'menunggu')
                                    <button type="button" 
                                            class="btn btn-tolak btn-tolak" 
                                            data-id="{{ $item->id_permohonan }}"
                                            title="Tolak">
                                        Tolak
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            Belum ada pengajuan surat
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap" style="gap: 12px;">
            <span class="text-muted small">
                Menampilkan {{ $permohonan->firstItem() ?? 0 }} - {{ $permohonan->lastItem() ?? 0 }} 
                dari {{ $permohonan->total() }} data
            </span>
            {{ $permohonan->links() }}
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- TABEL 2: TANDA TANGAN KADES               -->
<!-- ========================================== -->
@if(in_array(Auth::user()->role, ['kaur_umum', 'kepala_desa']))
<div class="card shadow-sm mt-4">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">
            Daftar Pengajuan Surat (Tanda Tangan Kades)
        </h5>
    </div>
    <div class="card-body">
        
        @php
            // Menampilkan surat yang sedang diproses (butuh upload) dan selesai
            $suratKades = $permohonan->whereIn('status_permohonan', ['diproses', 'selesai']);
        @endphp

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-success text-white">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>No Surat</th>
                        <th>Nama Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratKades as $item)
                    <tr>
                        <td><span class="fw-bold" style="color: #1a472a;">{{ $loop->iteration }}</span></td>
                        <td><span class="fw-bold" style="color: #1a472a;">SK-{{ str_pad($item->id_permohonan, 4, '0', STR_PAD_LEFT) }}</span></td>
                        <td>{{ $item->penduduk->nama ?? '-' }}</td>
                        <td>{{ $item->jenisSurat->nama_surat ?? '-' }}</td>
                        <td>{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                        <td>
                            @if($item->file_surat_scan)
                                <span class="badge-status badge-selesai">
                                    Ditandatangani Kades
                                </span>
                            @else
                                <span class="badge-status badge-menunggu">
                                    Menunggu
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($item->file_surat_scan)
                                    <a href="{{ asset('storage/' . $item->file_surat_scan) }}" target="_blank" 
                                       class="btn btn-lihat-pdf" title="Lihat Surat">
                                        Lihat PDF
                                    </a>
                                @else
                                    <form action="{{ route('surat.permohonan.upload-surat', $item->id_permohonan) }}" 
                                          method="POST" enctype="multipart/form-data" class="d-inline">
                                        @csrf
                                        <div class="d-flex gap-1" style="align-items: center;">
                                            <input type="file" name="file_surat_scan" accept=".pdf" 
                                                   style="max-width: 100px; font-size: 0.65rem; padding: 2px 4px;" required>
                                            <button type="submit" class="btn btn-upload" style="font-size: 0.65rem; padding: 4px 10px;">
                                                Upload
                                            </button>
                                        </div>
                                    </form>
                                @endif
                                <a href="{{ route('surat.permohonan.show', $item->id_permohonan) }}" 
                                   class="btn btn-detail" title="Detail">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            Belum ada surat yang memerlukan tanda tangan Kades
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tombol Upload -->
        <div class="mt-3">
            <form action="#" method="POST" enctype="multipart/form-data" class="d-flex gap-3 align-items-center flex-wrap">
                @csrf
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <label class="fw-semibold small">Upload PDF Surat:</label>
                    <input type="file" name="file_surat_scan" accept=".pdf" class="form-control form-control-sm" style="max-width: 200px;">
                </div>
                <button type="submit" class="btn btn-upload" style="font-size: 0.8rem; padding: 6px 18px;">
                    Upload
                </button>
            </form>
        </div>

    </div>
</div>
@endif

<!-- ========================================== -->
<!-- SCRIPT SETUJUI & TOLAK                    -->
<!-- ========================================== -->
@push('scripts')
<script>
    // ========================================== //
    // SETUJUI SURAT                              //
    // ========================================== //
    document.querySelectorAll('.btn-setujui').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            
            Swal.fire({
                title: 'Setujui Pengajuan?',
                text: 'Apakah Anda yakin ingin menyetujui pengajuan surat ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/surat/permohonan/' + id + '/verifikasi';
                    form.innerHTML = `
                        @csrf
                        <input type="hidden" name="status" value="diproses">
                        <input type="hidden" name="catatan" value="Berkas persyaratan valid, surat sedang diproses.">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // ========================================== //
    // TOLAK SURAT                                //
    // ========================================== //
    document.querySelectorAll('.btn-tolak').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            
            Swal.fire({
                title: 'Tolak Pengajuan?',
                input: 'textarea',
                inputLabel: 'Alasan Penolakan',
                inputPlaceholder: 'Tulis alasan penolakan...',
                inputAttributes: {
                    'aria-label': 'Alasan penolakan'
                },
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const catatan = result.value || 'Ditolak oleh Kepala Desa';
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/surat/permohonan/' + id + '/verifikasi';
                    form.innerHTML = `
                        @csrf
                        <input type="hidden" name="status" value="ditolak">
                        <input type="hidden" name="catatan" value="${catatan}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

@endsection