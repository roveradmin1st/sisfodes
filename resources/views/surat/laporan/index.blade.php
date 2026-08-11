@extends('layouts.dashboard')

@section('page-title', 'Laporan Pengurusan Surat Keterangan')

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
        font-size: 1rem;
    }
    .card-body {
        padding: 24px;
    }

    /* ===== FILTER ===== */
    .filter-select {
        border-radius: 10px !important;
        border: 2px solid #e9ecef !important;
        padding: 8px 16px !important;
        font-size: 0.9rem;
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
        border: none;
        padding: 10px 24px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(26, 71, 42, 0.2);
    }
    .btn-filter:hover {
        background: linear-gradient(135deg, #2d6a4f, #1a472a);
        color: white;
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
    }
    
    .btn-cetak {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(13, 110, 253, 0.2);
    }
    .btn-cetak:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        color: white;
    }

    /* ===== TABLE STYLING ===== */
    .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    .table thead th {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        font-weight: 600;
        padding: 14px 16px;
        border-bottom: none;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }
    .table thead th:first-child {
        border-radius: 10px 0 0 0;
    }
    .table thead th:last-child {
        border-radius: 0 10px 0 0;
    }
    .table tbody td, .table tfoot td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    .table tbody tr {
        transition: all 0.3s ease;
    }
    .table tbody tr:hover {
        background: linear-gradient(90deg, #f8f9fa, #ffffff);
        transform: scale(1.005);
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .table tfoot {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    /* ===== BADGE TOTAL ===== */
    .badge-total {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        box-shadow: 0 2px 10px rgba(26, 71, 42, 0.15);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: stretch !important;
            gap: 12px;
        }
        .table thead th {
            font-size: 0.75rem;
            padding: 10px 12px;
        }
        .table tbody td, .table tfoot td {
            padding: 10px 12px;
            font-size: 0.8rem;
        }
        .card-body {
            padding: 16px;
        }
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        .card-body table, .card-body table *, #print-title {
            visibility: visible;
        }
        #print-title {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .card-body table {
            position: absolute;
            left: 0;
            top: 50px;
            width: 100%;
        }
        .card-header, form, .btn, .d-print-none {
            display: none !important;
        }
        .card {
            box-shadow: none !important;
        }
        .table thead th {
            color: #000 !important;
            background: #e9ecef !important;
            -webkit-print-color-adjust: exact;
        }
        .badge-total {
            color: #000 !important;
            background: transparent !important;
            border: 1px solid #000;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<div class="row mb-4 d-print-none">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('surat.laporan.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="color: #1a472a; font-weight: 600;">Filter Bulan</label>
                        <select name="bulan" class="form-select filter-select">
                            @php
                                $months = [
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                    '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ];
                            @endphp
                            @foreach($months as $key => $name)
                                <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="color: #1a472a; font-weight: 600;">Filter Tahun</label>
                        <select name="tahun" class="form-select filter-select">
                            @php
                                $currentYear = date('Y');
                            @endphp
                            @for($i = $currentYear; $i >= $currentYear - 5; $i--)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-filter w-100">
                            Tampilkan Rekapan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">
            Rekapan Laporan (Bulan {{ $months[$bulan] }} {{ $tahun }})
        </h5>
        <button onclick="window.print()" class="btn btn-cetak d-print-none">
            <i class="fas fa-print me-1"></i> Cetak PDF
        </button>
    </div>
    <div class="card-body position-relative">
        
        <h4 id="print-title" style="visibility: hidden; display: none;">Laporan Pengurusan Surat Keterangan - {{ $months[$bulan] }} {{ $tahun }}</h4>
        
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th class="text-start">Jenis Surat Keterangan</th>
                        <th>Total Pengajuan</th>
                        <th>Diproses</th>
                        <th>Selesai</th>
                        <th>Ditolak</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; $totalSemua = 0; $totalProses = 0; $totalSelesai = 0; $totalTolak = 0; @endphp
                    @forelse($laporan as $data)
                        @php 
                            $totalSemua += $data['total'];
                            $totalProses += $data['diproses'];
                            $totalSelesai += $data['selesai'];
                            $totalTolak += $data['ditolak'];
                        @endphp
                        <tr>
                            <td><span class="fw-bold" style="color: #1a472a;">{{ $no++ }}</span></td>
                            <td class="text-start"><strong style="color: #1a472a;">{{ $data['nama_surat'] }}</strong></td>
                            <td><span class="badge badge-total">{{ $data['total'] }}</span></td>
                            <td><span class="text-warning fw-bold">{{ $data['diproses'] }}</span></td>
                            <td><span class="text-success fw-bold">{{ $data['selesai'] }}</span></td>
                            <td><span class="text-danger fw-bold">{{ $data['ditolak'] }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Belum ada data permohonan surat di bulan ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="fw-bold">
                    <tr>
                        <td colspan="2" class="text-end pe-4">TOTAL KESELURUHAN:</td>
                        <td><span class="badge badge-total" style="font-size: 1rem;">{{ $totalSemua }}</span></td>
                        <td class="text-warning fs-5">{{ $totalProses }}</td>
                        <td class="text-success fs-5">{{ $totalSelesai }}</td>
                        <td class="text-danger fs-5">{{ $totalTolak }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
    </div>
</div>

@endsection
