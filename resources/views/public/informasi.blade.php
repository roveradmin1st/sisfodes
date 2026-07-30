@extends('layouts.public')

@section('title', 'Informasi Desa Sidomulyo')

@section('public-content')

<div class="container py-5">
    
    <div class="mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0 text-uppercase">Informasi Desa</h4>
    </div>

    <!-- ============================================================ -->
    <!-- BERITA TERBARU                                              -->
    <!-- ============================================================ -->
    <div class="card border rounded-0 shadow-none mb-5">
        <div class="card-header bg-light border-bottom py-3">
            <h6 class="mb-0 fw-bold text-dark text-uppercase">Berita Terbaru</h6>
        </div>
        <div class="card-body">
            @if($berita->count() > 0)
                <div class="row g-4">
                    @foreach($berita as $item)
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border rounded-0 shadow-none">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" 
                                         class="card-img-top border-bottom rounded-0"
                                         style="height: 160px; object-fit: cover;" 
                                         alt="{{ $item->judul }}">
                                @else
                                    <div class="bg-light text-center py-4 border-bottom" style="height: 160px;">
                                        <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2" style="font-size: 0.95rem; color: #333;">
                                        {{ Str::limit($item->judul, 40) }}
                                    </h6>
                                    <p class="small text-muted mb-3" style="text-align: justify; line-height: 1.5;">
                                        {{ Str::limit(strip_tags($item->isi), 80) }}
                                    </p>
                                </div>
                                <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center pb-3">
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        {{ $item->tanggal_posting->format('d M Y') }}
                                    </small>
                                    <a href="#" class="btn btn-sm btn-outline-secondary">
                                        Baca
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <p class="mb-0">Belum ada berita</p>
                </div>
            @endif
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- PENGUMUMAN & AGENDA KEGIATAN                                -->
    <!-- ============================================================ -->
    <div class="row g-4 mb-5">

        <!-- PENGUMUMAN -->
        <div class="col-md-6">
            <div class="card border rounded-0 shadow-none h-100">
                <div class="card-header bg-light border-bottom py-3">
                    <h6 class="mb-0 fw-bold text-dark text-uppercase">Pengumuman</h6>
                </div>
                <div class="card-body p-0">
                    @if($pengumuman->count() > 0)
                        <ul class="list-group list-group-flush rounded-0">
                            @foreach($pengumuman as $item)
                                <li class="list-group-item p-3 border-bottom">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light border text-center p-2" style="min-width: 55px;">
                                                <div class="fw-bold text-dark" style="font-size: 1.1rem;">
                                                    {{ $item->tanggal_posting->format('d') }}
                                                </div>
                                                <div class="small text-muted text-uppercase" style="font-size: 0.7rem;">
                                                    {{ $item->tanggal_posting->format('M') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fw-bold mb-1" style="font-size: 0.9rem; color: #333;">
                                                {{ Str::limit($item->judul, 50) }}
                                            </h6>
                                            <p class="small text-muted mb-0" style="text-align: justify; line-height: 1.5;">
                                                {{ Str::limit(strip_tags($item->isi), 80) }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">
                            <p class="mb-0">Belum ada pengumuman</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- AGENDA KEGIATAN -->
        <div class="col-md-6">
            <div class="card border rounded-0 shadow-none h-100">
                <div class="card-header bg-light border-bottom py-3">
                    <h6 class="mb-0 fw-bold text-dark text-uppercase">Agenda Kegiatan</h6>
                </div>
                <div class="card-body p-0">
                    @if($agenda->count() > 0)
                        <ul class="list-group list-group-flush rounded-0">
                            @foreach($agenda as $item)
                                <li class="list-group-item p-3 border-bottom">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light border text-center p-2" style="min-width: 55px;">
                                                <div class="fw-bold text-dark" style="font-size: 1.1rem;">
                                                    {{ $item->tanggal_posting->format('d') }}
                                                </div>
                                                <div class="small text-muted text-uppercase" style="font-size: 0.7rem;">
                                                    {{ $item->tanggal_posting->format('M') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fw-bold mb-1" style="font-size: 0.9rem; color: #333;">
                                                {{ Str::limit($item->judul, 50) }}
                                            </h6>
                                            <p class="small text-muted mb-0" style="text-align: justify; line-height: 1.5;">
                                                {{ Str::limit(strip_tags($item->isi), 80) }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">
                            <p class="mb-0">Belum ada agenda</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- ============================================================ -->
    <!-- GALERI                                                       -->
    <!-- ============================================================ -->
    <div class="card border rounded-0 shadow-none">
        <div class="card-header bg-light border-bottom py-3">
            <h6 class="mb-0 fw-bold text-dark text-uppercase">Galeri Foto</h6>
        </div>
        <div class="card-body">
            @if($galeri->count() > 0)
                <div class="row g-3">
                    @foreach($galeri as $item)
                        <div class="col-md-3 col-6">
                            <div class="card border shadow-none rounded-0 h-100">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" 
                                         class="card-img-top rounded-0"
                                         style="height: 150px; object-fit: cover;" 
                                         alt="{{ $item->judul }}">
                                @else
                                    <div class="bg-light text-center py-4" style="height: 150px;">
                                        <i class="fas fa-image text-muted" style="font-size: 2.5rem;"></i>
                                    </div>
                                @endif
                                <div class="card-body p-2 text-center bg-light border-top">
                                    <p class="text-dark small mb-0" style="font-size: 0.8rem;">
                                        {{ Str::limit($item->judul, 30) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <p class="mb-0">Belum ada galeri foto</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection