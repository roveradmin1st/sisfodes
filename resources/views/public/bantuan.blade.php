@extends('layouts.public')

@section('title', 'Data Penerima Bantuan - Desa Sidomulyo')

@section('public-content')

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
    .card-body {
        padding: 0;
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
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
        font-size: 0.9rem;
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
    .table tbody td:first-child {
        font-weight: 600;
        color: #1a472a;
    }
    .table tbody td:nth-child(2) {
        font-weight: 600;
        color: #1a472a;
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

    /* ===== BUTTON STYLING ===== */
    .btn-action {
        padding: 8px 24px;
        border-radius: 10px;
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

    .btn-kembali {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
    }
    .btn-kembali:hover {
        box-shadow: 0 4px 15px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .table thead th {
            font-size: 0.65rem;
            padding: 8px 10px;
        }
        .table tbody td {
            padding: 8px 10px;
            font-size: 0.75rem;
        }
        .pagination .page-item .page-link {
            padding: 6px 10px;
            font-size: 0.75rem;
        }
        .btn-action {
            padding: 6px 16px;
            font-size: 0.8rem;
            width: 100%;
            justify-content: center;
        }
        .mt-3 .btn-action {
            width: 100%;
            justify-content: center;
        }
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 8px;
            align-items: flex-start !important;
        }
        .d-flex.justify-content-between span {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .table thead th {
            font-size: 0.55rem;
            padding: 6px 6px;
        }
        .table tbody td {
            padding: 6px 6px;
            font-size: 0.65rem;
        }
        .pagination .page-item .page-link {
            padding: 4px 8px;
            font-size: 0.65rem;
        }
        .btn-action {
            padding: 5px 12px;
            font-size: 0.7rem;
        }
    }
</style>

<div class="container py-5" style="background-color: #f8faf9;">
    
    <div class="mb-4 text-center">
        <h3 class="fw-bold text-dark text-uppercase mb-0">Data Penerima Bantuan</h3>
        <p class="text-muted mt-2 mb-0">Informasi Penerima Bantuan Langsung Tunai (BLT) Desa Sidomulyo</p>
    </div>

    <!-- Form Filter Nama & Tahun -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <form action="{{ route('public.bantuan') }}" method="GET" class="card p-3 shadow-sm border-0 rounded-4" style="background: white;">
                <div class="row g-2 align-items-center">
                    <!-- Input Nama / NIK -->
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-search"></i></span>
                            <input type="text" 
                                   name="keyword" 
                                   class="form-control border-0 bg-light" 
                                   placeholder="🔍 Cari nama penerima / NIK / alamat..." 
                                   value="{{ request('keyword') }}"
                                   style="font-size: 0.9rem;">
                        </div>
                    </div>

                    <!-- Filter Tahun -->
                    <div class="col-md-3">
                        <select name="tahun" class="form-select border-0 bg-light" style="font-size: 0.9rem; cursor: pointer;" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            @foreach($daftarTahun as $t)
                                <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>Tahun {{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Filter & Reset -->
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold" style="background: #0d2b5e; border-color: #0d2b5e; border-radius: 8px;">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        @if(request('keyword') || request('tahun'))
                            <a href="{{ route('public.bantuan') }}" class="btn btn-outline-secondary" style="border-radius: 8px;" title="Reset Filter">
                                <i class="fas fa-redo"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Penerima</th>
                        <th>Alamat</th>
                        <th>Program Bantuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penerima as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($penerima->currentPage() - 1) * $penerima->perPage() }}</td>
                        <td>{{ $item->penduduk->nama ?? '-' }}</td>
                        <td>{{ Str::limit($item->penduduk->alamat ?? '-', 30) }}</td>
                        <td>{{ $item->program_bantuan }}</td>
                        <td>
                            <span class="badge px-3 py-1 text-uppercase fs-7 
                                @if($item->status == 'diterima') bg-success 
                                @elseif($item->status == 'diproses') bg-primary 
                                @else bg-warning text-dark @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            @if(!request('tahun'))
                                <i class="fas fa-calendar-alt text-primary" style="font-size: 3rem; display: block; margin-bottom: 12px; opacity: 0.7;"></i>
                                <h6 class="fw-bold text-dark mb-1">Silakan Pilih Tahun Penerimaan Bantuan</h6>
                                <p class="small text-muted mb-0">Pilih tahun pada opsi filter di atas untuk menampilkan daftar data penerima bantuan.</p>
                            @else
                                <i class="fas fa-inbox" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                                Tidak ada data penerima bantuan yang ditemukan untuk tahun {{ request('tahun') }}.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap" style="gap: 12px;">
    <span class="text-muted small">
        Menampilkan {{ $penerima->firstItem() ?? 0 }} - {{ $penerima->lastItem() ?? 0 }} 
        dari {{ $penerima->total() }} data
    </span>
    {{ $penerima->links() }}
</div>

<div class="mt-4 text-center">
    <a href="{{ route('home') }}" class="btn-action btn-kembali">Kembali ke Beranda</a>
</div>

</div>
@endsection