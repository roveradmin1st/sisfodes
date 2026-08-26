@extends('layouts.public')

@section('title', 'Transparansi APBDes Tahun 2025 - Desa Sidomulyo')

@section('public-content')

<style>
    .apbdes-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        background: #ffffff;
    }
    .apbdes-header {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        padding: 30px 20px;
        text-align: center;
        position: relative;
    }
    .apbdes-header h2 {
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 4px;
        text-transform: uppercase;
        font-size: 1.8rem;
    }
    .apbdes-header h4 {
        font-weight: 700;
        margin-bottom: 2px;
        color: #ffc107;
        font-size: 1.3rem;
    }
    .apbdes-header p {
        font-size: 0.95rem;
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    .section-title-box {
        background: #1a472a;
        color: white;
        font-weight: 700;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 1rem;
        margin-top: 25px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .sub-section-title {
        font-weight: 700;
        color: #1a472a;
        font-size: 0.95rem;
        padding: 8px 12px;
        background: #e8f5e9;
        border-left: 4px solid #1a472a;
        margin-top: 16px;
        margin-bottom: 8px;
        border-radius: 4px;
    }

    .apbdes-table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }
    .apbdes-table th, .apbdes-table td {
        padding: 10px 16px;
        font-size: 0.9rem;
        vertical-align: middle;
    }
    .apbdes-table tbody tr:nth-child(even) {
        background-color: #f9fbf9;
    }
    .apbdes-table tbody tr:hover {
        background-color: #f1f8f3;
    }
    
    .row-jumlah-sub {
        font-weight: 700;
        background-color: #e8f4f8 !important;
        color: #0c5460;
        border-top: 1px solid #bee5eb;
        border-bottom: 1px solid #bee5eb;
    }
    .row-jumlah-total {
        font-weight: 800;
        font-size: 0.95rem;
        background: linear-gradient(135deg, #d4edda, #c3e6cb) !important;
        color: #155724;
        border-top: 2px solid #28a745;
        border-bottom: 2px solid #28a745;
    }
    .row-surplus {
        font-weight: 800;
        font-size: 1rem;
        background: linear-gradient(135deg, #cff4fc, #b6effb) !important;
        color: #055160;
        border-top: 2px solid #0dcaf0;
        border-bottom: 2px solid #0dcaf0;
    }

    .summary-box {
        border-radius: 14px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }
    .summary-box:hover {
        transform: translateY(-4px);
    }
</style>

<div class="container py-4">

    <!-- SUMMARY CARDS BANNER -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="summary-box shadow-sm bg-white border-top border-4 border-success">
                <div class="text-success fw-semibold mb-1" style="font-size: 0.85rem; text-transform: uppercase;">
                    <i class="fas fa-arrow-circle-down me-1"></i> Total Pendapatan Desa
                </div>
                <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="summary-box shadow-sm bg-white border-top border-4 border-danger">
                <div class="text-danger fw-semibold mb-1" style="font-size: 0.85rem; text-transform: uppercase;">
                    <i class="fas fa-arrow-circle-up me-1"></i> Total Belanja Desa
                </div>
                <h3 class="fw-bold text-danger mb-0">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- MAIN BOARD CONTAINER -->
    <div class="apbdes-card shadow-sm mb-5">
        
        <!-- POSTER HEADER -->
        <div class="apbdes-header">
            <div class="d-flex align-items-center justify-content-center gap-3 mb-2 flex-wrap">
                @if(file_exists(public_path('storage/logo-deli-serdang.png')))
                    <img src="{{ asset('storage/logo-deli-serdang.png') }}" style="height: 65px;" alt="Logo Deli Serdang">
                @endif
                <div>
                    <h2>INFORMASI DESA APBDes TAHUN 2025</h2>
                    <h4>DESA SIDOMULYO</h4>
                    <p>KECAMATAN BIRU-BIRU - KABUPATEN DELI SERDANG</p>
                </div>
            </div>
        </div>

        <div class="p-4">

            <!-- ========================================== -->
            <!-- I. PENDAPATAN DESA                         -->
            <!-- ========================================== -->
            <div class="section-title-box">
                <span>I. PENDAPATAN DESA</span>
                <span>JUMLAH (Rp)</span>
            </div>

            <div class="table-responsive">
                <table class="table apbdes-table">
                    <tbody>
                        @foreach($pendapatan as $item)
                        <tr>
                            <td class="ps-4 fw-semibold text-dark">{{ $item->uraian }}</td>
                            <td class="text-end fw-bold text-dark" style="width: 220px;">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="row-jumlah-total">
                            <td class="ps-4">JUMLAH PENDAPATAN</td>
                            <td class="text-end">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- ========================================== -->
            <!-- II. BELANJA DESA                           -->
            <!-- ========================================== -->
            <div class="section-title-box mt-5">
                <span>II. BELANJA DESA</span>
                <span>JUMLAH (Rp)</span>
            </div>

            @php
                $belanjaGrouped = $belanja->groupBy('sub_kategori');
            @endphp

            @foreach($belanjaGrouped as $subKat => $items)
                <div class="sub-section-title">
                    {{ $subKat }}
                </div>
                <div class="table-responsive mb-2">
                    <table class="table apbdes-table">
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td class="ps-4 text-dark">- {{ $item->uraian }}</td>
                                <td class="text-end fw-bold text-dark" style="width: 220px;">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="row-jumlah-sub">
                                @php
                                    $labelJumlah = 'JUMLAH ' . str_replace(['A. ', 'B. ', 'C. ', 'D. ', 'E. '], '', $subKat);
                                @endphp
                                <td class="ps-4">{{ strtoupper($labelJumlah) }}</td>
                                <td class="text-end">Rp {{ number_format($items->sum('jumlah'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endforeach

            <!-- JUMLAH BELANJA DESA -->
            <div class="table-responsive mt-3">
                <table class="table apbdes-table">
                    <tfoot>
                        <tr class="row-jumlah-total">
                            <td class="ps-4">JUMLAH BELANJA DESA</td>
                            <td class="text-end" style="width: 220px;">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- ========================================== -->
            <!-- III. PEMBIAYAAN DESA                       -->
            <!-- ========================================== -->
            <div class="section-title-box mt-5">
                <span>III. PEMBIAYAAN DESA</span>
                <span>JUMLAH (Rp)</span>
            </div>

            <div class="table-responsive">
                <table class="table apbdes-table">
                    <tbody>
                        @foreach($pembiayaan as $item)
                        <tr>
                            <td class="ps-4 text-dark">- {{ $item->uraian }}</td>
                            <td class="text-end fw-bold text-dark" style="width: 220px;">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- FOOTER NOTICE -->
            <div class="text-center mt-5 pt-3 border-top text-muted small">
                <strong>PEMERINTAH KABUPATEN DELI SERDANG</strong><br>
                KECAMATAN BIRU-BIRU - DESA SIDOMULYO
            </div>

        </div>
    </div>

</div>
@endsection
