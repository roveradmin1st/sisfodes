@extends('layouts.dashboard')

@section('page-title', 'Edit Data Penduduk')

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

    /* ===== SWITCH TOGGLE ===== */
    .form-switch .form-check-input {
        width: 48px;
        height: 24px;
        border-radius: 12px;
        border: 2px solid #e9ecef;
        background: #e9ecef;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 2px;
    }
    .form-switch .form-check-input:checked {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        border-color: #1a472a;
    }
    .form-switch .form-check-input:focus {
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.15);
        border-color: #1a472a;
    }
    .form-switch .form-check-label {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.9rem;
        cursor: pointer;
    }
    .form-switch small {
        font-size: 0.75rem;
        color: #6c757d;
        display: block;
        margin-top: 2px;
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
    .btn-action i {
        font-size: 0.9rem;
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

    .btn-update {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #1a1a1a;
        box-shadow: 0 4px 20px rgba(255, 193, 7, 0.25);
    }
    .btn-update:hover {
        box-shadow: 0 8px 30px rgba(255, 193, 7, 0.35);
        color: #1a1a1a;
    }

    /* ===== SECTION DIVIDER ===== */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 20px 0 16px 0;
    }
    .section-divider .line {
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, #e9ecef, transparent);
    }
    .section-divider .label {
        font-weight: 600;
        color: #1a472a;
        font-size: 0.85rem;
        white-space: nowrap;
        padding: 0 8px;
    }
    .section-divider .label i {
        margin-right: 6px;
        color: #1a472a;
    }

    /* ===== ANIMATIONS ===== */
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
        .card-body {
            padding: 16px;
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
        .form-switch .form-check-input {
            width: 40px;
            height: 20px;
        }
        .section-divider .label {
            font-size: 0.75rem;
        }
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 8px !important;
        }
        .mt-4 .btn-action {
            width: 100%;
            justify-content: center;
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
        .form-switch .form-check-label {
            font-size: 0.8rem;
        }
        .form-switch small {
            font-size: 0.65rem;
        }
        .section-divider .label {
            font-size: 0.65rem;
        }
    }
</style>

<!-- ============================================================ -->
<!-- FORM EDIT DATA PENDUDUK                                      -->
<!-- ============================================================ -->
<div class="card shadow-sm animate-on-scroll" style="animation-delay: 0.1s;">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">
            <i class="fas fa-edit me-2 text-warning"></i>Edit Data Penduduk
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('penduduk.update', $penduduk->id_penduduk) }}">
            @csrf
            @method('PUT')
            
            <!-- ===== SECTION: DATA PRIBADI ===== -->
            <div class="section-divider">
                <span class="label"><i class="fas fa-user"></i>Data Pribadi</span>
                <span class="line"></span>
            </div>
            
            <div class="row g-3">
                <!-- NIK -->
                <div class="col-md-6">
                    <label class="form-label">NIK <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                           name="nik" value="{{ old('nik', $penduduk->nik) }}" required maxlength="16" placeholder="Masukkan 16 digit NIK">
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- No KK -->
                <div class="col-md-6">
                    <label class="form-label">No. Kartu Keluarga <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_kk') is-invalid @enderror" 
                           name="no_kk" value="{{ old('no_kk', $penduduk->no_kk) }}" required maxlength="16" placeholder="Masukkan 16 digit KK">
                    @error('no_kk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Nama -->
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                           name="nama" value="{{ old('nama', $penduduk->nama) }}" required placeholder="Masukkan nama lengkap">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Tempat Lahir -->
                <div class="col-md-3">
                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                           name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" required placeholder="Kota lahir">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Tanggal Lahir -->
                <div class="col-md-3">
                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                           name="tanggal_lahir" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir->format('Y-m-d')) }}" required>
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Jenis Kelamin -->
                <div class="col-md-3">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required>
                        <option value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Agama -->
                <div class="col-md-3">
                    <label class="form-label">Agama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('agama') is-invalid @enderror" 
                           name="agama" value="{{ old('agama', $penduduk->agama) }}" required placeholder="Agama">
                    @error('agama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pendidikan -->
                <div class="col-md-6">
                    <label class="form-label">Pendidikan</label>
                    <select class="form-select" name="pendidikan">
                        <option value="">Pilih Pendidikan</option>
                        <option value="Tidak Sekolah" {{ old('pendidikan', $penduduk->pendidikan) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                        <option value="SD" {{ old('pendidikan', $penduduk->pendidikan) == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('pendidikan', $penduduk->pendidikan) == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ old('pendidikan', $penduduk->pendidikan) == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="Diploma" {{ old('pendidikan', $penduduk->pendidikan) == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                        <option value="Sarjana" {{ old('pendidikan', $penduduk->pendidikan) == 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                        <option value="Magister" {{ old('pendidikan', $penduduk->pendidikan) == 'Magister' ? 'selected' : '' }}>Magister</option>
                        <option value="Doktor" {{ old('pendidikan', $penduduk->pendidikan) == 'Doktor' ? 'selected' : '' }}>Doktor</option>
                    </select>
                </div>

                <!-- Status Perkawinan -->
                <div class="col-md-6">
                    <label class="form-label">Status Perkawinan</label>
                    <select class="form-select" name="status_perkawinan">
                        <option value="">Pilih Status</option>
                        <option value="Belum Kawin" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>

                <!-- Kewarganegaraan -->
                <div class="col-md-6">
                    <label class="form-label">Kewarganegaraan</label>
                    <select class="form-select" name="kewarganegaraan">
                        <option value="WNI" {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI</option>
                        <option value="WNA" {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>WNA</option>
                    </select>
                </div>
            </div>

            <!-- ===== SECTION: ALAMAT & DOMISILI ===== -->
            <div class="section-divider">
                <span class="label"><i class="fas fa-home"></i>Alamat & Domisili</span>
                <span class="line"></span>
            </div>
            
            <div class="row g-3">
                <!-- Alamat -->
                <div class="col-12">
                    <label class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                              name="alamat" rows="2" required placeholder="Masukkan alamat lengkap">{{ old('alamat', $penduduk->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Dusun -->
                <div class="col-md-4">
                    <label class="form-label">Dusun</label>
                    <input type="text" class="form-control" name="dusun" value="{{ old('dusun', $penduduk->dusun) }}" placeholder="Nama dusun">
                </div>
                
                <!-- RT -->
                <div class="col-md-4">
                    <label class="form-label">RT</label>
                    <input type="text" class="form-control" name="rt" value="{{ old('rt', $penduduk->rt) }}" placeholder="Nomor RT">
                </div>
                
                <!-- RW -->
                <div class="col-md-4">
                    <label class="form-label">RW</label>
                    <input type="text" class="form-control" name="rw" value="{{ old('rw', $penduduk->rw) }}" placeholder="Nomor RW">
                </div>
            </div>

            <!-- ===== SECTION: STATUS & LAINNYA ===== -->
            <div class="section-divider">
                <span class="label"><i class="fas fa-info-circle"></i>Status & Lainnya</span>
                <span class="line"></span>
            </div>
            
            <div class="row g-3">
                <!-- Status Penduduk -->
                <div class="col-md-6">
                    <label class="form-label">Status Penduduk <span class="text-danger">*</span></label>
                    <select class="form-select @error('status_penduduk') is-invalid @enderror" name="status_penduduk" required>
                        <option value="tetap" {{ old('status_penduduk', $penduduk->status_penduduk) == 'tetap' ? 'selected' : '' }}>Tetap</option>
                        <option value="sementara" {{ old('status_penduduk', $penduduk->status_penduduk) == 'sementara' ? 'selected' : '' }}>Sementara</option>
                    </select>
                    @error('status_penduduk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- CEKLIS KEPALA KELUARGA -->
                <div class="col-md-6">
                    <div class="form-switch mt-4">
                        <input class="form-check-input @error('is_kepala_keluarga') is-invalid @enderror" 
                               type="checkbox" 
                               id="is_kepala_keluarga" 
                               name="is_kepala_keluarga" 
                               value="1" 
                               {{ old('is_kepala_keluarga', $penduduk->is_kepala_keluarga) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_kepala_keluarga">
                            <i class="fas fa-user-tie me-1"></i> Kepala Keluarga
                        </label>
                        <small class="text-muted">Centang jika penduduk ini adalah Kepala Keluarga</small>
                        @error('is_kepala_keluarga')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Pekerjaan -->
                <div class="col-md-6">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" class="form-control" name="pekerjaan" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}" placeholder="Pekerjaan">
                </div>
                
                <!-- No HP -->
                <div class="col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp', $penduduk->no_hp) }}" placeholder="Nomor HP">
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $penduduk->email) }}" placeholder="Email">
                </div>

                <!-- Tahun Pendataan -->
                <div class="col-md-6">
                    <label class="form-label">Tahun Pendataan / Input <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('tahun') is-invalid @enderror" name="tahun" value="{{ old('tahun', $penduduk->tahun ?? 2025) }}" placeholder="Contoh: 2026" required>
                    @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- ===== BUTTONS ===== -->
            <div class="mt-4 d-flex gap-3 flex-wrap">
                <a href="{{ route('penduduk.index') }}" class="btn btn-action btn-batal">
                    <i class="fas fa-arrow-left me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-action btn-update">
                    <i class="fas fa-save me-1"></i>Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // ==========================================
    // SCROLL ANIMATION
    // ==========================================
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

@endsection