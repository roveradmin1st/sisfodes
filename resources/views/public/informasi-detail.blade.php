@extends('layouts.public')

@section('title', $informasi->judul . ' - Desa Sidomulyo')

@section('public-content')

<style>
    .article-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 40px;
    }
    
    .article-category-badge {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        font-weight: 600;
        font-size: 0.75rem;
        padding: 6px 16px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        margin-bottom: 15px;
    }
    
    .article-title {
        font-weight: 800;
        font-size: 2.2rem;
        line-height: 1.3;
        color: #1a1a1a;
        margin-bottom: 20px;
    }
    
    .article-meta {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }
    
    .article-image {
        width: 100%;
        max-height: 480px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    
    .article-content {
        font-size: 1.05rem;
        line-height: 1.9;
        color: #333333;
    }
    
    .article-content p {
        margin-bottom: 20px;
    }

    .sidebar-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1a472a;
        padding-bottom: 12px;
        border-bottom: 2px solid #1a472a;
        margin-bottom: 20px;
    }

    .related-card {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        background: white;
    }
    
    .related-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    
    .btn-back {
        background: #f8f9fa;
        color: #1a472a;
        border: 1px solid #dee2e6;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #1a472a;
        color: white;
        border-color: #1a472a;
    }

    @media (max-width: 768px) {
        .article-container {
            padding: 24px 16px;
        }
        .article-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container py-5">
    
    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="{{ route('public.informasi') }}" class="btn btn-back text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Informasi Desa
        </a>
    </div>

    <div class="row g-4">
        
        <!-- KONTEN UTAMA BERITA -->
        <div class="col-lg-8">
            <article class="article-container">
                
                <span class="article-category-badge">
                    <i class="fas fa-tag me-1"></i> {{ ucfirst($informasi->kategori) }}
                </span>

                <h1 class="article-title">{{ $informasi->judul }}</h1>

                <div class="article-meta">
                    <div>
                        <i class="far fa-calendar-alt text-success me-1"></i>
                        {{ optional($informasi->tanggal_posting)->format('d F Y') ?? $informasi->created_at->format('d F Y') }}
                    </div>
                    <div>
                        <i class="far fa-user text-success me-1"></i>
                        Penulis: <strong>{{ $informasi->penulis ?? 'Admin Desa' }}</strong>
                    </div>
                    @if($informasi->waktu_pelaksanaan)
                    <div>
                        <i class="far fa-clock text-success me-1"></i>
                        Pelaksanaan: <strong>{{ \Carbon\Carbon::parse($informasi->waktu_pelaksanaan)->format('d F Y') }}</strong>
                    </div>
                    @endif
                </div>

                @if($informasi->gambar)
                    <img src="{{ asset('storage/' . $informasi->gambar) }}" 
                         alt="{{ $informasi->judul }}" 
                         class="article-image">
                @endif

                <div class="article-content">
                    {!! nl2br(e($informasi->isi)) !!}
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <a href="{{ route('home') }}" class="text-success fw-bold text-decoration-none">
                        <i class="fas fa-home me-1"></i> Beranda Utama
                    </a>
                    <a href="{{ route('public.informasi') }}" class="text-muted text-decoration-none">
                        Lihat Semua Berita & Information <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>

            </article>
        </div>

        <!-- SIDEBAR BERITA TERKAIT -->
        <div class="col-lg-4">
            <div class="bg-white rounded-4 p-4 shadow-sm border">
                <h5 class="sidebar-title">Informasi Terkait Lainnya</h5>

                <div class="d-flex flex-column gap-3">
                    @forelse($beritaTerkait as $terkait)
                        <a href="{{ route('public.informasi.show', $terkait->id_informasi) }}" class="text-decoration-none text-dark">
                            <div class="related-card p-3 d-flex gap-3 align-items-center">
                                @if($terkait->gambar)
                                    <img src="{{ asset('storage/' . $terkait->gambar) }}" 
                                         alt="Thumb" 
                                         style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;" class="flex-shrink-0">
                                @else
                                    <div class="bg-light border text-center d-flex align-items-center justify-content-center text-muted flex-shrink-0" 
                                         style="width: 70px; height: 70px; border-radius: 8px;">
                                        <i class="fas fa-newspaper fs-4"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.88rem; line-height: 1.3;">
                                        {{ Str::limit($terkait->judul, 45) }}
                                    </h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        <i class="far fa-calendar-alt me-1"></i> {{ optional($terkait->tanggal_posting)->format('d M Y') ?? $terkait->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-muted small mb-0">Belum ada berita terkait lainnya.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
