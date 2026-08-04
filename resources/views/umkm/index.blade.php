@extends('layouts.dashboard')

@section('page-title', 'Kelola UMKM Desa')

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

    /* ===== FORM CONTROL & FILTER ===== */
    .filter-select {
        border-radius: 10px;
        padding: 7px 12px;
        border: 2px solid #e9ecef;
        background: white;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .filter-select:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
    }
    .btn-tambah {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        padding: 8px 18px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-tambah:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
        color: white;
    }

    .btn-filter {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        padding: 7px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-filter:hover {
        color: white;
        transform: translateY(-2px);
    }
    .btn-reset-filter {
        background: #e9ecef;
        color: #495057;
        padding: 7px 12px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
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
    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    /* ===== ACTION BUTTONS ===== */
    .btn-action-group .btn {
        border-radius: 8px !important;
        padding: 5px 10px;
        font-size: 0.72rem;
        font-weight: 600;
        margin: 0 2px;
        border: none;
    }
    .btn-detail {
        background: #e3f2fd;
        color: #0d47a1;
    }
    .btn-edit {
        background: #fff3cd;
        color: #856404;
    }
    .btn-hapus {
        background: #f8d7da;
        color: #721c24;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="card-title mb-0 fw-bold">
            Kelola UMKM Desa Sidomulyo
        </h5>
        @if(Auth::user()->role == 'kaur_umum')
        <a href="{{ route('umkm.create') }}" class="btn-tambah">
            <i class="fas fa-plus"></i> + Tambah Usaha / Produk UMKM
        </a>
        @endif
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Pencarian & Filter -->
        <div class="row mb-3 align-items-center g-2">
            <div class="col-md-8">
                <form action="{{ route('umkm.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="position-relative flex-grow-1" style="min-width: 200px;">
                        <input type="text" 
                               name="keyword" 
                               class="form-control filter-select" 
                               placeholder="🔍 Cari nama usaha / pemilik..." 
                               value="{{ request('keyword') }}"
                               style="height: 38px;">
                    </div>

                    <select name="kategori" class="form-select filter-select" style="max-width: 160px; height: 38px;">
                        <option value="">Semua Kategori</option>
                        <option value="Kuliner" {{ request('kategori') == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                        <option value="Kerajinan" {{ request('kategori') == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                        <option value="Pertanian" {{ request('kategori') == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                        <option value="Fashion" {{ request('kategori') == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                        <option value="Jasa" {{ request('kategori') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                        <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>

                    <button type="submit" class="btn btn-filter" style="height: 38px;">Cari</button>

                    @if(request('keyword') || request('kategori'))
                        <a href="{{ route('umkm.index') }}" class="btn btn-reset-filter" style="height: 38px; line-height: 22px;">Reset ✕</a>
                    @endif
                </form>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('public.umkm') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold">
                    Lihat Tampilan Publik <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                </a>
            </div>
        </div>

        <!-- Tabel UMKM -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 70px;">Foto</th>
                        <th>Nama Usaha</th>
                        <th>Pemilik</th>
                        <th>Kategori</th>
                        <th>Kontak (WA)</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th style="width: 130px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($umkm as $item)
                    <tr>
                        <td><span class="fw-bold" style="color: #1a472a;">{{ $loop->iteration + ($umkm->currentPage() - 1) * $umkm->perPage() }}</span></td>
                        <td>
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div class="bg-light border text-center rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                    <i class="fas fa-store" style="font-size: 1.2rem;"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong style="color: #1a472a;">{{ $item->nama_usaha }}</strong></td>
                        <td>{{ $item->pemilik }}</td>
                        <td><span class="badge bg-secondary px-2 py-1">{{ $item->kategori }}</span></td>
                        <td>{{ $item->no_hp ?? '-' }}</td>
                        <td><span class="fw-bold text-success">{{ $item->harga ?? '-' }}</span></td>
                        <td>
                            <span class="badge {{ $item->status == 'publish' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-action-group d-flex justify-content-center">
                                <a href="{{ route('umkm.show', $item->id_umkm) }}" class="btn btn-detail" title="Detail"><i class="fas fa-eye"></i></a>
                                @if(Auth::user()->role == 'kaur_umum')
                                <a href="{{ route('umkm.edit', $item->id_umkm) }}" class="btn btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('umkm.destroy', $item->id_umkm) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-hapus" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="fas fa-store-slash" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            Belum ada data UMKM desa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap" style="gap: 12px;">
            <span class="text-muted small">
                Menampilkan {{ $umkm->firstItem() ?? 0 }} - {{ $umkm->lastItem() ?? 0 }} dari {{ $umkm->total() }} data
            </span>
            {{ $umkm->links() }}
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Data UMKM?',
                text: "Data produk/usaha UMKM ini akan dihapus dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush

@endsection
