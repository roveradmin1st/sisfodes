@extends('layouts.dashboard')

@section('page-title', 'Detail UMKM Desa')

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
    .info-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.85rem;
    }
    .info-value {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 0.95rem;
    }
    .btn-kembali {
        background: #e9ecef;
        color: #495057;
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">
            Detail Informasi UMKM Desa
        </h5>
        <div>
            @if(Auth::user()->role == 'kaur_umum')
            <a href="{{ route('umkm.edit', $umkm->id_umkm) }}" class="btn btn-sm btn-warning px-3 rounded-pill fw-bold me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            @endif
            <a href="{{ route('umkm.index') }}" class="btn-kembali">Kembali</a>
        </div>
    </div>
    <div class="card-body">

        <div class="row g-4">
            <div class="col-md-5 text-center">
                @if($umkm->foto)
                    <img src="{{ asset('storage/' . $umkm->foto) }}" 
                         alt="{{ $umkm->nama_usaha }}" 
                         class="img-fluid rounded-4 shadow-sm w-100" 
                         style="max-height: 350px; object-fit: cover;">
                @else
                    <div class="bg-light rounded-4 d-flex flex-column align-items-center justify-content-center py-5 text-muted border">
                        <i class="fas fa-store mb-2" style="font-size: 4rem; opacity: 0.3;"></i>
                        <p class="mb-0">Tidak ada foto produk</p>
                    </div>
                @endif
            </div>

            <div class="col-md-7">
                <span class="badge bg-success px-3 py-2 rounded-pill text-uppercase mb-2">{{ $umkm->kategori }}</span>
                <h3 class="fw-bold text-dark mb-1">{{ $umkm->nama_usaha }}</h3>
                <p class="text-muted small mb-3"><i class="fas fa-user me-1 text-success"></i> Pemilik: <strong>{{ $umkm->pemilik }}</strong></p>

                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <div class="info-label mb-1">Kisaran Harga / Satuan</div>
                    <div class="info-value text-success fs-5">{{ $umkm->harga ?? 'Hubungi Pengelola' }}</div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <div class="info-label">No WhatsApp / HP</div>
                        <div class="info-value">
                            @if($umkm->no_hp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->no_hp) }}" target="_blank" class="text-success text-decoration-none">
                                    <i class="fab fa-whatsapp me-1"></i> {{ $umkm->no_hp }}
                                </a>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">Status Publikasi</div>
                        <div class="info-value">
                            <span class="badge {{ $umkm->status == 'publish' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($umkm->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-label">Alamat Usaha</div>
                        <div class="info-value">{{ $umkm->alamat ?? '-' }}</div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="info-label mb-1">Deskripsi Usaha</div>
                    <p class="text-muted" style="line-height: 1.7;">{!! nl2br(e($umkm->deskripsi ?? 'Belum ada deskripsi usaha.')) !!}</p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
