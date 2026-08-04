@extends('layouts.dashboard')

@section('page-title', 'Edit Data UMKM Desa')

@section('dashboard-content')

<style>
    .card {
        border-radius: 16px !important;
        overflow: hidden;
        border: none !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;
    }
    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
        border-bottom: none !important;
        padding: 18px 24px;
    }
    .card-title {
        font-weight: 700;
        color: #1a472a;
        font-size: 0.95rem;
    }
    .card-body {
        padding: 24px;
    }
    .form-label {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.85rem;
        margin-bottom: 6px;
    }
    .form-control, .form-select {
        border-radius: 10px;
        padding: 10px 14px;
        border: 2px solid #e9ecef;
        background: #f8f9fa;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
        background: white;
    }
    .btn-submit {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
        color: white;
    }
    .btn-batal {
        background: #e9ecef;
        color: #495057;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header py-3">
        <h5 class="card-title mb-0 fw-bold">
            <i class="fas fa-edit me-2 text-warning"></i> Edit Data Usaha / Produk UMKM
        </h5>
    </div>
    <div class="card-body">

        <form action="{{ route('umkm.update', $umkm->id_umkm) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- Nama Usaha -->
                <div class="col-md-6">
                    <label class="form-label">Nama Usaha / Produk <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('nama_usaha') is-invalid @enderror" 
                           name="nama_usaha" 
                           value="{{ old('nama_usaha', $umkm->nama_usaha) }}" 
                           required>
                    @error('nama_usaha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pemilik -->
                <div class="col-md-6">
                    <label class="form-label">Nama Pemilik / Pengelola <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('pemilik') is-invalid @enderror" 
                           name="pemilik" 
                           value="{{ old('pemilik', $umkm->pemilik) }}" 
                           required>
                    @error('pemilik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="col-md-4">
                    <label class="form-label">Kategori Usaha <span class="text-danger">*</span></label>
                    <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" required>
                        <option value="Kuliner" {{ old('kategori', $umkm->kategori) == 'Kuliner' ? 'selected' : '' }}>Kuliner / Makanan & Minuman</option>
                        <option value="Kerajinan" {{ old('kategori', $umkm->kategori) == 'Kerajinan' ? 'selected' : '' }}>Kerajinan Tangan / Souvenir</option>
                        <option value="Pertanian" {{ old('kategori', $umkm->kategori) == 'Pertanian' ? 'selected' : '' }}>Hasil Pertanian & Peternakan</option>
                        <option value="Fashion" {{ old('kategori', $umkm->kategori) == 'Fashion' ? 'selected' : '' }}>Fashion & Pakaian</option>
                        <option value="Jasa" {{ old('kategori', $umkm->kategori) == 'Jasa' ? 'selected' : '' }}>Jasa & Pelayanan</option>
                        <option value="Lainnya" {{ old('kategori', $umkm->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kisaran Harga -->
                <div class="col-md-4">
                    <label class="form-label">Kisaran Harga / Satuan</label>
                    <input type="text" 
                           class="form-control @error('harga') is-invalid @enderror" 
                           name="harga" 
                           value="{{ old('harga', $umkm->harga) }}">
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- No HP / WA -->
                <div class="col-md-4">
                    <label class="form-label">No WhatsApp / HP Pembeli</label>
                    <input type="text" 
                           class="form-control @error('no_hp') is-invalid @enderror" 
                           name="no_hp" 
                           value="{{ old('no_hp', $umkm->no_hp) }}">
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alamat Usaha -->
                <div class="col-12">
                    <label class="form-label">Alamat Usaha / Lokasi Dusun</label>
                    <input type="text" 
                           class="form-control @error('alamat') is-invalid @enderror" 
                           name="alamat" 
                           value="{{ old('alamat', $umkm->alamat) }}">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi Usaha -->
                <div class="col-12">
                    <label class="form-label">Deskripsi Usaha & Keunggulan Produk</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              name="deskripsi" 
                              rows="4">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Foto Produk -->
                <div class="col-md-6">
                    <label class="form-label">Ganti Foto Produk / Usaha</label>
                    <input type="file" 
                           class="form-control @error('foto') is-invalid @enderror" 
                           name="foto" 
                           accept="image/*">
                    @if($umkm->foto)
                        <div class="mt-2">
                            <small class="text-muted d-block mb-1">Foto Saat Ini:</small>
                            <img src="{{ asset('storage/' . $umkm->foto) }}" alt="Foto Usaha" style="height: 90px; border-radius: 8px;">
                        </div>
                    @endif
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Publish -->
                <div class="col-md-6">
                    <label class="form-label">Status Publikasi <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="publish" {{ old('status', $umkm->status) == 'publish' ? 'selected' : '' }}>Publish (Tampil di Publik)</option>
                        <option value="draft" {{ old('status', $umkm->status) == 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-4 pt-2 d-flex gap-3">
                <a href="{{ route('umkm.index') }}" class="btn-batal">Batal</a>
                <button type="submit" class="btn-submit"><i class="fas fa-sync-alt me-1"></i> Update Data UMKM</button>
            </div>
        </form>

    </div>
</div>

@endsection
