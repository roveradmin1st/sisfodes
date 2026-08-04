@extends('layouts.dashboard')

@section('page-title', 'Detail Data Penerima Bantuan')

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

    /* ===== FORM ELEMENTS ===== */
    .form-label {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.85rem;
        margin-bottom: 0;
    }

    .form-control {
        border-radius: 12px;
        padding: 10px 16px;
        border: 2px solid #e9ecef;
        background: #f8f9fa;
        font-size: 0.9rem;
        color: #1a1a1a;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
        background: white;
    }
    .form-control[readonly] {
        background: #e9ecef;
        cursor: not-allowed;
        color: #495057;
    }
    .form-control[readonly]:focus {
        box-shadow: none;
        border-color: #e9ecef;
    }
    textarea.form-control {
        resize: none;
    }

    /* ===== ROW STYLING ===== */
    .info-row {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    .info-row:hover {
        background: linear-gradient(90deg, #f8f9fa, #ffffff);
        padding-left: 12px;
        border-radius: 8px;
        margin-left: -8px;
        padding-right: 8px;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-row .label-col {
        font-weight: 600;
        color: #495057;
        font-size: 0.85rem;
    }
    .info-row .value-col {
        color: #212529;
        font-size: 0.9rem;
        font-weight: 500;
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

    .btn-edit {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
    }
    .btn-edit:hover {
        box-shadow: 0 4px 15px rgba(133, 100, 4, 0.2);
        color: #856404;
    }

    .btn-hapus {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }
    .btn-hapus:hover {
        box-shadow: 0 4px 15px rgba(114, 28, 36, 0.2);
        color: #721c24;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-body {
            padding: 16px;
        }
        .info-row {
            padding: 10px 0;
            flex-direction: column !important;
            gap: 4px;
        }
        .info-row:hover {
            padding-left: 8px;
            margin-left: -4px;
            padding-right: 4px;
        }
        .info-row .label-col {
            font-size: 0.75rem;
            width: 100% !important;
        }
        .info-row .value-col {
            font-size: 0.8rem;
            width: 100% !important;
        }
        .form-control {
            padding: 8px 14px;
            font-size: 0.85rem;
        }
        .btn-action {
            padding: 6px 16px;
            font-size: 0.8rem;
            width: 100%;
            justify-content: center;
        }
        .text-end {
            text-align: center !important;
        }
        .text-end .btn-action {
            margin: 4px 0;
        }
        .text-end .btn-action:not(:last-child) {
            margin-right: 0 !important;
        }
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 8px !important;
        }
        .row.mb-3.align-items-center {
            flex-direction: column;
            align-items: stretch !important;
        }
        .row.mb-3.align-items-center .col-md-3 {
            margin-bottom: 4px;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .form-control {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }
        .form-label {
            font-size: 0.75rem;
        }
        .info-row .label-col {
            font-size: 0.65rem;
        }
        .info-row .value-col {
            font-size: 0.7rem;
        }
        .btn-action {
            padding: 5px 12px;
            font-size: 0.7rem;
        }
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">
            Detail Data Penerima Bantuan
        </h5>
    </div>
    <div class="card-body">
        
        <!-- Nama -->
        <div class="row mb-2 align-items-center info-row">
            <div class="col-md-3 label-col">Nama</div>
            <div class="col-md-9 value-col">
                <input type="text" class="form-control" value="{{ $penerima->penduduk->nama ?? '-' }}" readonly>
            </div>
        </div>

        <!-- NIK -->
        <div class="row mb-2 align-items-center info-row">
            <div class="col-md-3 label-col">NIK</div>
            <div class="col-md-9 value-col">
                <input type="text" class="form-control" value="{{ $penerima->penduduk->nik ?? '-' }}" readonly>
            </div>
        </div>

        <!-- Alamat -->
        <div class="row mb-2 align-items-start info-row">
            <div class="col-md-3 label-col">Alamat</div>
            <div class="col-md-9 value-col">
                <textarea class="form-control" rows="2" readonly>{{ $penerima->penduduk->alamat ?? '-' }}</textarea>
            </div>
        </div>

        <!-- Pekerjaan -->
        <div class="row mb-2 align-items-center info-row">
            <div class="col-md-3 label-col">Pekerjaan</div>
            <div class="col-md-9 value-col">
                <input type="text" class="form-control" value="{{ $penerima->penduduk->pekerjaan ?? '-' }}" readonly>
            </div>
        </div>

        <!-- Umur -->
        <div class="row mb-2 align-items-center info-row">
            <div class="col-md-3 label-col">Umur</div>
            <div class="col-md-9 value-col">
                <input type="text" class="form-control" value="@if($penerima->penduduk && $penerima->penduduk->tanggal_lahir) {{ $penerima->penduduk->tanggal_lahir->age }} Tahun @else - @endif" readonly>
            </div>
        </div>

        <!-- Program Bantuan -->
        <div class="row mb-2 align-items-center info-row">
            <div class="col-md-3 label-col">Program Bantuan</div>
            <div class="col-md-9 value-col">
                <input type="text" class="form-control text-success fw-bold" value="{{ $penerima->program_bantuan }}" readonly>
            </div>
        </div>

        <!-- Status -->
        <div class="row mb-2 align-items-center info-row">
            <div class="col-md-3 label-col">Status Penerimaan</div>
            <div class="col-md-9 value-col">
                <span class="badge px-3 py-2 text-uppercase fs-7 
                    @if($penerima->status == 'diterima') bg-success 
                    @elseif($penerima->status == 'diproses') bg-primary 
                    @else bg-warning text-dark @endif">
                    {{ ucfirst($penerima->status) }}
                </span>
            </div>
        </div>

        <!-- Tanggal Terima -->
        <div class="row mb-2 align-items-center info-row">
            <div class="col-md-3 label-col">Tanggal Terima</div>
            <div class="col-md-9 value-col">
                <input type="text" class="form-control" value="{{ optional($penerima->tanggal_terima)->format('d F Y') ?? '-' }}" readonly>
            </div>
        </div>

        <!-- Keterangan Catatan -->
        <div class="row mb-2 align-items-center info-row">
            <div class="col-md-3 label-col">Keterangan / Detail</div>
            <div class="col-md-9 value-col">
                <input type="text" class="form-control" value="{{ $penerima->keterangan ?? '-' }}" readonly>
            </div>
        </div>

        <!-- Tombol Aksi - Ke Kanan -->
        <div class="row mt-4">
            <div class="col-md-12 text-end d-flex gap-2 justify-content-end flex-wrap">
                <a href="{{ route('bantuan.index') }}" class="btn-action btn-kembali">Kembali</a>
                <a href="{{ route('bantuan.edit', $penerima->id_penerima) }}" class="btn-action btn-edit">Edit</a>
                <form action="{{ route('bantuan.destroy', $penerima->id_penerima) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-hapus">Hapus</button>
                </form>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Data?',
            html: `
                <div style="text-align: center;">
                    <i class="fas fa-hand-holding-heart" style="font-size: 3rem; color: #dc3545; margin-bottom: 15px; display: block;"></i>
                    <p style="font-size: 1rem; margin-bottom: 5px;">Apakah Anda yakin ingin menghapus data ini?</p>
                    <p class="text-muted small">Data penerima bantuan akan dihapus permanen!</p>
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
                    text: 'Data penerima bantuan telah dihapus.',
                    timer: 1500,
                    showConfirmButton: false,
                    position: 'center',
                    backdrop: 'rgba(0,0,0,0.2)',
                    customClass: {
                        popup: 'rounded-4',
                        title: 'fw-bold text-success'
                    }
                }).then(() => {
                    this.submit();
                });
            }
        });
    });
</script>
@endpush

@endsection