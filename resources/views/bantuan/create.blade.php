@extends('layouts.dashboard')

@section('page-title', 'Tambah Penerima Bantuan')

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
        margin-bottom: 4px;
    }
    .form-label .text-danger {
        color: #dc3545 !important;
        font-weight: 700;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 10px 16px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        background: #f8f9fa;
        font-size: 0.9rem;
        color: #1a1a1a;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
        background: white;
    }
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
    }
    .form-control.is-invalid:focus, .form-select.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
    }
    .form-control::placeholder {
        color: #adb5bd;
        font-size: 0.85rem;
    }
    .form-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 12px;
        padding-right: 40px;
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
        box-shadow: 0 6px 25px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    .btn-simpan {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        box-shadow: 0 4px 20px rgba(26, 71, 42, 0.25);
    }
    .btn-simpan:hover {
        box-shadow: 0 8px 30px rgba(26, 71, 42, 0.35);
        color: white;
    }

    /* ===== ALERT ===== */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 14px 20px;
        animation: slideDown 0.5s ease forwards;
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
        .form-control, .form-select {
            padding: 8px 14px;
            font-size: 0.85rem;
        }
        .btn-action {
            padding: 8px 18px;
            font-size: 0.8rem;
            width: 100%;
            justify-content: center;
        }
        .mt-4 .btn-action {
            width: 100%;
            justify-content: center;
        }
        .mt-4 .btn-action:not(:last-child) {
            margin-bottom: 8px;
        }
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 8px !important;
        }
        .row.g-3 .col-md-6 {
            margin-bottom: 8px;
        }
        .row.g-3 .col-md-6:last-child {
            margin-bottom: 0;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .form-control, .form-select {
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
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">
            Tambah Penerima Bantuan
        </h5>
    </div>
    <div class="card-body">
        
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

        <form method="POST" action="{{ route('bantuan.store') }}">
            @csrf

            <div class="row g-3">
                <!-- Pilih Penduduk -->
                <div class="col-12">
                    <label class="form-label">Pilih Penduduk <span class="text-danger">*</span></label>
                    <select class="form-select @error('id_penduduk') is-invalid @enderror" name="id_penduduk" required>
                        <option value="">-- Pilih Penduduk --</option>
                        @foreach($penduduk as $item)
                            <option value="{{ $item->id_penduduk }}" {{ old('id_penduduk') == $item->id_penduduk ? 'selected' : '' }}>
                                {{ $item->nama }} - {{ $item->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_penduduk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Program Bantuan -->
                <div class="col-md-6">
                    <label class="form-label">Program Bantuan <span class="text-danger">*</span></label>
                    <select class="form-select @error('program_bantuan') is-invalid @enderror" name="program_bantuan" required>
                        <option value="">-- Pilih Program --</option>
                        <option value="Bantuan Langsung Tunai (BLT)" {{ old('program_bantuan') == 'Bantuan Langsung Tunai (BLT)' ? 'selected' : '' }}>Bantuan Langsung Tunai (BLT)</option>
                        <option value="Bantuan Pangan Non Tunai (BPNT)" {{ old('program_bantuan') == 'Bantuan Pangan Non Tunai (BPNT)' ? 'selected' : '' }}>Bantuan Pangan Non Tunai (BPNT)</option>
                        <option value="Program Keluarga Harapan (PKH)" {{ old('program_bantuan') == 'Program Keluarga Harapan (PKH)' ? 'selected' : '' }}>Program Keluarga Harapan (PKH)</option>
                        <option value="Bantuan Sosial Tunai (BST)" {{ old('program_bantuan') == 'Bantuan Sosial Tunai (BST)' ? 'selected' : '' }}>Bantuan Sosial Tunai (BST)</option>
                        <option value="Bantuan Pendidikan" {{ old('program_bantuan') == 'Bantuan Pendidikan' ? 'selected' : '' }}>Bantuan Pendidikan</option>
                        <option value="Bantuan Kesehatan" {{ old('program_bantuan') == 'Bantuan Kesehatan' ? 'selected' : '' }}>Bantuan Kesehatan</option>
                        <option value="Lainnya" {{ old('program_bantuan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('program_bantuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Terima -->
                <div class="col-md-6">
                    <label class="form-label">Tanggal Terima <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_terima') is-invalid @enderror" 
                           name="tanggal_terima" value="{{ old('tanggal_terima') }}" required>
                    @error('tanggal_terima')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-12">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="diterima" {{ old('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="dialihkan" {{ old('status') == 'dialihkan' ? 'selected' : '' }}>Dialihkan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-4 d-flex gap-3 flex-wrap">
                <a href="{{ route('bantuan.index') }}" class="btn-action btn-batal">Batal</a>
                <button type="submit" class="btn-action btn-simpan">Simpan</button>
            </div>

        </form>
    </div>
</div>

@endsection