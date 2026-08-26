@extends('layouts.dashboard')

@section('page-title', 'Data Penduduk')

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
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border-left: 4px solid #1a472a;
        position: relative;
        overflow: hidden;
        cursor: default;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        transition: all 0.6s ease;
        opacity: 0.1;
    }
    .stat-card:nth-child(1)::before {
        background: radial-gradient(circle, #1a472a, transparent 70%);
    }
    .stat-card:nth-child(2)::before {
        background: radial-gradient(circle, #0d6efd, transparent 70%);
    }
    .stat-card:nth-child(3)::before {
        background: radial-gradient(circle, #ffc107, transparent 70%);
    }
    .stat-card:nth-child(4)::before {
        background: radial-gradient(circle, #dc3545, transparent 70%);
    }
    .stat-card:hover::before {
        transform: scale(1.5);
        opacity: 0.15;
    }
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 50px rgba(0,0,0,0.1);
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
    .stat-card .stat-sub {
        font-size: 0.7rem;
        color: #adb5bd;
        margin-top: 2px;
        display: block;
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
    .stat-card .icon.bg-warning {
        background: linear-gradient(135deg, #fff3cd, #ffe69c) !important;
        color: #856404;
    }
    .stat-card .icon.bg-danger {
        background: linear-gradient(135deg, #f8d7da, #f5b8b8) !important;
        color: #dc3545;
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
        padding: 16px 24px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
    }
    .card-header .card-title {
        font-weight: 700;
        color: #1a472a;
        font-size: 0.95rem;
    }
    .card-footer {
        border-top: none !important;
        padding: 16px 24px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
    }

    /* ===== SEARCH INPUT ===== */
    .search-input {
        border-radius: 12px 0 0 12px !important;
        border: 2px solid #e9ecef !important;
        padding: 10px 16px !important;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    .search-input:focus {
        border-color: #1a472a !important;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08) !important;
        background: white;
    }
    .search-input:focus + .input-group-text {
        border-color: #1a472a !important;
        background: white;
    }
    .input-group-text {
        border-radius: 0 12px 12px 0 !important;
        border: 2px solid #e9ecef;
        border-left: none !important;
        background: #f8f9fa;
        padding: 0 16px;
        transition: all 0.3s ease;
    }
    .input-group:focus-within .input-group-text {
        border-color: #1a472a !important;
        background: white;
    }
    .input-group-text i {
        color: #6c757d;
        transition: all 0.3s ease;
    }
    .input-group:focus-within .input-group-text i {
        color: #1a472a;
    }

    /* ===== BUTTON TAMBAH ===== */
    .btn-tambah {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
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

    /* ===== TABLE STYLING ===== */
    .table {
        margin-bottom: 0;
        font-size: 0.85rem;
    }
    .table thead th {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
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

    /* ===== BADGE STYLING ===== */
    .badge-status {
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .badge-tetap {
        background: linear-gradient(135deg, #d4edda, #a8e0b0);
        color: #1a472a;
    }
    .badge-sementara {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
    }
    .badge-kk {
        background: linear-gradient(135deg, #cfe2ff, #9ec5fe);
        color: #0d6efd;
        padding: 4px 10px;
        border-radius: 50%;
        font-size: 0.8rem;
    }
    .badge-jk-L {
        background: linear-gradient(135deg, #cfe2ff, #9ec5fe);
        color: #0d6efd;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.7rem;
    }
    .badge-jk-P {
        background: linear-gradient(135deg, #f8d7da, #f5b8b8);
        color: #dc3545;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.7rem;
    }

    /* ===== ACTION BUTTONS ===== */
    .btn-group .btn {
        border-radius: 8px !important;
        padding: 6px 12px;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        margin: 0 2px;
        border: none;
    }
    .btn-group .btn-detail {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #0d47a1;
    }
    .btn-group .btn-detail:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(13, 71, 161, 0.2);
        color: #0d47a1;
    }
    .btn-group .btn-edit {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
    }
    .btn-group .btn-edit:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(133, 100, 4, 0.2);
        color: #856404;
    }
    .btn-group .btn-delete-action {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }
    .btn-group .btn-delete-action:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(114, 28, 36, 0.2);
        color: #721c24;
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

    /* ===== ANIMATIONS ===== */
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
        .card-header {
            padding: 14px 18px;
        }
        .card-body {
            padding: 0 !important;
        }
        .card-footer {
            padding: 14px 18px;
        }
        .table thead th {
            font-size: 0.65rem;
            padding: 8px 10px;
        }
        .table tbody td {
            padding: 8px 10px;
            font-size: 0.75rem;
        }
        .btn-group .btn {
            padding: 4px 8px;
            font-size: 0.65rem;
        }
        .btn-tambah {
            padding: 8px 16px;
            font-size: 0.8rem;
            width: 100%;
        }
        .col-md-6.text-md-end {
            text-align: left !important;
            margin-top: 8px;
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
        .table thead th {
            font-size: 0.55rem;
            padding: 6px 6px;
        }
        .table tbody td {
            padding: 6px 6px;
            font-size: 0.65rem;
        }
        .btn-group .btn {
            padding: 3px 6px;
            font-size: 0.55rem;
        }
        .pagination .page-item .page-link {
            padding: 4px 8px;
            font-size: 0.7rem;
        }
        .badge-status {
            font-size: 0.55rem;
            padding: 2px 8px;
        }
    }
</style>

@php
    $isKepalaDesa = Auth::user()->role == 'kepala_desa';
@endphp

<!-- ============================================================ -->
<!-- STATISTICS CARDS                                              -->
<!-- ============================================================ -->
<div class="row g-4 mb-4">
    <div class="col-md-3 animate-on-scroll" style="animation-delay: 0.1s;">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label mb-1">
                        <i class="fas fa-users me-1" style="color: #1a472a;"></i>
                        Total Penduduk
                    </p>
                    <h3 class="stat-number">{{ $totalPenduduk }}</h3>
                </div>
                <div class="icon bg-success">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 animate-on-scroll" style="animation-delay: 0.2s;">
        <div class="stat-card" style="border-left-color: #0d6efd;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label mb-1">
                        <i class="fas fa-user-tie me-1" style="color: #0d6efd;"></i>
                        Kepala Keluarga
                    </p>
                    <h3 class="stat-number" style="background: linear-gradient(135deg, #0d6efd, #0a58ca); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">{{ $kepalaKeluarga }}</h3>
                </div>
                <div class="icon bg-primary">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 animate-on-scroll" style="animation-delay: 0.3s;">
        <div class="stat-card" style="border-left-color: #ffc107;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label mb-1">
                        <i class="fas fa-user-plus me-1" style="color: #856404;"></i>
                        Penduduk Baru
                    </p>
                    <h3 class="stat-number" style="background: linear-gradient(135deg, #ffc107, #e0a800); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">{{ $pendudukBaru }}</h3>
                    <span class="stat-sub">Bulan ini</span>
                </div>
                <div class="icon bg-warning">
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 animate-on-scroll" style="animation-delay: 0.4s;">
        <div class="stat-card" style="border-left-color: #dc3545;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label mb-1">
                        <i class="fas fa-user-clock me-1" style="color: #dc3545;"></i>
                        Penduduk Lansia
                    </p>
                    <h3 class="stat-number" style="background: linear-gradient(135deg, #dc3545, #b02a37); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">{{ $pendudukLansia }}</h3>
                    <span class="stat-sub">Usia &gt; 60 tahun</span>
                </div>
                <div class="icon bg-danger">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- TABLE DATA PENDUDUK                                          -->
<!-- ============================================================ -->
<div class="card shadow-sm animate-on-scroll" style="animation-delay: 0.5s;">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">
            <i class="fas fa-list me-2 text-success"></i>Daftar Penduduk
        </h5>
    </div>
    
    <!-- Filter & Search (KAUR UMUM & KEPALA DESA) -->
    <div class="card-body pb-0">
        
        <!-- NAV TABS: PENDUDUK AKTIF vs RIWAYAT MENINGGAL -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2">
            <li class="nav-item">
                <a class="nav-link fw-bold me-2 {{ ($tab ?? 'aktif') == 'aktif' ? 'active bg-success text-white' : 'text-dark bg-light' }}" 
                   style="border-radius: 10px; font-size: 0.85rem;" 
                   href="{{ route('penduduk.index', array_merge(request()->except('tab'), ['tab' => 'aktif'])) }}">
                    <i class="fas fa-users me-1"></i> Data Penduduk Aktif <span class="badge bg-white text-dark ms-1">{{ number_format($countAktif ?? 0, 0, ',', '.') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold {{ ($tab ?? 'aktif') == 'meninggal' ? 'active bg-dark text-white' : 'text-dark bg-light' }}" 
                   style="border-radius: 10px; font-size: 0.85rem;" 
                   href="{{ route('penduduk.index', array_merge(request()->except('tab'), ['tab' => 'meninggal'])) }}">
                    <i class="fas fa-cross me-1"></i> Riwayat Penduduk Meninggal Dunia <span class="badge bg-danger text-white ms-1">{{ number_format($countMeninggal ?? 0, 0, ',', '.') }}</span>
                </a>
            </li>
        </ul>

        <form action="{{ route('penduduk.index') }}" method="GET" id="filterForm">
            <input type="hidden" name="tab" value="{{ $tab ?? 'aktif' }}">
            <div class="row g-2 align-items-center">
                <!-- Search Input -->
                <div class="col-lg-4 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" 
                               name="keyword" 
                               class="form-control border-0 bg-light" 
                               placeholder="🔍 Cari NIK, Nama, KK, Alamat..." 
                               value="{{ request('keyword') }}"
                               style="font-size: 0.85rem;"
                               autocomplete="off">
                    </div>
                </div>

                <!-- Filter Tahun Update -->
                <div class="col-lg-2 col-md-3">
                    <select name="tahun" class="form-select border-0 bg-light" style="font-size: 0.85rem; cursor: pointer;" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @foreach($daftarTahun as $t)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>Tahun {{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Dusun -->
                <div class="col-lg-2 col-md-4">
                    <select name="dusun" class="form-select border-0 bg-light" style="font-size: 0.85rem; cursor: pointer;" onchange="this.form.submit()">
                        <option value="">Semua Dusun</option>
                        @foreach($daftarDusun as $d)
                            <option value="{{ $d }}" {{ request('dusun') == $d ? 'selected' : '' }}>Dusun {{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter JK -->
                <div class="col-lg-2 col-md-3">
                    <select name="jenis_kelamin" class="form-select border-0 bg-light" style="font-size: 0.85rem; cursor: pointer;" onchange="this.form.submit()">
                        <option value="">Semua JK</option>
                        <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-lg-2 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary flex-grow-1 fw-semibold" style="background: #1a472a; border-color: #1a472a; border-radius: 8px;">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    @if(request('keyword') || request('tahun') || request('dusun') || request('jenis_kelamin'))
                        <a href="{{ route('penduduk.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;" title="Reset Filter">
                            <i class="fas fa-redo"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
            <small class="text-muted">
                @if(request('tahun'))
                    Menampilkan data update <strong>Tahun {{ request('tahun') }}</strong>
                @else
                    Menampilkan seluruh data update penduduk
                @endif
            </small>
            <div class="d-flex gap-2">
                <a href="{{ route('penduduk.cetak-pdf', ['tahun' => request('tahun')]) }}" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold" title="Cetak Laporan Rekapitulasi PDF">
                    <i class="fas fa-file-pdf me-1"></i> Cetak Laporan PDF
                </a>
                @if(!$isKepalaDesa)
                <a href="{{ route('penduduk.create') }}" class="btn btn-tambah btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah Data Penduduk
                </a>
                @endif
            </div>
        </div>
        <hr class="mt-3" style="opacity: 0.3;">
    </div>
    
    <!-- Tabel -->
    <div class="card-body p-0">
        <div class="table-responsive">
            @if(($tab ?? 'aktif') == 'meninggal')
            <table class="table table-hover mb-0 text-nowrap" id="pendudukTable">
                <thead class="bg-dark text-white">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NIK</th>
                        <th>Nama Almarhum / Almarhumah</th>
                        <th>JK</th>
                        <th>Dusun / Alamat</th>
                        <th>Tgl Meninggal / Terbit Surat</th>
                        <th>Nomor Surat Kematian</th>
                        <th style="width: 150px;">Aksi / Arsip Surat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penduduk as $item)
                    @php
                        $suratKematian = $item->permohonanSurat ? $item->permohonanSurat->first() : null;
                    @endphp
                    <tr>
                        <td><span class="fw-bold" style="color: #1a472a;">{{ $loop->iteration + ($penduduk->currentPage() - 1) * $penduduk->perPage() }}</span></td>
                        <td><span class="fw-bold text-secondary" style="font-size: 0.8rem;">{{ $item->nik }}</span></td>
                        <td><strong class="text-danger"><i class="fas fa-cross me-1"></i>{{ $item->nama }}</strong></td>
                        <td>
                            <span class="badge badge-jk-{{ $item->jenis_kelamin == 'L' ? 'L' : 'P' }}">
                                {{ $item->jenis_kelamin == 'L' ? 'L' : 'P' }}
                            </span>
                        </td>
                        <td>{{ $item->dusun ? 'Dusun '.$item->dusun : Str::limit($item->alamat, 25) }}</td>
                        <td>
                            <small class="fw-bold text-dark">
                                {{ $item->deleted_at ? $item->deleted_at->format('d/m/Y') : ($suratKematian ? $suratKematian->tanggal_pengajuan->format('d/m/Y') : '-') }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark" style="font-size: 0.75rem;">
                                {{ $suratKematian->nomor_surat ?? '474.3/SDM/'.date('Y') }}
                            </span>
                        </td>
                        <td>
                            @if($suratKematian)
                                <a href="{{ route('surat.permohonan.show', $suratKematian->id_permohonan) }}" class="btn btn-sm btn-outline-primary" style="font-size: 0.75rem; border-radius: 8px;">
                                    <i class="fas fa-eye me-1"></i> Detail Surat
                                </a>
                            @else
                                <span class="badge bg-secondary">Telah Meninggal</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-monument" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            <p class="mb-0">Belum ada riwayat penduduk yang meninggal dunia</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @else
            <table class="table table-hover mb-0" id="pendudukTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th style="width: 80px;">KK</th>
                        <th>Tempat, Tgl Lahir</th>
                        <th style="width: 50px;">JK</th>
                        <th>Dusun / Alamat</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($penduduk as $item)
                    <tr>
                        <td><span class="fw-bold" style="color: #1a472a;">{{ $loop->iteration + ($penduduk->currentPage() - 1) * $penduduk->perPage() }}</span></td>
                        <td><span class="fw-bold" style="color: #1a472a; font-size: 0.8rem;">{{ $item->nik }}</span></td>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td>
                            @if($item->is_kepala_keluarga)
                                <span class="badge badge-kk">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            {{ $item->tempat_lahir }}
                            <br>
                            <small class="text-muted" style="font-size: 0.7rem;">{{ $item->tanggal_lahir->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            <span class="badge badge-jk-{{ $item->jenis_kelamin == 'L' ? 'L' : 'P' }}">
                                {{ $item->jenis_kelamin == 'L' ? 'L' : 'P' }}
                            </span>
                        </td>
                        <td>{{ Str::limit($item->alamat, 25) }}</td>
                        <td>
                            <span class="badge bg-secondary px-2 py-1" style="font-size: 0.7rem; font-weight: 500;">
                                {{ $item->tahun ?? 2025 }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-status badge-{{ $item->status_penduduk == 'tetap' ? 'tetap' : 'sementara' }}">
                                {{ ucfirst($item->status_penduduk) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('penduduk.show', $item->id_penduduk) }}" 
                                   class="btn btn-detail" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(!$isKepalaDesa)
                                <a href="{{ route('penduduk.edit', $item->id_penduduk) }}" 
                                   class="btn btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-delete-action btn-delete" 
                                        data-id="{{ $item->id_penduduk }}"
                                        data-nama="{{ $item->nama }}"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            <p>Belum ada data penduduk</p>
                            @if(!$isKepalaDesa)
                            <a href="{{ route('penduduk.create') }}" class="btn btn-tambah btn-sm">
                                <i class="fas fa-plus me-1"></i>Tambah Data
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @endif
        </div>
    </div>
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 12px;">
            <span class="text-muted small" id="infoData">
                <i class="fas fa-info-circle me-1"></i>
                Menampilkan {{ $penduduk->firstItem() ?? 0 }} - {{ $penduduk->lastItem() ?? 0 }} 
                dari {{ $penduduk->total() }} data
            </span>
            {{ $penduduk->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- SCRIPT LIVE SEARCH + DELETE                                  -->
<!-- ============================================================ -->
@push('scripts')
<script>

    
    // ==========================================
    // DELETE CONFIRMATION (HANYA KAUR UMUM)
    // ==========================================
    @if(!$isKepalaDesa)
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            
            Swal.fire({
                title: 'Hapus Data?',
                html: `
                    <div style="text-align: center;">
                        <i class="fas fa-user" style="font-size: 3rem; color: #dc3545; margin-bottom: 15px; display: block;"></i>
                        <p style="font-size: 1rem; margin-bottom: 5px;">Apakah Anda yakin ingin menghapus data</p>
                        <p style="font-size: 1.1rem; font-weight: 700; color: #1a472a;">"${nama}"</p>
                        <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan!</p>
                    </div>
                `,
                icon: null,
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                showCloseButton: true,
                background: 'white',
                backdrop: 'rgba(0,0,0,0.4)',
                customClass: {
                    popup: 'rounded-4',
                    confirmButton: 'btn btn-danger px-4 py-2',
                    cancelButton: 'btn btn-secondary px-4 py-2',
                    htmlContainer: 'text-center'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Dihapus!',
                        text: `Data "${nama}" telah dihapus.`,
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'center',
                        backdrop: 'rgba(0,0,0,0.2)',
                        customClass: {
                            popup: 'rounded-4',
                            title: 'fw-bold text-success'
                        }
                    }).then(() => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('penduduk.index') }}/${id}`;
                        form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    });
                }
            });
        });
    });
    @endif

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
@endpush

@endsection