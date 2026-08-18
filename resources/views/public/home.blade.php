@extends('layouts.public')

@section('title', 'Portal Desa Sidomulyo')

@push('styles')
<style>
    /* Custom CSS for Homepage */
    .hero-section {
        background: linear-gradient(135deg, #f4f8ff 0%, #e8f1fd 100%);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }
    
    .badge-kecamatan {
        background-color: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 600;
        font-size: 0.8rem;
        padding: 6px 15px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }
    
    .hero-title {
        font-weight: 700;
        font-size: 3rem;
        line-height: 1.2;
        color: var(--primary-dark);
        margin-bottom: 20px;
    }
    
    .hero-subtitle {
        font-size: 1.05rem;
        color: #4b5563;
        line-height: 1.6;
        margin-bottom: 35px;
    }
    
    .btn-hero-primary {
        background: linear-gradient(135deg, #0d2b5e, #1a4a7a);
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-hero-primary:hover {
        background: linear-gradient(135deg, #0a2148, #0d2b5e);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(13, 43, 94, 0.25);
        color: white;
    }
    
    .btn-hero-secondary {
        background: #e5e7eb;
        color: var(--text-dark);
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-hero-secondary:hover {
        background: #d1d5db;
        color: var(--text-dark);
    }
    
    .browser-mockup {
        background: white;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        position: relative;
        z-index: 10;
    }
    
    .browser-mockup img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    /* Services Section */
    .services-section {
        padding: 100px 0;
        background: white;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .section-title {
        font-weight: 700;
        color: var(--primary-dark);
        font-size: 2rem;
        margin-bottom: 15px;
    }
    
    .service-card {
        background: white;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 12px;
        padding: 25px;
        height: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .service-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transform: translateY(-5px);
        border-color: rgba(7, 42, 30, 0.1);
    }
    
    .service-icon {
        width: 45px;
        height: 45px;
        background: var(--primary-light);
        color: var(--primary-dark);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 20px;
    }
    
    .service-title {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 1.2rem;
        margin-bottom: 10px;
    }
    
    .service-desc {
        color: #6b7280;
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 15px;
    }
    
    .service-link {
        color: var(--primary-dark);
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .service-link:hover {
        color: #1a472a;
    }
    
    /* Card Khusus Berita */
    .news-snippet {
        background: #f9fbf9;
        border-radius: 8px;
        padding: 12px;
        display: flex;
        gap: 12px;
        align-items: center;
        margin-top: 20px;
    }
    
    .news-thumb {
        width: 50px;
        height: 50px;
        background: #e5e7eb;
        border-radius: 6px;
        object-fit: cover;
    }
    
    /* Card Statistik */
    .stat-card {
        background: linear-gradient(135deg, #0d2b5e, #1a4a7a);
        color: white;
        border-radius: 12px;
        padding: 30px;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::after {
        content: '\f201';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        bottom: -20px;
        right: -10px;
        font-size: 8rem;
        opacity: 0.05;
    }
    
    .stat-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 25px;
    }
    
    .stat-number {
        font-size: 2.2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 0.8rem;
        opacity: 0.8;
    }
    
    /* About Section */
    .about-section {
        padding: 100px 0;
        background: #f9fbf9;
    }
    
    .about-image-wrapper {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }
    
    .about-image {
        width: 100%;
        aspect-ratio: 1/1;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .visi-card {
        position: absolute;
        bottom: 20px;
        right: -20px;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        width: 250px;
        z-index: 10;
    }
    
    .tag-about {
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 1px;
        margin-bottom: 10px;
        display: block;
    }
</style>
@endpush

@section('public-content')

@php
    $profil = App\Models\ProfilDesa::first();
    $namaDesa = $profil ? $profil->nama_desa : 'Sidomulyo';
    
    // Get real stats dynamically from database
    $totalPenduduk = App\Models\Penduduk::count();
    $totalDusun = 6;
    
    // Get latest news
    $beritaTerbaru = App\Models\InformasiDesa::where('kategori', 'berita')
                        ->where('status_publish', 'publish')
                        ->latest()
                        ->first();

    // Get latest galeri photos
    $galeriTerbaru = App\Models\InformasiDesa::where('kategori', 'galeri')
                        ->where('status_publish', 'publish')
                        ->whereNotNull('gambar')
                        ->latest()
                        ->take(6)
                        ->get();

    // Get latest UMKM products safely
    $umkmTerbaru = \Illuminate\Support\Facades\Schema::hasTable('umkm_desa') 
                        ? App\Models\UmkmDesa::where('status', 'publish')->latest()->take(6)->get() 
                        : collect();
@endphp

<!-- ==================== HERO SECTION ==================== -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="badge-kecamatan">
                    <i class="fas fa-map-marker-alt"></i> KECAMATAN BIRU-BIRU
                </div>
                <h1 class="hero-title">Selamat Datang di website resmi desa sidomulyo</h1>
                <p class="hero-subtitle">
                    Pusat layanan digital dan informasi terpadu bagi warga {{ $namaDesa }}. Kami berkomitmen untuk memberikan pelayanan publik yang transparan, akuntabel, dan modern demi kemajuan bersama.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('login') }}" class="btn-hero-primary text-decoration-none">
                        Layanan Mandiri
                    </a>
                    <a href="{{ route('public.profil') }}" class="btn-hero-secondary text-decoration-none">
                        Jelajahi Desa <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="browser-mockup">
                    <div style="background: #f1f1f1; padding: 10px; border-bottom: 1px solid #e5e5e5; display: flex; gap: 6px;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #ff5f56;"></span>
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #ffbd2e;"></span>
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #27c93f;"></span>
                    </div>
                    @if($profil && $profil->logo)
    <img src="{{ asset('storage/' . $profil->logo) }}" alt="Kantor Desa {{ $namaDesa }}">
@elseif($profil && $profil->map)
    <img src="{{ asset('storage/' . $profil->map) }}" alt="Kantor Desa {{ $namaDesa }}">
@else
    <img src="https://images.unsplash.com/photo-1541888946425-d0fbb186a5b2?auto=format&fit=crop&w=1000&q=80" alt="Kantor Desa {{ $namaDesa }}">
@endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== LAYANAN DESA ==================== -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Akses Layanan Desa</h2>
            <p class="text-muted">Temukan kemudahan akses informasi dan administrasi desa hanya dengan beberapa klik.</p>
        </div>
        
        <div class="row g-4">
            
            <!-- Layanan Publik -->
            <div class="col-md-6">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-clipboard-list"></i></div>
                    <h4 class="service-title">Layanan Publik</h4>
                    <p class="service-desc">Urus surat menyurat, pengajuan dokumen kependudukan, dan izin lainnya secara daring dengan cepat dan mudah.</p>
                    <a href="{{ route('login') }}" class="service-link mt-2">Buat Pengajuan <i class="fas fa-chevron-right ms-1" style="font-size: 0.7rem;"></i></a>
                </div>
            </div>
            
            <!-- Berita Desa -->
            <div class="col-md-4">
                <div class="service-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="service-icon"><i class="far fa-newspaper"></i></div>
                        <i class="far fa-newspaper text-light" style="font-size: 4rem; opacity: 0.3; color: var(--primary-light);"></i>
                    </div>
                    <h4 class="service-title" style="margin-top: -30px;">Berita Desa</h4>
                    <p class="service-desc">Informasi terkini mengenai kegiatan dan program pembangunan di Desa {{ $namaDesa }}.</p>
                    
                    @if($beritaTerbaru)
                    <a href="{{ route('public.informasi.show', $beritaTerbaru->id_informasi) }}" class="text-decoration-none text-dark">
                        <div class="news-snippet" title="Klik untuk membaca selengkapnya">
                            @if($beritaTerbaru->gambar)
                                <img src="{{ asset('storage/' . $beritaTerbaru->gambar) }}" class="news-thumb" alt="Thumb">
                            @else
                                <div class="news-thumb d-flex align-items-center justify-content-center text-muted"><i class="fas fa-image"></i></div>
                            @endif
                            <div>
                                <h6 class="mb-1 text-success fw-bold" style="font-size: 0.85rem;">{{ Str::limit($beritaTerbaru->judul, 35) }}</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $beritaTerbaru->created_at->diffForHumans() }} • <span class="text-primary">Baca Detail <i class="fas fa-arrow-right" style="font-size: 0.65rem;"></i></span></small>
                            </div>
                        </div>
                    </a>
                    @else
                    <div class="news-snippet justify-content-center text-muted" style="font-size: 0.85rem;">
                        Belum ada berita.
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Galeri Kegiatan -->
            <div class="col-md-4">
                <div class="service-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="service-icon"><i class="far fa-images"></i></div>
                        <i class="far fa-images text-light" style="font-size: 3.5rem; opacity: 0.25; color: var(--primary-light);"></i>
                    </div>
                    <h4 class="service-title">Galeri Kegiatan</h4>
                    <p class="service-desc">Dokumentasi foto kegiatan & momen kemasyarakatan di {{ $namaDesa }}.</p>
                    
                    @if(count($galeriTerbaru) > 0)
                    <a href="#section-galeri" class="text-decoration-none text-dark">
                        <div class="news-snippet" title="Lihat Dokumentasi Galeri">
                            @if($galeriTerbaru->first()->gambar)
                                <img src="{{ asset('storage/' . $galeriTerbaru->first()->gambar) }}" class="news-thumb" alt="Thumb" style="object-fit: cover;">
                            @else
                                <div class="news-thumb d-flex align-items-center justify-content-center text-muted"><i class="fas fa-image"></i></div>
                            @endif
                            <div>
                                <h6 class="mb-1 text-success fw-bold" style="font-size: 0.85rem;">{{ Str::limit($galeriTerbaru->first()->judul, 35) }}</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ count($galeriTerbaru) }} Foto Terbaru • <span class="text-primary">Lihat Foto <i class="fas fa-arrow-down" style="font-size: 0.65rem;"></i></span></small>
                            </div>
                        </div>
                    </a>
                    @else
                    <div class="news-snippet justify-content-center text-muted" style="font-size: 0.85rem;">
                        Belum ada foto galeri.
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Statistik Desa -->
            <div class="col-md-4">
                <div class="stat-card">
                    <h4 class="stat-title">Statistik Desa</h4>
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <div class="stat-number">{{ number_format($totalPenduduk, 0, ',', '.') }}</div>
                            <div class="stat-label">Penduduk</div>
                        </div>
                        <div>
                            <div class="stat-number">{{ $totalDusun }}</div>
                            <div class="stat-label">RW/Dusun</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- ==================== GALERI KEGIATAN DESA ==================== -->
@if(count($galeriTerbaru) > 0)
<section class="py-5 bg-light" id="section-galeri">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
            <div>
                <span class="badge bg-primary text-uppercase px-3 py-2 rounded-pill mb-2" style="font-size: 0.75rem; background-color: #0d2b5e !important;">Dokumentasi Foto</span>
                <h3 class="fw-bold text-dark mb-0">Galeri Kegiatan {{ $namaDesa }}</h3>
                <p class="text-muted mb-0 small">Foto dokumentasi acara, program pembangunan, dan kegiatan masyarakat Desa {{ $namaDesa }}.</p>
            </div>
            <div>
                <a href="{{ route('public.informasi') }}" class="btn btn-outline-primary rounded-pill px-4" style="font-size: 0.85rem; font-weight: 600; color: #0d2b5e; border-color: #0d2b5e;">
                    Lihat Semua Informasi & Galeri <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($galeriTerbaru as $galeri)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                    <a href="{{ asset('storage/' . $galeri->gambar) }}" target="_blank" title="Klik untuk melihat foto penuh">
                        <img src="{{ asset('storage/' . $galeri->gambar) }}" 
                             alt="{{ $galeri->judul }}" 
                             class="w-100" 
                             style="height: 220px; object-fit: cover; transition: transform 0.3s ease;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'">
                    </a>
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">
                            {{ $galeri->judul }}
                        </h6>
                        <small class="text-muted d-block" style="font-size: 0.75rem;">
                            <i class="far fa-calendar-alt me-1 text-primary"></i> {{ optional($galeri->tanggal_posting)->format('d F Y') ?? $galeri->created_at->format('d F Y') }}
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ==================== TENTANG KAMI ==================== -->
<section class="about-section border-top">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 position-relative">
                <div class="about-image-wrapper">
                    @if($profil && $profil->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($profil->logo))
                        <img src="{{ asset('storage/' . ltrim($profil->logo, '/')) }}" alt="Kantor Desa" class="about-image">
                    @elseif($profil && $profil->map && \Illuminate\Support\Facades\Storage::disk('public')->exists($profil->map))
                        <img src="{{ asset('storage/' . ltrim($profil->map, '/')) }}" alt="Peta Desa" class="about-image">
                    @else
                        <img src="{{ asset('storage/profil/kantor-desa.jpeg') }}" alt="Pemandangan Desa" class="about-image">
                    @endif
                         
                    <div class="visi-card">
                        <h6 class="fw-bold text-dark mb-2" style="font-size: 0.9rem;">Visi Desa 2024</h6>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem; font-style: italic;">
                            "Mewujudkan {{ $namaDesa }} yang Mandiri, Religius, dan Berbudaya."
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <span class="tag-about text-uppercase">TENTANG KAMI</span>
                <h2 class="fw-bold text-dark mb-4" style="font-size: 2.2rem; line-height: 1.3;">Mengenal Desa {{ $namaDesa }} Lebih Dekat</h2>
                
                <p class="text-muted" style="line-height: 1.8;">
                    Desa {{ $namaDesa }} merupakan salah satu pilar kekuatan ekonomi di Kecamatan Biru-Biru. Dengan tanah yang subur dan masyarakat yang guyub rukun, desa ini bertransformasi menjadi pusat inovasi pertanian dan pariwisata lokal.
                </p>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    Sejarah panjang desa kami mencerminkan ketangguhan warga dalam menghadapi perubahan zaman, dengan tetap mempertahankan nilai-nilai kearifan lokal yang menjadi akar identitas kami.
                </p>
                
                <a href="{{ route('public.profil') }}" class="btn btn-outline-dark rounded-pill px-4 py-2" style="font-weight: 500;">
                    Selengkapnya <i class="fas fa-info-circle ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection