@extends('layouts.public')

@section('title', 'UMKM & Produk Unggulan Desa Sidomulyo')

@section('public-content')

<style>
    .umkm-header {
        background: linear-gradient(135deg, #1a472a 0%, #2d6a4f 100%);
        color: white;
        padding: 50px 0;
        border-radius: 0 0 24px 24px;
        margin-bottom: 40px;
    }
    
    .umkm-card {
        border-radius: 16px;
        overflow: hidden;
        background: white;
        border: 1px solid #f0f0f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .umkm-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .umkm-img {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    
    .category-pill {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 50px;
        background: #eef6f0;
        color: #1a472a;
        display: inline-block;
    }
    
    .btn-wa {
        background: #25d366;
        color: white;
        font-weight: 600;
        border-radius: 10px;
        font-size: 0.82rem;
        padding: 8px 16px;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-wa:hover {
        background: #1eb954;
        color: white;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }

    .btn-detail-public {
        background: #f8f9fa;
        color: #1a472a;
        font-weight: 600;
        border-radius: 10px;
        font-size: 0.82rem;
        padding: 8px 16px;
        transition: all 0.3s ease;
        text-decoration: none;
        border: 1px solid #e9ecef;
    }

    .btn-detail-public:hover {
        background: #1a472a;
        color: white;
    }
</style>

<!-- HEADER UMKM -->
<div class="umkm-header text-center">
    <div class="container">
        <span class="badge bg-light text-dark text-uppercase px-3 py-2 rounded-pill mb-2 fw-bold" style="font-size: 0.75rem;">Potensi Ekonomi Lokal</span>
        <h2 class="fw-bold mb-2">UMKM & Produk Unggulan Desa Sidomulyo</h2>
        <p class="opacity-75 mb-0" style="max-width: 650px; margin: 0 auto; font-size: 0.95rem;">
            Dukung pengrajin dan pengusaha lokal warga Desa Sidomulyo dengan membeli produk unggulan berkualitas tinggi langsung dari pembuatnya.
        </p>
    </div>
</div>

<div class="container pb-5">

    <!-- SEARCH & FILTER KATEGORI -->
    <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
        <form action="{{ route('public.umkm') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="keyword" class="form-control bg-light border-start-0" placeholder="Cari produk atau nama usaha..." value="{{ request('keyword') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="kategori" class="form-select bg-light">
                    <option value="">Semua Kategori Usaha</option>
                    <option value="Kuliner" {{ request('kategori') == 'Kuliner' ? 'selected' : '' }}>Kuliner / Makanan</option>
                    <option value="Kerajinan" {{ request('kategori') == 'Kerajinan' ? 'selected' : '' }}>Kerajinan Tangan</option>
                    <option value="Pertanian" {{ request('kategori') == 'Pertanian' ? 'selected' : '' }}>Pertanian & Hasil Desa</option>
                    <option value="Fashion" {{ request('kategori') == 'Fashion' ? 'selected' : '' }}>Fashion & Pakaian</option>
                    <option value="Jasa" {{ request('kategori') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                    <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-success w-100 fw-bold" style="background: #1a472a; border-radius: 10px;">Filter</button>
                @if(request('keyword') || request('kategori'))
                    <a href="{{ route('public.umkm') }}" class="btn btn-outline-secondary" style="border-radius: 10px;">✕</a>
                @endif
            </div>
        </form>
    </div>

    <!-- DAFTAR PRODUCT CARDS -->
    <div class="row g-4">
        @forelse($umkm as $item)
        <div class="col-lg-4 col-md-6">
            <div class="umkm-card h-100 d-flex flex-column">
                @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_usaha }}" class="umkm-img">
                @else
                    <div class="bg-light text-center py-5 d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                        <i class="fas fa-store" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                @endif
                
                <div class="p-4 d-flex flex-column flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="category-pill">{{ $item->kategori }}</span>
                        <span class="fw-bold text-success" style="font-size: 0.9rem;">{{ $item->harga ?? '-' }}</span>
                    </div>

                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1.1rem; line-height: 1.3;">
                        {{ $item->nama_usaha }}
                    </h5>
                    <p class="text-muted small mb-3"><i class="fas fa-user-circle me-1 text-success"></i> Pemilik: {{ $item->pemilik }}</p>

                    <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                        {{ Str::limit(strip_tags($item->deskripsi), 90, '...') }}
                    </p>

                    <div class="d-flex gap-2 mt-auto pt-2 border-top">
                        <a href="{{ route('public.umkm.show', $item->id_umkm) }}" class="btn-detail-public flex-grow-1 text-center">
                            Detail Produk
                        </a>
                        @if($item->no_hp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}?text=Halo%20saya%20tertarik%20dengan%20produk%20{{ urlencode($item->nama_usaha) }}" 
                           target="_blank" 
                           class="btn-wa" 
                           title="Hubungi Via WhatsApp">
                            <i class="fab fa-whatsapp fs-5"></i> Beli
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-store-slash" style="font-size: 3.5rem; display: block; margin-bottom: 15px; opacity: 0.3;"></i>
            <h5 class="fw-bold">Belum Ada Produk UMKM</h5>
            <p class="small">Belum ada produk usaha mikro desa yang terdaftar untuk kategori ini.</p>
        </div>
        @endforelse
    </div>

    <!-- PAGINASI -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $umkm->links() }}
    </div>

</div>

@endsection
