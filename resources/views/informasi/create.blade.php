@extends('layouts.dashboard')

@section('page-title', 'Tambah Informasi Desa')

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

    /* ===== SUB CARD ===== */
    .sub-card {
        border: 2px solid #e9ecef;
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        margin-bottom: 20px;
        display: none;
    }
    .sub-card.active {
        display: block;
        animation: fadeIn 0.4s ease forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .sub-card:hover {
        border-color: #1a472a;
        box-shadow: 0 8px 30px rgba(26, 71, 42, 0.06);
    }
    .sub-card .sub-header {
        padding: 12px 20px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid #e9ecef;
    }
    .sub-card .sub-header h6 {
        font-weight: 700;
        color: #1a472a;
        font-size: 0.85rem;
        margin-bottom: 0;
    }
    .sub-card .sub-body {
        padding: 20px;
        background: white;
    }

    /* ===== FILE INPUT ===== */
    .file-input {
        padding: 10px 16px !important;
        border-radius: 12px !important;
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
        .sub-card .sub-body {
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
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .sub-card .sub-body {
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
            Tambah Informasi Desa
        </h5>
    </div>
    <div class="card-body">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
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

        <form method="POST" action="{{ route('informasi.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- ========================================== -->
            <!-- PILIH KATEGORI                             -->
            <!-- ========================================== -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Pilih Kategori <span class="text-danger">*</span></label>
                    <select class="form-select" id="kategoriSelect" name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="berita" {{ old('kategori') == 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="pengumuman" {{ old('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="agenda" {{ old('kategori') == 'agenda' ? 'selected' : '' }}>Agenda Kegiatan</option>
                        <option value="galeri" {{ old('kategori') == 'galeri' ? 'selected' : '' }}>Galeri</option>
                    </select>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- FORM BERITA                                -->
            <!-- ========================================== -->
            <div id="formBerita" class="sub-card">
                <div class="sub-header">
                    <h6>Form Berita</h6>
                </div>
                <div class="sub-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" placeholder="Masukkan judul berita" value="{{ old('judul') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Isi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="isi" rows="4" placeholder="Masukkan isi berita">{{ old('isi') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Gambar</label>
                            <input type="file" class="form-control file-input" name="gambar" accept="image/*">
                            <small class="text-muted">Upload gambar (JPG, PNG, GIF) max 2MB</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status_publish">
                                <option value="publish" {{ old('status_publish') == 'publish' ? 'selected' : '' }}>Publish</option>
                                <option value="draft" {{ old('status_publish') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- FORM PENGUMUMAN                            -->
            <!-- ========================================== -->
            <div id="formPengumuman" class="sub-card">
                <div class="sub-header">
                    <h6>Form Pengumuman</h6>
                </div>
                <div class="sub-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" placeholder="Masukkan judul pengumuman" value="{{ old('judul') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Isi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="isi" rows="4" placeholder="Masukkan isi pengumuman">{{ old('isi') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status_publish">
                                <option value="publish" {{ old('status_publish') == 'publish' ? 'selected' : '' }}>Publish</option>
                                <option value="draft" {{ old('status_publish') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- FORM AGENDA KEGIATAN                       -->
            <!-- ========================================== -->
            <div id="formAgenda" class="sub-card">
                <div class="sub-header">
                    <h6>Form Agenda Kegiatan</h6>
                </div>
                <div class="sub-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" placeholder="Masukkan judul agenda" value="{{ old('judul') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Isi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="isi" rows="4" placeholder="Masukkan isi agenda">{{ old('isi') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Waktu Pelaksanaan</label>
                            <input type="datetime-local" class="form-control" name="waktu_pelaksanaan" value="{{ old('waktu_pelaksanaan') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status_publish">
                                <option value="publish" {{ old('status_publish') == 'publish' ? 'selected' : '' }}>Publish</option>
                                <option value="draft" {{ old('status_publish') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- FORM GALERI                               -->
            <!-- ========================================== -->
            <div id="formGaleri" class="sub-card">
                <div class="sub-header">
                    <h6>Form Galeri</h6>
                </div>
                <div class="sub-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" placeholder="Masukkan judul galeri" value="{{ old('judul') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="isi" rows="4" placeholder="Masukkan deskripsi galeri">{{ old('isi') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Gambar <span class="text-danger">*</span></label>
                            <input type="file" class="form-control file-input" name="gambar" accept="image/*">
                            <small class="text-muted">Upload gambar (JPG, PNG, GIF) max 2MB</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status_publish">
                                <option value="publish" {{ old('status_publish') == 'publish' ? 'selected' : '' }}>Publish</option>
                                <option value="draft" {{ old('status_publish') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TOMBOL AKSI                                -->
            <!-- ========================================== -->
            <div class="mt-4 d-flex gap-3 flex-wrap">
                <a href="{{ route('informasi.index') }}" class="btn btn-action btn-batal">Batal</a>
                <button type="submit" class="btn btn-action btn-simpan">Simpan</button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriSelect = document.getElementById('kategoriSelect');
        const formBerita = document.getElementById('formBerita');
        const formPengumuman = document.getElementById('formPengumuman');
        const formAgenda = document.getElementById('formAgenda');
        const formGaleri = document.getElementById('formGaleri');

        function disableAllForms() {
            [formBerita, formPengumuman, formAgenda, formGaleri].forEach(form => {
                form.classList.remove('active');
                form.querySelectorAll('input, textarea, select').forEach(el => {
                    el.disabled = true;
                    el.removeAttribute('required');
                });
            });
        }

        function enableForm(form, requiredFields) {
            form.classList.add('active');
            form.querySelectorAll('input, textarea, select').forEach(el => {
                el.disabled = false;
                if (requiredFields.includes(el.name)) {
                    el.setAttribute('required', 'required');
                }
            });
        }

        function showForm(kategori) {
            disableAllForms();
            if (kategori === 'berita') {
                enableForm(formBerita, ['judul', 'isi', 'status_publish']);
            } else if (kategori === 'pengumuman') {
                enableForm(formPengumuman, ['judul', 'isi', 'status_publish']);
            } else if (kategori === 'agenda') {
                enableForm(formAgenda, ['judul', 'isi', 'status_publish']);
            } else if (kategori === 'galeri') {
                enableForm(formGaleri, ['judul', 'gambar', 'status_publish']);
            }
        }

        kategoriSelect.addEventListener('change', function() {
            showForm(this.value);
        });

        const oldKategori = '{{ old('kategori') }}';
        if (oldKategori) {
            kategoriSelect.value = oldKategori;
            showForm(oldKategori);
        } else {
            disableAllForms();
        }
    });
</script>
@endpush

@endsection