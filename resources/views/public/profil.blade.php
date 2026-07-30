@extends('layouts.public')

@section('title', 'Profil Desa Sidomulyo')

@section('public-content')

<div class="container py-5">
    
    <div class="mb-4 pb-2 border-bottom">
        <h4 class="fw-bold text-dark mb-0 text-uppercase">Profil Desa Sidomulyo</h4>
    </div>

    <!-- ==================== SEJARAH ==================== -->
    <div class="row mb-5">
        <div class="col-md-3">
            <h6 class="fw-bold text-muted text-uppercase mb-3">Sejarah Singkat</h6>
        </div>
        <div class="col-md-9">
            <div class="text-dark" style="text-align: justify; line-height: 1.8;">
                {{ $profil->sejarah ?? 'Belum ada data sejarah' }}
            </div>
        </div>
    </div>

    <!-- ==================== VISI ==================== -->
    <div class="row mb-5">
        <div class="col-md-3">
            <h6 class="fw-bold text-muted text-uppercase mb-3">Visi Desa</h6>
        </div>
        <div class="col-md-9">
            <div class="card rounded-0 border shadow-sm">
                <div class="card-body p-4 bg-light">
                    <p class="mb-0 fs-5 text-center fw-medium text-dark" style="line-height: 1.6;">
                        "{{ $profil->visi ?? 'Belum ada data visi' }}"
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MISI ==================== -->
    <div class="row mb-5">
        <div class="col-md-3">
            <h6 class="fw-bold text-muted text-uppercase mb-3">Misi Desa</h6>
        </div>
        <div class="col-md-9">
            <div class="card rounded-0 border shadow-none">
                <div class="card-body p-4">
                    @if($profil->misi)
                        <ol class="mb-0 ps-3" style="text-align: justify; line-height: 2;">
                            @foreach(explode("\n", $profil->misi) as $misi)
                                @if(trim($misi))
                                    <li>{{ trim($misi) }}</li>
                                @endif
                            @endforeach
                        </ol>
                    @else
                        <p class="mb-0 text-muted">Belum ada data misi</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== LOKASI KANTOR DESA + MAP ==================== -->
    <div class="row mb-5">
        <div class="col-md-3">
            <h6 class="fw-bold text-muted text-uppercase mb-3">Lokasi Kantor</h6>
        </div>
        <div class="col-md-9">
            <div class="card rounded-0 border shadow-none mb-4">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <small class="text-muted text-uppercase d-block mb-1">Alamat</small>
                            <span class="text-dark">{{ $profil->alamat ?? 'Jl. Desa Sidomulyo, Kecamatan Biru-Biru, Kabupaten Deli Serdang' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase d-block mb-1">Telepon</small>
                            <span class="text-dark">{{ $profil->telepon ?? '061-1234567' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase d-block mb-1">Email</small>
                            <span class="text-dark">{{ $profil->email ?? 'desa.sidomulyo@gmail.com' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase d-block mb-1">Kode Pos</small>
                            <span class="text-dark">{{ $profil->kode_pos ?? '20376' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAP Google Maps -->
            <div class="border bg-light p-1">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.456789!2d98.6789!3d3.4567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM8KwMjcnMjQuMCJOIDk4wrA0MCcwMC4wIkU!5e0!3m2!1sid!2sid!4v1700000000000"
                    width="100%" height="350" style="border:0;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>

@endsection