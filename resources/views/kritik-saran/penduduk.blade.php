@extends('layouts.dashboard')

@section('page-title', 'Kritik dan Saran')

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
    .card-body {
        padding: 24px;
    }
    .card-body h5 {
        font-weight: 700;
        color: #1a472a;
        font-size: 1.05rem;
    }

    /* ===== FORM ELEMENTS ===== */
    .form-label {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.85rem;
        margin-bottom: 4px;
    }
    .form-label .text-danger {
        color: #dc3545 !important;
        font-weight: 700;
    }

    .form-control {
        border-radius: 12px;
        padding: 10px 16px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        background: #f8f9fa;
        font-size: 0.9rem;
        color: #1a1a1a;
    }
    .form-control:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
        background: white;
    }
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
    }
    .form-control::placeholder {
        color: #adb5bd;
        font-size: 0.85rem;
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

    .btn-batal {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
    }
    .btn-batal:hover {
        box-shadow: 0 4px 15px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    .btn-kirim {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        box-shadow: 0 4px 20px rgba(26, 71, 42, 0.25);
    }
    .btn-kirim:hover {
        box-shadow: 0 8px 30px rgba(26, 71, 42, 0.35);
        color: white;
    }

    .btn-lihat {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #0d47a1;
        border: none;
        border-radius: 8px;
        padding: 4px 14px;
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-lihat:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(13, 71, 161, 0.2);
        color: #0d47a1;
    }

    .btn-modal-tutup {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
        border: none;
        border-radius: 10px;
        padding: 8px 24px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .btn-modal-tutup:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 4px 15px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    /* ===== TABLE STYLING ===== */
    .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    .table thead th {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #1a1a1a;
        font-weight: 700;
        padding: 12px 16px;
        border-bottom: none;
        font-size: 0.75rem;
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
        padding: 10px 16px;
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
    .table tbody td:first-child {
        font-weight: 600;
        color: #1a472a;
    }

    /* ===== BADGE STATUS ===== */
    .badge-status {
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .badge-dibalas {
        background: linear-gradient(135deg, #d4edda, #a8e0b0);
        color: #1a472a;
    }
    .badge-menunggu {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
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
    .alert ul {
        padding-left: 20px;
        margin-bottom: 0;
    }

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: 16px !important;
        border: none !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
    }
    .modal-header {
        border-bottom: none !important;
        padding: 20px 24px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 16px 16px 0 0 !important;
    }
    .modal-header .modal-title {
        font-weight: 700;
        color: #1a472a;
        font-size: 1.1rem;
    }
    .modal-body {
        padding: 24px;
    }
    .modal-body .info-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.8rem;
        margin-bottom: 2px;
    }
    .modal-body .info-value {
        padding: 6px 0 12px 0;
        border-bottom: 1px solid #f0f0f0;
        color: #212529;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }
    .modal-body .info-value:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
    }
    .modal-body .info-value.balasan-text {
        color: #1a472a;
        background: #e8f5e9;
        padding: 10px 14px;
        border-radius: 8px;
        border-left: 3px solid #1a472a;
        white-space: pre-line;
    }
    .modal-footer {
        border-top: none !important;
        padding: 16px 24px 24px 24px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-body {
            padding: 16px;
        }
        .card-body h5 {
            font-size: 0.95rem;
        }
        .form-control {
            padding: 8px 14px;
            font-size: 0.85rem;
        }
        .btn-action {
            padding: 8px 18px;
            font-size: 0.8rem;
            width: 100%;
            justify-content: center;
        }
        .d-flex.gap-2 {
            flex-direction: column;
            gap: 8px !important;
        }
        .d-flex.gap-2 .btn-action {
            width: 100%;
        }
        .table thead th {
            font-size: 0.65rem;
            padding: 8px 10px;
        }
        .table tbody td {
            padding: 8px 10px;
            font-size: 0.75rem;
        }
        .btn-lihat {
            padding: 3px 10px;
            font-size: 0.6rem;
        }
        .pagination .page-item .page-link {
            padding: 6px 10px;
            font-size: 0.75rem;
        }
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 8px;
            align-items: flex-start !important;
        }
        .modal-body {
            padding: 16px;
        }
        .modal-footer .btn-modal-tutup {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .card-body h5 {
            font-size: 0.85rem;
        }
        .form-control {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }
        .form-label {
            font-size: 0.75rem;
        }
        .btn-action {
            padding: 6px 14px;
            font-size: 0.7rem;
        }
        .table thead th {
            font-size: 0.55rem;
            padding: 6px 6px;
        }
        .table tbody td {
            padding: 6px 6px;
            font-size: 0.65rem;
        }
        .badge-status {
            font-size: 0.55rem;
            padding: 2px 10px;
        }
        .btn-lihat {
            font-size: 0.55rem;
            padding: 2px 8px;
        }
        .pagination .page-item .page-link {
            padding: 4px 8px;
            font-size: 0.65rem;
        }
        .modal-header .modal-title {
            font-size: 0.95rem;
        }
        .modal-body .info-label {
            font-size: 0.7rem;
        }
        .modal-body .info-value {
            font-size: 0.75rem;
            padding: 4px 0 8px 0;
        }
    }
</style>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        Terjadi kesalahan:
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- ========================================== -->
<!-- FORM KIRIM MASUKAN                        -->
<!-- ========================================== -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Kirim Masukan</h5>

        <form action="{{ route('kritik-saran.penduduk.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Subjek <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('subjek') is-invalid @enderror" 
                       name="subjek" value="{{ old('subjek') }}" placeholder="Masukkan subjek" required>
                @error('subjek')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Pesan <span class="text-danger">*</span></label>
                <textarea class="form-control @error('isi_pesan') is-invalid @enderror" 
                          name="isi_pesan" rows="5" placeholder="Masukkan pesan Anda" required>{{ old('isi_pesan') }}</textarea>
                @error('isi_pesan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('dashboard.penduduk') }}" class="btn-action btn-batal">Batal</a>
                <button type="submit" class="btn-action btn-kirim">Kirim</button>
            </div>

        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- RIWAYAT KRITIK & SARAN                    -->
<!-- ========================================== -->
@if($kritikSaran->count() > 0)
<div class="card border-0 shadow-sm mt-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Riwayat Kritik & Saran</h5>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Subjek</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kritikSaran as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($kritikSaran->currentPage() - 1) * $kritikSaran->perPage() }}</td>
                        <td>
                            @php
                                $subjek = explode("\n", $item->isi_pesan);
                                $subjek = str_replace('Subjek: ', '', $subjek[0] ?? '');
                                echo $subjek ?: 'Tanpa Subjek';
                            @endphp
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($item->status == 'dibalas')
                                <span class="badge-status badge-dibalas">Sudah Dibalas</span>
                            @else
                                <span class="badge-status badge-menunggu">Menunggu</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" 
                                    class="btn-lihat" 
                                    data-id="{{ $item->id_pesan }}"
                                    data-subjek="{{ $subjek ?: 'Tanpa Subjek' }}"
                                    data-pesan="{{ $item->isi_pesan }}"
                                    data-balasan="{{ $item->balasan }}"
                                    data-status="{{ $item->status }}"
                                    data-tanggal="{{ $item->created_at->format('d/m/Y H:i') }}">
                                Lihat
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap" style="gap: 12px;">
            <span class="text-muted small">
                Menampilkan {{ $kritikSaran->firstItem() ?? 0 }} - {{ $kritikSaran->lastItem() ?? 0 }}
                dari {{ $kritikSaran->total() }} data
            </span>
            {{ $kritikSaran->links() }}
        </div>
    </div>
</div>
@endif

<!-- ========================================== -->
<!-- MODAL LIHAT BALASAN                       -->
<!-- ========================================== -->
<div class="modal fade" id="lihatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detail Kritik & Saran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="info-label">Subjek</label>
                    <p id="detailSubjek" class="info-value"></p>
                </div>
                <div class="mb-2">
                    <label class="info-label">Tanggal</label>
                    <p id="detailTanggal" class="info-value"></p>
                </div>
                <div class="mb-2">
                    <label class="info-label">Pesan</label>
                    <p id="detailPesan" class="info-value" style="white-space: pre-line;"></p>
                </div>
                <div class="mb-2">
                    <label class="info-label">Status</label>
                    <p id="detailStatus" class="info-value"></p>
                </div>
                <div class="mb-2" id="detailBalasanContainer">
                    <label class="info-label text-success">Balasan</label>
                    <p id="detailBalasan" class="info-value balasan-text"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-tutup" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnLihat = document.querySelectorAll('.btn-lihat');
        const modal = document.getElementById('lihatModal');

        btnLihat.forEach(function(button) {
            button.addEventListener('click', function() {
                const subjek = this.dataset.subjek;
                const pesan = this.dataset.pesan;
                const balasan = this.dataset.balasan;
                const status = this.dataset.status;
                const tanggal = this.dataset.tanggal;

                document.getElementById('detailSubjek').textContent = subjek;
                document.getElementById('detailPesan').textContent = pesan;
                document.getElementById('detailTanggal').textContent = tanggal;

                const statusEl = document.getElementById('detailStatus');
                if (status == 'dibalas') {
                    statusEl.innerHTML = '<span class="badge-status badge-dibalas">Sudah Dibalas</span>';
                } else {
                    statusEl.innerHTML = '<span class="badge-status badge-menunggu">Menunggu</span>';
                }

                const balasanContainer = document.getElementById('detailBalasanContainer');
                const balasanEl = document.getElementById('detailBalasan');
                if (balasan) {
                    balasanContainer.style.display = 'block';
                    balasanEl.textContent = balasan;
                } else {
                    balasanContainer.style.display = 'none';
                }

                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            });
        });
    });
</script>
@endpush

@endsection