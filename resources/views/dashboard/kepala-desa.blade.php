@extends('layouts.dashboard')

@section('page-title', 'Dashboard Kepala Desa')

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
    .card-body {
        padding: 20px 24px;
    }

    /* ===== NOTIFICATION ITEMS ===== */
    .notification-item {
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        border-radius: 14px;
        padding: 16px 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.03);
        position: relative;
        overflow: hidden;
        cursor: default;
    }
    .notification-item::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 3px;
        height: 100%;
        border-radius: 0 3px 3px 0;
        transition: all 0.3s ease;
    }
    .notification-item:hover {
        transform: translateX(5px) translateY(-3px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        border-color: rgba(0,0,0,0.06);
    }
    .notification-item .badge-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    .notification-item:hover .badge-icon {
        transform: scale(1.1);
    }
    .notification-item .badge-icon.bg-warning {
        background: linear-gradient(135deg, #fff3cd, #ffe69c) !important;
        color: #856404;
    }
    .notification-item .badge-icon.bg-danger {
        background: linear-gradient(135deg, #f8d7da, #f5b8b8) !important;
        color: #dc3545;
    }
    .notification-item .badge-icon.bg-success {
        background: linear-gradient(135deg, #d4edda, #a8e0b0) !important;
        color: #1a472a;
    }
    .notification-item .stat-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.2;
    }
    .notification-item .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
    }
    .notification-item .stat-status {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 12px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 2px;
    }
    .notification-item .stat-status.text-warning {
        background: rgba(255, 193, 7, 0.15);
        color: #856404;
    }
    .notification-item .stat-status.text-danger {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    .notification-item .stat-status.text-success {
        background: rgba(26, 71, 42, 0.1);
        color: #1a472a;
    }

    /* ===== TABLE BANTUAN ===== */
    .table {
        margin-bottom: 0;
        font-size: 0.85rem;
    }
    .table thead th {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        font-weight: 600;
        padding: 10px 14px;
        border-bottom: none;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .table thead th:first-child {
        border-radius: 8px 0 0 0;
    }
    .table thead th:last-child {
        border-radius: 0 8px 0 0;
    }
    .table tbody td {
        padding: 10px 14px;
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
    }
    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== CHART CONTAINER ===== */
    .chart-container {
        position: relative;
        height: 280px;
    }

    /* ===== SCROLLBAR ===== */
    .card-body::-webkit-scrollbar {
        width: 4px;
    }
    .card-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .card-body::-webkit-scrollbar-thumb {
        background: #1a472a;
        border-radius: 10px;
    }
    .card-body::-webkit-scrollbar-thumb:hover {
        background: #2d6a4f;
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
        .stat-card .stat-number {
            font-size: 1.8rem;
        }
        .stat-card {
            padding: 18px;
        }
        .notification-item {
            padding: 14px 16px;
        }
        .card-header {
            padding: 14px 18px;
        }
        .card-body {
            padding: 16px 18px;
        }
        .chart-container {
            height: 200px;
        }
        .table thead th {
            font-size: 0.65rem;
            padding: 8px 10px;
        }
        .table tbody td {
            padding: 8px 10px;
            font-size: 0.75rem;
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
        .notification-item .stat-value {
            font-size: 1.1rem;
        }
        .chart-container {
            height: 180px;
        }
    }
</style>

<!-- ============================================================ -->
<!-- STATISTICS CARDS                                              -->
<!-- ============================================================ -->
<div class="row g-4 mb-4">
    <div class="col-md-4 animate-on-scroll" style="animation-delay: 0.1s;">
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
    <div class="col-md-4 animate-on-scroll" style="animation-delay: 0.2s;">
        <div class="stat-card" style="border-left-color: #0d6efd;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label mb-1">
                        <i class="fas fa-file-alt me-1" style="color: #0d6efd;"></i>
                        Pengajuan Surat Keterangan
                    </p>
                    <h3 class="stat-number" style="background: linear-gradient(135deg, #0d6efd, #0a58ca); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">{{ $totalPengajuan }}</h3>
                </div>
                <div class="icon bg-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-on-scroll" style="animation-delay: 0.3s;">
        <div class="stat-card" style="border-left-color: #dc3545;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label mb-1">
                        <i class="fas fa-comment me-1" style="color: #dc3545;"></i>
                        Kritik & Saran Terbaru
                    </p>
                    <h3 class="stat-number" style="background: linear-gradient(135deg, #dc3545, #b02a37); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">{{ $kritikSaran->count() }}</h3>
                </div>
                <div class="icon bg-danger">
                    <i class="fas fa-comment"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- GRAFIK PENDUDUK + DAFTAR PENERIMA BANTUAN                   -->
<!-- ============================================================ -->
<div class="row g-4 mb-4">
    <!-- Grafik Penduduk -->
    <div class="col-md-8 animate-on-scroll" style="animation-delay: 0.4s;">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-chart-bar me-2 text-success"></i>Grafik Penduduk
                </h5>
                <div>
                    <span class="badge" style="background: linear-gradient(135deg, #1a472a, #2d6a4f); color: white; padding: 6px 14px; border-radius: 20px; font-weight: 500;">2026</span>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="pendudukChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Penerima Bantuan -->
    <div class="col-md-4 animate-on-scroll" style="animation-delay: 0.5s;">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-hand-holding-heart me-2 text-success"></i>Daftar Penerima Bantuan
                </h5>
                <a href="{{ route('bantuan.index') }}" class="btn btn-sm btn-link text-success p-0" style="transition: all 0.3s ease;">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto; padding: 0;">
                @if(isset($penerimaBantuan) && $penerimaBantuan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Program</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penerimaBantuan as $item)
                                <tr>
                                    <td><span class="fw-bold" style="color: #1a472a;">{{ $loop->iteration }}</span></td>
                                    <td><strong>{{ $item->penduduk->nama ?? '-' }}</strong></td>
                                    <td>{{ Str::limit($item->program_bantuan, 15) }}</td>
                                    <td>
                                        <span class="badge badge-status-sm bg-{{ $item->status == 'diterima' ? 'success' : 'warning' }}" style="font-size: 0.6rem; padding: 4px 12px; border-radius: 20px; font-weight: 600; background: {{ $item->status == 'diterima' ? 'linear-gradient(135deg, #d4edda, #a8e0b0)' : 'linear-gradient(135deg, #fff3cd, #ffe69c)' }}; color: {{ $item->status == 'diterima' ? '#1a472a' : '#856404' }};">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-inbox" style="font-size: 2.5rem; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                        <p class="small">Belum ada data penerima bantuan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- NOTIFIKASI (DI BAWAH)                                        -->
<!-- ============================================================ -->
<div class="row g-4">
    <div class="col-12 animate-on-scroll" style="animation-delay: 0.6s;">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-bell me-2 text-warning"></i>Notifikasi
                    <span class="badge" style="background: linear-gradient(135deg, #dc3545, #b02a37); color: white; border-radius: 20px; padding: 4px 14px; font-size: 0.7rem; margin-left: 6px;">{{ $notifikasiCount ?? 0 }}</span>
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Notifikasi 1: Menunggu Verifikasi -->
                    <div class="col-md-4">
                        <div class="notification-item">
                            <div class="d-flex align-items-start">
                                <div class="badge-icon bg-warning me-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="stat-value">{{ $menungguVerifikasi }}</div>
                                    <div class="stat-label">Pengajuan menunggu verifikasi</div>
                                    <span class="stat-status text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Perlu tindakan segera
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notifikasi 2: Kritik & Saran -->
                    <div class="col-md-4">
                        <div class="notification-item">
                            <div class="d-flex align-items-start">
                                <div class="badge-icon bg-danger me-3">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="stat-value">{{ $kritikSaran->count() }}</div>
                                    <div class="stat-label">Kritik & saran baru</div>
                                    <span class="stat-status text-danger">
                                        <i class="fas fa-hourglass-half me-1"></i>Belum dibalas
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notifikasi 3: Total Pengajuan -->
                    <div class="col-md-4">
                        <div class="notification-item">
                            <div class="d-flex align-items-start">
                                <div class="badge-icon bg-success me-3">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="stat-value">{{ $totalPengajuan }}</div>
                                    <div class="stat-label">Total pengajuan surat</div>
                                    <span class="stat-status text-success">
                                        <i class="fas fa-check-circle me-1"></i>Sepanjang waktu
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- CHART.JS SCRIPT                                              -->
<!-- ============================================================ -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('pendudukChart').getContext('2d');

        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const dataPenduduk = <?php echo json_encode($grafikPenduduk ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]); ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: dataPenduduk,
                    backgroundColor: 'rgba(26, 71, 42, 0.6)',
                    borderColor: '#1a472a',
                    borderWidth: 2,
                    borderRadius: 6,
                    hoverBackgroundColor: 'rgba(26, 71, 42, 0.8)',
                    hoverBorderColor: '#2d6a4f',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'white',
                        titleColor: '#1a472a',
                        bodyColor: '#2d3748',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        cornerRadius: 10,
                        padding: 12,
                        boxShadow: '0 4px 20px rgba(0,0,0,0.08)'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    });

    // ===== SCROLL ANIMATION =====
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