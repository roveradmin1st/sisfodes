@extends('layouts.dashboard')

@section('page-title', 'Ajukan Surat Keterangan')

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
    .form-control[readonly] {
        background: #e9ecef;
        cursor: not-allowed;
        color: #495057;
    }
    .form-control[readonly]:focus {
        box-shadow: none;
        border-color: #e9ecef;
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
    textarea.form-control {
        resize: vertical;
    }

    /* ===== ROW STYLING ===== */
    .info-row {
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    .info-row:hover {
        background: linear-gradient(90deg, #f8f9fa, #ffffff);
        padding-left: 10px;
        border-radius: 8px;
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

    /* ===== UPLOAD BOX ===== */
    .upload-box {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 16px 20px;
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        transition: all 0.3s ease;
    }
    .upload-box:hover {
        border-color: #1a472a;
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.06);
    }
    .upload-box .badge-upload {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* ===== FILE INPUT ===== */
    .file-input {
        padding: 10px 16px !important;
        border-radius: 10px !important;
        border: 2px solid #e9ecef !important;
        background: #f8f9fa !important;
        transition: all 0.3s ease !important;
    }
    .file-input:focus {
        border-color: #1a472a !important;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08) !important;
        background: white !important;
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

    .btn-kirim {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        box-shadow: 0 4px 20px rgba(26, 71, 42, 0.25);
    }
    .btn-kirim:hover {
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
        .info-row {
            padding: 10px 0;
            flex-direction: column !important;
            gap: 4px;
        }
        .info-row .label-col {
            font-size: 0.75rem;
            width: 100% !important;
        }
        .info-row .value-col {
            font-size: 0.8rem;
            width: 100% !important;
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
        .upload-box {
            padding: 12px 16px;
        }
        .upload-box .row .col-md-10 {
            margin-bottom: 8px;
        }
        .upload-box .row .col-md-2 {
            text-align: left !important;
        }
        .row.mb-3.align-items-center {
            flex-direction: column;
            align-items: stretch !important;
        }
        .row.mb-3.align-items-center .col-md-3 {
            margin-bottom: 4px;
        }
        .row.mb-3.align-items-start {
            flex-direction: column;
            align-items: stretch !important;
        }
        .row.mb-3.align-items-start .col-md-3 {
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
        .info-row .label-col {
            font-size: 0.65rem;
        }
        .info-row .value-col {
            font-size: 0.7rem;
        }
        .upload-box .badge-upload {
            font-size: 0.6rem;
            padding: 3px 12px;
        }
        .upload-box {
            padding: 10px 12px;
        }
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">
            Form Pengajuan Surat Keterangan
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

        <form method="POST" action="{{ route('surat.permohonan.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- ========================================== -->
            <!-- PILIH JENIS SURAT                         -->
            <!-- ========================================== -->
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label">Pilih Jenis Surat Keterangan <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select @error('id_jenis_surat') is-invalid @enderror" name="id_jenis_surat" id="select_jenis_surat" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        @foreach($jenisSurat as $item)
                            <option value="{{ $item->id_jenis_surat }}" data-syarat="{{ e($item->syarat) }}" {{ old('id_jenis_surat') == $item->id_jenis_surat ? 'selected' : '' }}>
                                {{ $item->nama_surat }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_jenis_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- ========================================== -->
            <!-- DATA DIRI (LABEL & TEXTBOX BERSAMPINGAN)  -->
            <!-- ========================================== -->
            
            <!-- Nama Lengkap -->
            <div class="row mb-2 align-items-center info-row">
                <div class="col-md-3 label-col">Nama Lengkap</div>
                <div class="col-md-9 value-col">
                    <input type="text" class="form-control" value="{{ $penduduk->nama }}" readonly disabled>
                </div>
            </div>

            <!-- NIK -->
            <div class="row mb-2 align-items-center info-row">
                <div class="col-md-3 label-col">NIK</div>
                <div class="col-md-9 value-col">
                    <input type="text" class="form-control" value="{{ $penduduk->nik }}" readonly disabled>
                </div>
            </div>

            <!-- No Kartu Keluarga -->
            <div class="row mb-2 align-items-center info-row">
                <div class="col-md-3 label-col">No Kartu Keluarga</div>
                <div class="col-md-9 value-col">
                    <input type="text" class="form-control" value="{{ $penduduk->no_kk }}" readonly disabled>
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="row mb-2 align-items-center info-row">
                <div class="col-md-3 label-col">Jenis Kelamin</div>
                <div class="col-md-9 value-col">
                    <input type="text" class="form-control" value="{{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly disabled>
                </div>
            </div>

            <!-- Tempat / Tanggal Lahir -->
            <div class="row mb-2 align-items-center info-row">
                <div class="col-md-3 label-col">Tempat / Tanggal Lahir</div>
                <div class="col-md-9 value-col">
                    <input type="text" class="form-control" value="{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d/m/Y') }}" readonly disabled>
                </div>
            </div>

            <!-- Status Perkawinan -->
            <div class="row mb-2 align-items-center info-row">
                <div class="col-md-3 label-col">Status Perkawinan</div>
                <div class="col-md-9 value-col">
                    <input type="text" class="form-control" value="{{ $penduduk->status_perkawinan ?? '-' }}" readonly disabled>
                </div>
            </div>

            <!-- Kewarganegaraan / Agama -->
            <div class="row mb-2 align-items-center info-row">
                <div class="col-md-3 label-col">Kewarganegaraan / Agama</div>
                <div class="col-md-9 value-col">
                    <input type="text" class="form-control" value="{{ $penduduk->kewarganegaraan ?? 'WNI' }} / {{ $penduduk->agama }}" readonly disabled>
                </div>
            </div>

            <!-- Pekerjaan -->
            <div class="row mb-2 align-items-center info-row">
                <div class="col-md-3 label-col">Pekerjaan</div>
                <div class="col-md-9 value-col">
                    <input type="text" class="form-control" value="{{ $penduduk->pekerjaan ?? '-' }}" readonly disabled>
                </div>
            </div>

            <!-- Alamat -->
            <div class="row mb-3 align-items-start info-row">
                <div class="col-md-3 label-col">Alamat</div>
                <div class="col-md-9 value-col">
                    <textarea class="form-control" rows="2" readonly disabled>{{ $penduduk->alamat }}</textarea>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- UPLOAD DOKUMEN PERSYARATAN (DINAMIS)       -->
            <!-- ========================================== -->
            <div class="row mb-4 align-items-start">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Upload Dokumen Persyaratan <span class="text-danger">*</span></label>
                    <small class="text-muted d-block mt-1">Unggah berkas untuk masing-masing persyaratan surat yang wajib dipenuhi.</small>
                </div>
                <div class="col-md-9">
                    <div id="container-persyaratan">
                        <div class="alert alert-secondary py-3 px-3 border-0 rounded-3 text-muted">
                            <i class="fas fa-info-circle me-1"></i> Silakan pilih <strong>Jenis Surat Keterangan</strong> terlebih dahulu untuk melihat daftar dokumen persyaratan yang wajib diunggah.
                        </div>
                    </div>
                    @error('file_persyaratan_list')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- ========================================== -->
            <!-- KEPERLUAN SURAT                           -->
            <!-- ========================================== -->
            <div class="row mb-3 align-items-start">
                <div class="col-md-3">
                    <label class="form-label">Keperluan Surat <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <div class="upload-box">
                        <div class="row g-3 align-items-start">
                            <div class="col-md-10">
                                <textarea class="form-control @error('keperluan') is-invalid @enderror" 
                                          name="keperluan" rows="3" required placeholder="Jelaskan keperluan pengajuan surat ini">{{ old('keperluan') }}</textarea>
                                <small class="text-muted">Jelaskan keperluan pengajuan surat ini</small>
                            </div>
                            <div class="col-md-2 text-md-end">
                                <span class="badge-upload">Foto Dokumen</span>
                            </div>
                        </div>
                        @error('keperluan')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <input type="hidden" name="id_penduduk" value="{{ $penduduk->id_penduduk }}">

            <!-- ========================================== -->
            <!-- TOMBOL AKSI                                -->
            <!-- ========================================== -->
            <div class="row mt-4">
                <div class="col-12 d-flex gap-3 flex-wrap">
                    <a href="{{ route('surat.permohonan.index') }}" class="btn-action btn-batal">Batal</a>
                    <button type="submit" class="btn-action btn-kirim">Kirim Pengajuan Surat</button>
                </div>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectJenis = document.getElementById('select_jenis_surat');
    const container = document.getElementById('container-persyaratan');

    function updateRequirements() {
        if (!selectJenis || !container) return;
        const selectedOption = selectJenis.options[selectJenis.selectedIndex];
        
        if (!selectedOption || !selectedOption.value) {
            container.innerHTML = `
                <div class="alert alert-secondary py-3 px-3 border-0 rounded-3 text-muted">
                    <i class="fas fa-info-circle me-1"></i> Silakan pilih <strong>Jenis Surat Keterangan</strong> terlebih dahulu untuk melihat daftar dokumen persyaratan yang wajib diunggah.
                </div>
            `;
            return;
        }

        const rawSyarat = selectedOption.getAttribute('data-syarat') || '';
        const lines = rawSyarat.split('\n').map(l => l.trim()).filter(l => l.length > 0);

        if (lines.length === 0) {
            container.innerHTML = `
                <div class="upload-box p-3 border rounded-3 bg-light">
                    <label class="form-label fw-bold small text-dark mb-1">Dokumen Persyaratan Pendukung <span class="text-danger">*</span></label>
                    <input type="hidden" name="nama_syarat[]" value="Dokumen Persyaratan Utama">
                    <input type="file" class="form-control" name="file_persyaratan_list[]" accept=".pdf,.jpg,.jpeg,.png" required>
                    <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle me-1"></i> Format: PDF, JPG, PNG (Maksimal 2MB)</small>
                </div>
            `;
            return;
        }

        let html = `
            <div class="alert alert-info py-2 px-3 mb-3 border-0 rounded-3" style="font-size: 0.85rem; background: #e8f4f8; color: #1a472a;">
                <i class="fas fa-exclamation-circle me-1 text-primary"></i> Wajib mengunggah seluruh berkas dokumen di bawah ini sesuai persyaratan surat yang dipilih:
            </div>
            <div class="d-flex flex-column gap-3">
        `;

        lines.forEach((line, index) => {
            html += `
                <div class="p-3 border rounded-3 bg-white shadow-sm">
                    <div class="row align-items-center g-2">
                        <div class="col-md-5 fw-bold text-dark" style="font-size: 0.85rem;">
                            <i class="fas fa-file-upload text-success me-2"></i> ${line} <span class="text-danger">*</span>
                        </div>
                        <div class="col-md-7">
                            <input type="hidden" name="nama_syarat[]" value="${line}">
                            <input type="file" class="form-control form-control-sm" name="file_persyaratan_list[]" accept=".pdf,.jpg,.jpeg,.png" required>
                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Upload dokumen (PDF, JPG, PNG) max 2MB</small>
                        </div>
                    </div>
                </div>
            `;
        });

        html += `</div>`;
        container.innerHTML = html;
    }

    if (selectJenis) {
        selectJenis.addEventListener('change', updateRequirements);
        if (selectJenis.value) {
            updateRequirements();
        }
    }
});
</script>
@endpush

@endsection