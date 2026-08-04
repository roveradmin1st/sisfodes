@extends('layouts.dashboard')

@section('page-title', 'Data Penerima Bantuan')

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
    .btn-lihat-public {
        border-radius: 10px !important;
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white;
        border: none;
        padding: 6px 18px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-lihat-public:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        color: white;
    }
    .badge-total {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        padding: 6px 18px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        box-shadow: 0 2px 10px rgba(26, 71, 42, 0.15);
        margin-left: 8px;
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

    /* ===== BADGE STATUS ===== */
    .badge-status {
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .badge-diterima {
        background: linear-gradient(135deg, #d4edda, #a8e0b0);
        color: #1a472a;
    }
    .badge-diproses {
        background: linear-gradient(135deg, #e3f2fd, #90caf9);
        color: #0d47a1;
    }
    .badge-dialihkan {
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
    .btn-edit {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
    }
    .btn-edit:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(133, 100, 4, 0.2);
        color: #856404;
    }
    .btn-hapus {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }
    .btn-hapus:hover {
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

    /* ===== BOTTOM BUTTONS ===== */
    .btn-action-bottom {
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
    .btn-action-bottom:hover {
        transform: translateY(-2px) scale(1.03);
    }
    .btn-action-bottom:active {
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
    .btn-tambah-bottom {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.2);
    }
    .btn-tambah-bottom:hover {
        box-shadow: 0 6px 25px rgba(26, 71, 42, 0.3);
        color: white;
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
        .btn-lihat-public {
            width: 100%;
            text-align: center;
        }
        .badge-total {
            display: inline-block;
            margin-top: 6px;
        }
        .mt-3 {
            flex-direction: column;
            gap: 8px;
        }
        .mt-3 .btn-action-bottom {
            width: 100%;
            justify-content: center;
        }
        .mt-3 .btn-action-bottom:not(:last-child) {
            margin-bottom: 4px;
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
        .badge-status {
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
        .btn-action-bottom {
            padding: 6px 14px;
            font-size: 0.7rem;
        }
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">
            Daftar Penerima Bantuan
        </h5>
        @if(Auth::user()->role == 'kaur_umum')
        <a href="{{ route('bantuan.create') }}" class="btn btn-tambah">
            + Tambah Penerima Bantuan
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

        <!-- Pencarian & Filter Status -->
        <div class="row mb-3 align-items-center g-2">
            <div class="col-md-7">
                <form action="{{ route('bantuan.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Input Pencarian Nama / NIK -->
                    <div class="position-relative flex-grow-1" style="min-width: 200px;">
                        <input type="text" 
                               name="keyword" 
                               class="form-control form-control-sm filter-select" 
                               placeholder="🔍 Cari nama / NIK penerima..." 
                               value="{{ request('keyword') }}"
                               style="height: 38px; border-radius: 10px;">
                    </div>

                    <!-- Filter Status -->
                    <select name="status" class="form-select filter-select" style="max-width: 160px; height: 38px; border-radius: 10px;">
                        <option value="">Semua Status</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="dialihkan" {{ request('status') == 'dialihkan' ? 'selected' : '' }}>Dialihkan</option>
                    </select>

                    <button type="submit" class="btn btn-filter" style="height: 38px; border-radius: 10px; padding: 0 16px;">Cari</button>

                    @if(request('keyword') || request('status'))
                        <a href="{{ route('bantuan.index') }}" class="btn btn-reset-filter" title="Reset Pencarian" style="height: 38px; line-height: 24px; border-radius: 10px; padding: 0 12px;">Reset ✕</a>
                    @endif
                </form>
            </div>
            <div class="col-md-5 text-md-end mt-2 mt-md-0 d-flex align-items-center justify-content-md-end justify-content-between gap-2">
                <a href="{{ route('public.bantuan') }}" target="_blank" class="btn btn-lihat-public">
                    Lihat Daftar Penerima Bantuan
                </a>
                <span class="badge badge-total">{{ $penerima->total() }} Total</span>
            </div>
        </div>

        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>NIK</th>
                        <th>NKK</th>
                        <th>Alamat</th>
                        <th>Pekerjaan</th>
                        <th>Keterangan</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penerima as $item)
                    <tr>
                        <td><span class="fw-bold" style="color: #1a472a;">{{ $loop->iteration + ($penerima->currentPage() - 1) * $penerima->perPage() }}</span></td>
                        <td><strong style="color: #1a472a;">{{ $item->penduduk->nama ?? '-' }}</strong></td>
                        <td>
                            @if($item->penduduk && $item->penduduk->tanggal_lahir)
                                {{ $item->penduduk->tanggal_lahir->age }} Thn
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->penduduk->nik ?? '-' }}</td>
                        <td>{{ $item->penduduk->no_kk ?? '-' }}</td>
                        <td>{{ Str::limit($item->penduduk->alamat ?? '-', 25) }}</td>
                        <td>{{ $item->penduduk->pekerjaan ?? '-' }}</td>
                        <td>
                            <span class="badge-status badge-{{ $item->status }}">
                                {{ ucfirst($item->status) }}
                            </span>
                            <br>
                            <small class="text-success fw-bold" style="font-size: 0.7rem;">{{ $item->program_bantuan }}</small>
                            @if($item->keterangan)
                                <br><small class="text-muted" style="font-size: 0.65rem;"><em>({{ $item->keterangan }})</em></small>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('bantuan.show', $item->id_penerima) }}" 
                                   class="btn btn-detail" title="Detail">
                                    Detail
                                </a>
                                @if(Auth::user()->role == 'kaur_umum')
                                <a href="{{ route('bantuan.edit', $item->id_penerima) }}" 
                                   class="btn btn-edit" title="Edit">
                                    Edit
                                </a>
                                <button type="button" 
                                        class="btn btn-hapus btn-delete" 
                                        data-id="{{ $item->id_penerima }}"
                                        data-nama="{{ $item->penduduk->nama ?? 'Data' }}"
                                        title="Hapus">
                                    Hapus
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            Belum ada data penerima bantuan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap" style="gap: 12px;">
            <span class="text-muted small">
                Menampilkan {{ $penerima->firstItem() ?? 0 }} - {{ $penerima->lastItem() ?? 0 }} 
                dari {{ $penerima->total() }} data
            </span>
            {{ $penerima->appends(request()->query())->links() }}
        </div>

        {{-- <!-- Tombol Aksi -->
        <div class="mt-3 d-flex gap-3 flex-wrap">
            <a href="{{ route('dashboard.kaur-umum') }}" class="btn-action-bottom btn-kembali">Kembali</a>
            <a href="{{ route('bantuan.create') }}" class="btn-action-bottom btn-tambah-bottom">Tambah Data</a>
        </div> --}}

    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            
            Swal.fire({
                title: 'Hapus Data?',
                html: `
                    <div style="text-align: center;">
                        <i class="fas fa-hand-holding-heart" style="font-size: 3rem; color: #dc3545; margin-bottom: 15px; display: block;"></i>
                        <p style="font-size: 1rem; margin-bottom: 5px;">Apakah Anda yakin ingin menghapus data</p>
                        <p style="font-size: 1.1rem; font-weight: 700; color: #1a472a;">"${nama}"</p>
                        <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan!</p>
                    </div>
                `,
                icon: null,
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
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
                        form.action = `{{ route('bantuan.index') }}/${id}`;
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
</script>
@endpush

@endsection