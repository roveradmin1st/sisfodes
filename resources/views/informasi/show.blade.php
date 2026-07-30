@extends('layouts.dashboard')

@section('page-title', 'Detail Informasi Desa')

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
        width: 35%;
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

    /* ===== BADGE STYLING ===== */
    .badge-custom {
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-berita {
        background: linear-gradient(135deg, #cfe2ff, #9ec5fe);
        color: #0d6efd;
    }
    .badge-pengumuman {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
    }
    .badge-agenda {
        background: linear-gradient(135deg, #f8d7da, #f5b8b8);
        color: #dc3545;
    }
    .badge-galeri {
        background: linear-gradient(135deg, #d1ecf1, #aee7ef);
        color: #0c5460;
    }
    .badge-publish {
        background: linear-gradient(135deg, #d4edda, #a8e0b0);
        color: #1a472a;
    }
    .badge-draft {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
    }

    /* ===== CONTENT BOX ===== */
    .content-box {
        padding: 20px 24px;
        border-radius: 12px;
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border-left: 4px solid #1a472a;
        text-align: justify;
        line-height: 1.8;
        font-size: 0.95rem;
        color: #2d3748;
    }

    /* ===== IMAGE CONTAINER ===== */
    .img-container {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 8px;
        transition: all 0.3s ease;
        background: white;
        display: inline-block;
    }
    .img-container:hover {
        border-color: #1a472a;
        box-shadow: 0 8px 25px rgba(26, 71, 42, 0.08);
    }
    .img-container img {
        border-radius: 8px;
        max-height: 300px;
        transition: transform 0.3s ease;
    }
    .img-container:hover img {
        transform: scale(1.02);
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
        .card-header .d-flex {
            flex-direction: column;
            gap: 8px;
        }
        .card-header .d-flex .btn {
            width: 100%;
            text-align: center;
        }
        .detail-table th {
            font-size: 0.75rem;
            padding: 10px 12px 10px 0;
            width: 40%;
        }
        .detail-table td {
            font-size: 0.8rem;
            padding: 10px 12px;
        }
        .content-box {
            padding: 16px 18px;
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
        .img-container img {
            max-height: 200px;
            width: 100%;
        }
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 8px !important;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .detail-table th {
            font-size: 0.65rem;
            padding: 8px 8px 8px 0;
            width: 45%;
        }
        .detail-table td {
            font-size: 0.7rem;
            padding: 8px 8px;
        }
        .detail-table th::after {
            right: 4px;
        }
        .content-box {
            padding: 12px 14px;
            font-size: 0.75rem;
            line-height: 1.6;
        }
        .badge-custom {
            font-size: 0.6rem;
            padding: 4px 12px;
        }
        .btn-action {
            padding: 6px 14px;
            font-size: 0.7rem;
        }
        .img-container img {
            max-height: 150px;
        }
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">
            <i class="fas fa-info-circle me-2" style="color: #1a472a;"></i>Detail Informasi Desa
        </h5>
        <div>
            <a href="{{ route('informasi.edit', $informasi->id_informasi) }}" class="btn btn-edit btn-sm">Edit</a>
            <a href="{{ route('informasi.index') }}" class="btn btn-back btn-sm">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <table class="table table-borderless detail-table">
                    <tr>
                        <th>Kategori</th>
                        <td>
                            <span class="badge-custom badge-{{ $informasi->kategori == 'berita' ? 'berita' : ($informasi->kategori == 'pengumuman' ? 'pengumuman' : ($informasi->kategori == 'agenda' ? 'agenda' : 'galeri')) }}">
                                {{ ucfirst($informasi->kategori) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td><strong>{{ $informasi->judul }}</strong></td>
                    </tr>
                    <tr>
                        <th>Penulis</th>
                        <td>{{ $informasi->penulis }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Posting</th>
                        <td>{{ $informasi->tanggal_posting->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge-custom badge-{{ $informasi->status_publish == 'publish' ? 'publish' : 'draft' }}">
                                {{ ucfirst($informasi->status_publish) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <table class="table table-borderless detail-table">
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $informasi->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td>{{ $informasi->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($informasi->kategori == 'agenda' && isset($informasi->waktu_pelaksanaan))
                    <tr>
                        <th>Waktu Pelaksanaan</th>
                        <td>{{ \Carbon\Carbon::parse($informasi->waktu_pelaksanaan)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Isi -->
        <div class="mt-3">
            <h6 class="fw-bold" style="color: #1a472a; font-size: 0.95rem;">
                <i class="fas fa-align-left me-2" style="color: #1a472a;"></i>Isi Informasi
            </h6>
            <div class="content-box">
                {{ $informasi->isi }}
            </div>
        </div>

        <!-- Gambar -->
        @if($informasi->gambar)
        <div class="mt-3">
            <h6 class="fw-bold" style="color: #1a472a; font-size: 0.95rem;">
                <i class="fas fa-image me-2" style="color: #1a472a;"></i>Gambar
            </h6>
            <div class="img-container">
                <img src="{{ asset('storage/' . $informasi->gambar) }}" 
                     alt="{{ $informasi->judul }}" 
                     class="img-fluid rounded">
            </div>
        </div>
        @endif

        <!-- Tombol Aksi -->
        <div class="mt-4">
            <a href="{{ route('informasi.edit', $informasi->id_informasi) }}" class="btn btn-edit">Edit</a>
            <a href="{{ route('informasi.index') }}" class="btn btn-back">Kembali</a>
        </div>

    </div>
</div>

@endsection