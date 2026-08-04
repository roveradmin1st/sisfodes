@extends('layouts.dashboard')

@section('page-title', 'Edit Penerima Bantuan')

@section('dashboard-content')

<style>
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
        font-size: 1.05rem;
    }
    .card-body {
        padding: 28px;
    }

    /* ===== SECTION TITLE ===== */
    .section-divider {
        display: flex;
        align-items: center;
        margin: 20px 0 15px 0;
        color: #1a472a;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .section-divider::after {
        content: '';
        flex: 1;
        margin-left: 12px;
        height: 2px;
        background: linear-gradient(90deg, #1a472a, rgba(26, 71, 42, 0.1));
        border-radius: 2px;
    }

    /* ===== FORM ELEMENTS ===== */
    .form-label {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.85rem;
        margin-bottom: 6px;
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

    /* ===== BUTTON STYLING ===== */
    .btn-action {
        padding: 12px 32px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-action:hover {
        transform: translateY(-2px) scale(1.02);
    }
    .btn-batal {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
    }
    .btn-update {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #1a1a1a;
        box-shadow: 0 4px 20px rgba(255, 193, 7, 0.25);
    }
    .btn-update:hover {
        box-shadow: 0 8px 30px rgba(255, 193, 7, 0.35);
        color: #1a1a1a;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">
            <i class="fas fa-edit me-2" style="color: #ffc107;"></i>
            Edit Data Penerima Bantuan
        </h5>
    </div>
    <div class="card-body">
        
        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('bantuan.update', $penerima->id_penerima) }}">
            @csrf
            @method('PUT')

            <!-- SECTION 1: DATA DIRI PENERIMA -->
            <div class="section-divider">
                <i class="fas fa-user-check me-2"></i> Data Identitas Penerima Bantuan
            </div>

            <div class="row g-3">
                <!-- NIK -->
                <div class="col-md-6">
                    <label class="form-label">NIK (16 Digit) <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('nik') is-invalid @enderror" 
                           id="nik" 
                           name="nik" 
                           maxlength="16"
                           value="{{ old('nik', $penerima->penduduk->nik ?? '') }}" 
                           required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap Penerima <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama', $penerima->penduduk->nama ?? '') }}" 
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nomor KK -->
                <div class="col-md-4">
                    <label class="form-label">Nomor Kartu Keluarga (KK)</label>
                    <input type="text" 
                           class="form-control @error('no_kk') is-invalid @enderror" 
                           id="no_kk" 
                           name="no_kk" 
                           maxlength="16"
                           value="{{ old('no_kk', $penerima->penduduk->no_kk ?? '') }}">
                    @error('no_kk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div class="col-md-4">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" 
                           class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                           id="tanggal_lahir" 
                           name="tanggal_lahir" 
                           value="{{ old('tanggal_lahir', optional($penerima->penduduk->tanggal_lahir)->format('Y-m-d')) }}">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="col-md-4">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="L" {{ old('jenis_kelamin', $penerima->penduduk->jenis_kelamin ?? 'L') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $penerima->penduduk->jenis_kelamin ?? 'L') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pekerjaan -->
                <div class="col-md-6">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" 
                           class="form-control @error('pekerjaan') is-invalid @enderror" 
                           id="pekerjaan" 
                           name="pekerjaan" 
                           value="{{ old('pekerjaan', $penerima->penduduk->pekerjaan ?? '') }}">
                    @error('pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="col-md-6">
                    <label class="form-label">Alamat / Dusun</label>
                    <input type="text" 
                           class="form-control @error('alamat') is-invalid @enderror" 
                           id="alamat" 
                           name="alamat" 
                           value="{{ old('alamat', $penerima->penduduk->alamat ?? '') }}">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- SECTION 2: DATA BANTUAN -->
            <div class="section-divider mt-4">
                <i class="fas fa-box-open me-2"></i> Detail Program Bantuan Sosial
            </div>

            <div class="row g-3">
                <!-- Program Bantuan -->
                @php
                    $stdPrograms = [
                        'Bantuan Langsung Tunai (BLT)',
                        'Bantuan Pangan Non Tunai (BPNT)',
                        'Program Keluarga Harapan (PKH)',
                        'Bantuan Sosial Tunai (BST)',
                        'Bantuan Pendidikan',
                        'Bantuan Kesehatan'
                    ];
                    $currentProg = old('program_bantuan', $penerima->program_bantuan);
                    $isCustom = !in_array($currentProg, $stdPrograms);
                @endphp
                <div class="col-md-6">
                    <label class="form-label">Program Bantuan <span class="text-danger">*</span></label>
                    <select class="form-select @error('program_bantuan') is-invalid @enderror" id="program_bantuan_select" name="program_bantuan" required>
                        <option value="">-- Pilih Program Bantuan --</option>
                        @foreach($stdPrograms as $prog)
                            <option value="{{ $prog }}" {{ $currentProg == $prog ? 'selected' : '' }}>{{ $prog }}</option>
                        @endforeach
                        <option value="Lainnya" {{ $isCustom ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('program_bantuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Nama Program Jika Memilih 'Lainnya' -->
                <div class="col-md-6 {{ $isCustom ? '' : 'd-none' }}" id="program_lainnya_wrapper">
                    <label class="form-label">Tuliskan Nama Program Bantuan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="program_bantuan_lainnya" name="program_bantuan_lainnya" 
                           placeholder="Misal: Bantuan Sembako Desa" value="{{ $isCustom ? $currentProg : old('program_bantuan_lainnya') }}">
                </div>

                <!-- Tanggal Terima -->
                <div class="col-md-3">
                    <label class="form-label">Tanggal Terima <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_terima') is-invalid @enderror" 
                           name="tanggal_terima" value="{{ old('tanggal_terima', $penerima->tanggal_terima->format('Y-m-d')) }}" required>
                    @error('tanggal_terima')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-3">
                    <label class="form-label">Status Penerima <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="diterima" {{ old('status', $penerima->status) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="diproses" {{ old('status', $penerima->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="dialihkan" {{ old('status', $penerima->status) == 'dialihkan' ? 'selected' : '' }}>Dialihkan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keterangan Tambahan -->
                <div class="col-12">
                    <label class="form-label">Keterangan / Detail Catatan Bantuan (Opsional)</label>
                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" 
                           name="keterangan" value="{{ old('keterangan', $penerima->keterangan) }}" placeholder="Contoh: Tahap I 2026, Nominal Rp 300.000, Beras 10kg, dll">
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-4 pt-2 d-flex gap-3 flex-wrap">
                <a href="{{ route('bantuan.index') }}" class="btn-action btn-batal">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn-action btn-update">
                    <i class="fas fa-sync-alt"></i> Update Data Penerima Bantuan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectProgram = document.getElementById('program_bantuan_select');
    const wrapperLainnya = document.getElementById('program_lainnya_wrapper');
    const inputLainnya = document.getElementById('program_bantuan_lainnya');

    function checkLainnya() {
        if (selectProgram.value === 'Lainnya') {
            wrapperLainnya.classList.remove('d-none');
            inputLainnya.required = true;
        } else {
            wrapperLainnya.classList.add('d-none');
            inputLainnya.required = false;
        }
    }

    selectProgram.addEventListener('change', checkLainnya);
});
</script>

@endsection