@extends('layouts.public')

@section('title', 'Transparansi APBDes - Desa Sidomulyo')

@section('public-content')
<div class="page-header text-center py-4 bg-success text-white">
    <div class="container">
        <h2 class="fw-bold mb-1"><i class="fas fa-coins me-2"></i>Transparansi APBDes Tahun 2025</h2>
        <p class="mb-0 text-white-50">Anggaran Pendapatan dan Belanja Desa Sidomulyo Kecamatan Biru-Biru</p>
    </div>
</div>

<div class="container py-5">
    <!-- SUMMARY CARDS -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 text-center h-100">
                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-wallet fs-3"></i>
                </div>
                <h6 class="text-muted fw-semibold">Total Pendapatan Desa</h6>
                <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 text-center h-100">
                <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-shopping-cart fs-3"></i>
                </div>
                <h6 class="text-muted fw-semibold">Total Belanja Desa</h6>
                <h3 class="fw-bold text-danger mb-0">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 text-center h-100">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-chart-line fs-3"></i>
                </div>
                <h6 class="text-muted fw-semibold">Surplus / Defisit</h6>
                <h3 class="fw-bold text-primary mb-0">Rp {{ number_format($surplus, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- DETAIL RINCIAN TABLES -->
    <div class="row g-4">
        <!-- 1. PENDAPATAN -->
        <div class="col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-arrow-down me-2"></i>I. Rincian Pendapatan Desa</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Uraian Pendapatan</th>
                                <th class="text-end">Jumlah (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendapatan as $item)
                                <tr>
                                    <td>{{ $item->uraian }}</td>
                                    <td class="text-end fw-bold text-success">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td>JUMLAH PENDAPATAN</td>
                                <td class="text-end text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- 2. BELANJA -->
        <div class="col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-arrow-up me-2"></i>II. Rincian Belanja Desa</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Bidang / Sub Bidang Belanja</th>
                                <th class="text-end">Jumlah (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($belanja as $item)
                                <tr>
                                    <td>
                                        <span class="d-block fw-semibold text-dark">{{ $item->uraian }}</span>
                                        <small class="text-muted">{{ $item->kategori }}</small>
                                    </td>
                                    <td class="text-end fw-bold text-danger">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td>JUMLAH BELANJA DESA</td>
                                <td class="text-end text-danger">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
