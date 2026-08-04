@extends('layouts.public')

@section('title', $umkm->nama_usaha . ' - UMKM Desa Sidomulyo')

@section('public-content')

<style>
    .product-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 40px;
    }
    
    .btn-wa-large {
        background: #25d366;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        padding: 14px 28px;
        border-radius: 50px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.3);
    }
    
    .btn-wa-large:hover {
        background: #1eb954;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
    }
    
    .btn-back {
        background: #f8f9fa;
        color: #1a472a;
        border: 1px solid #dee2e6;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 50px;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .btn-back:hover {
        background: #1a472a;
        color: white;
    }
</style>

<div class="container py-5">
    
    <div class="mb-4">
        <a href="{{ route('public.umkm') }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Katalog UMKM
        </a>
    </div>

    <div class="product-container mb-5">
        <div class="row g-5 align-items-center">
            
            <div class="col-lg-6">
                @if($umkm->foto)
                    <img src="{{ asset('storage/' . $umkm->foto) }}" 
                         alt="{{ $umkm->nama_usaha }}" 
                         class="w-100 rounded-4 shadow-sm" 
                         style="max-height: 450px; object-fit: cover;">
                @else
                    <div class="bg-light rounded-4 text-center py-5 d-flex align-items-center justify-content-center text-muted" style="height: 350px;">
                        <i class="fas fa-store" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                @endif
            </div>

            <div class="col-lg-6">
                <span class="badge bg-success text-uppercase px-3 py-2 rounded-pill mb-2" style="font-size: 0.8rem;">{{ $umkm->kategori }}</span>
                <h1 class="fw-bold text-dark mb-2" style="font-size: 2.2rem;">{{ $umkm->nama_usaha }}</h1>
                <p class="text-muted fs-6 mb-3"><i class="fas fa-user-circle me-1 text-success"></i> Pemilik Usaha: <strong>{{ $umkm->pemilik }}</strong></p>

                <div class="p-3 bg-light rounded-3 border mb-4">
                    <small class="text-muted d-block" style="font-size: 0.8rem;">Kisaran Harga / Satuan</small>
                    <span class="fw-bold text-success display-6" style="font-size: 1.8rem;">{{ $umkm->harga ?? 'Hubungi Pengelola' }}</span>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-dark">Alamat & Lokasi Usaha:</h6>
                    <p class="text-muted mb-0"><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $umkm->alamat ?? 'Desa Sidomulyo' }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-dark">Deskripsi & Keunggulan Produk:</h6>
                    <p class="text-muted" style="line-height: 1.8;">{!! nl2br(e($umkm->deskripsi ?? 'Belum ada deskripsi produk.')) !!}</p>
                </div>

                @if($umkm->no_hp)
                <div class="pt-2">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->no_hp) }}?text=Halo%20{{ urlencode($umkm->pemilik) }},%20saya%20tertarik%20dengan%20produk%20{{ urlencode($umkm->nama_usaha) }}" 
                       target="_blank" 
                       class="btn-wa-large">
                        <i class="fab fa-whatsapp fs-4"></i> Pesan Langsung via WhatsApp
                    </a>
                </div>
                @endif
            </div>

        </div>
    </div>

    <!-- PRODUK UMKM LAINNYA -->
    @if(count($umkmLainnya) > 0)
    <div class="mt-5">
        <h4 class="fw-bold text-dark mb-4">Produk UMKM Desa Lainnya</h4>
        <div class="row g-4">
            @foreach($umkmLainnya as $lain)
            <div class="col-md-3 col-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                    @if($lain->foto)
                        <img src="{{ asset('storage/' . $lain->foto) }}" alt="{{ $lain->nama_usaha }}" style="height: 140px; object-fit: cover;" class="w-100">
                    @else
                        <div class="bg-light text-center py-4 text-muted" style="height: 140px;"><i class="fas fa-store fs-3"></i></div>
                    @endif
                    <div class="card-body p-3">
                        <span class="badge bg-secondary mb-1" style="font-size: 0.65rem;">{{ $lain->kategori }}</span>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">{{ Str::limit($lain->nama_usaha, 30) }}</h6>
                        <small class="text-success fw-bold d-block mb-2" style="font-size: 0.8rem;">{{ $lain->harga ?? '-' }}</small>
                        <a href="{{ route('public.umkm.show', $lain->id_umkm) }}" class="btn btn-sm btn-outline-success w-100 rounded-pill" style="font-size: 0.75rem;">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection
