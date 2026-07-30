@extends('layouts.dashboard')

@section('page-title', 'Jenis Surat Keterangan')

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
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(26, 71, 42, 0.2);
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

    /* ===== SEARCH FORM ===== */
    .search-input {
        border-radius: 10px 0 0 10px !important;
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
    .btn-search {
        border-radius: 0 10px 10px 0 !important;
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        border: 2px solid #1a472a;
        padding: 10px 20px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .btn-search:hover {
        background: linear-gradient(135deg, #2d6a4f, #1a472a);
        color: white;
        transform: scale(1.02);
    }
    .btn-reset {
        border-radius: 0 10px 10px 0 !important;
        background: #dc3545;
        color: white;
        border: 2px solid #dc3545;
        padding: 10px 16px;
        transition: all 0.3s ease;
        margin-left: -1px;
    }
    .btn-reset:hover {
        background: #b02a37;
        border-color: #b02a37;
        color: white;
        transform: scale(1.02);
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
    .table tbody td {
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
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    .table tbody tr:nth-child(even) {
        background: #fafbfc;
    }
    .table tbody tr:nth-child(even):hover {
        background: linear-gradient(90deg, #f8f9fa, #ffffff);
    }
    .table .text-muted {
        color: #adb5bd !important;
    }

    /* ===== BADGE TOTAL ===== */
    .badge-total {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        padding: 6px 18px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        box-shadow: 0 2px 10px rgba(26, 71, 42, 0.15);
    }

    /* ===== TEMPLATE BUTTON ===== */
    .btn-template {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #0d47a1;
        border: none;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-template:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(13, 71, 161, 0.2);
        color: #0d47a1;
    }

    /* ===== ACTION BUTTONS ===== */
    .btn-group .btn {
        border-radius: 8px !important;
        padding: 6px 16px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0 2px;
    }
    .btn-group .btn-edit {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
        border: none;
    }
    .btn-group .btn-edit:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(133, 100, 4, 0.2);
        color: #856404;
    }
    .btn-group .btn-delete-action {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border: none;
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
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
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
            font-size: 0.75rem;
            padding: 10px 12px;
        }
        .table tbody td {
            padding: 10px 12px;
            font-size: 0.8rem;
        }
        .card-body {
            padding: 16px;
        }
        .pagination .page-item .page-link {
            padding: 6px 10px;
            font-size: 0.8rem;
        }
        .btn-group .btn {
            padding: 4px 10px;
            font-size: 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .table thead th {
            font-size: 0.65rem;
            padding: 8px 6px;
        }
        .table tbody td {
            padding: 8px 6px;
            font-size: 0.7rem;
        }
        .btn-template {
            font-size: 0.6rem;
            padding: 4px 8px;
        }
        .btn-group .btn {
            font-size: 0.6rem;
            padding: 4px 8px;
        }
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">
            Jenis Surat Keterangan
        </h5>
        @if(Auth::user()->role == 'kaur_umum')
            <a href="{{ route('surat.jenis.create') }}" class="btn btn-tambah">
                Tambah Jenis Surat
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

        <!-- Search -->
        <div class="row mb-3 align-items-center">
            <div class="col-md-6">
                <form action="{{ route('surat.jenis.index') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" 
                               name="search" 
                               class="form-control search-input" 
                               placeholder="Cari Jenis Surat..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-search" type="submit">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('surat.jenis.index') }}" class="btn btn-reset">
                                ✕
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <span class="badge badge-total">
                    {{ $jenisSurat->total() }} Total
                </span>
            </div>
        </div>

        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Jenis Surat</th>
                        <th>Format Surat</th>
                        <th>Deskripsi</th>
                        <th>Persyaratan</th>
                        @if(Auth::user()->role == 'kaur_umum')
                            <th style="width: 120px;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisSurat as $item)
                    <tr>
                        <td><span class="fw-bold" style="color: #1a472a;">{{ $loop->iteration + ($jenisSurat->currentPage() - 1) * $jenisSurat->perPage() }}</span></td>
                        <td><strong style="color: #1a472a;">{{ $item->nama_surat }}</strong></td>
                        <td>
                            @if($item->template_surat)
                                <a href="{{ asset('storage/' . $item->template_surat) }}" target="_blank" class="btn btn-template">
                                    Template
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div style="max-width: 200px; word-wrap: break-word; white-space: normal; font-size: 0.85rem; line-height: 1.4;">
                                {{ $item->deskripsi }}
                            </div>
                        </td>
                        <td>
                            <div style="max-width: 300px; word-wrap: break-word; white-space: normal; font-size: 0.85rem; line-height: 1.6;">
                                @php
                                    // Pisahkan persyaratan berdasarkan newline atau nomor
                                    $syaratArray = preg_split('/\r\n|\n|\r/', $item->syarat);
                                    $hasNumber = false;
                                @endphp
                                
                                @if(count($syaratArray) > 1)
                                    @foreach($syaratArray as $syarat)
                                        @if(trim($syarat) != '')
                                            <div style="margin-bottom: 3px; display: flex; align-items: flex-start; gap: 4px;">
                                                <span style="color: #1a472a;">•</span>
                                                <span>{{ trim($syarat) }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    {{ $item->syarat }}
                                @endif
                            </div>
                        </td>
                        @if(Auth::user()->role == 'kaur_umum')
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('surat.jenis.edit', $item->id_jenis_surat) }}" 
                                       class="btn btn-edit" title="Edit">
                                        Edit
                                    </a>
                                    <button type="button" 
                                            class="btn btn-delete-action btn-delete" 
                                            data-id="{{ $item->id_jenis_surat }}"
                                            data-nama="{{ $item->nama_surat }}"
                                            title="Hapus">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->role == 'kaur_umum' ? 6 : 5 }}" class="text-center py-5 text-muted">
                            Belum ada jenis surat
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center flex-wrap mt-3" style="gap: 12px;">
            <span class="text-muted small">
                Menampilkan {{ $jenisSurat->firstItem() ?? 0 }} - {{ $jenisSurat->lastItem() ?? 0 }} 
                dari {{ $jenisSurat->total() }} data
            </span>
            {{ $jenisSurat->links() }}
        </div>
    </div>
</div>

@if(Auth::user()->role == 'kaur_umum')
@push('scripts')
<script>
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            
            Swal.fire({
                title: 'Hapus Jenis Surat?',
                html: `
                    <div style="text-align: center;">
                        <p style="font-size: 1rem; margin-bottom: 5px;">Apakah Anda yakin ingin menghapus</p>
                        <p style="font-size: 1.1rem; font-weight: 700; color: #1a472a;">"${nama}"</p>
                        <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan!</p>
                    </div>
                `,
                icon: 'warning',
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
                        text: `Jenis surat "${nama}" telah dihapus.`,
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
                        form.action = `{{ route('surat.jenis.index') }}/${id}`;
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
@endif

@endsection