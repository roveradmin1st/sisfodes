@extends('layouts.app')

@section('title', 'Detail Kartu Keluarga - ' . $no_kk)

@section('content')
<div class="container-fluid py-4">

    <!-- BREADCRUMB & BACK BUTTON -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1" style="font-size: 0.85rem;">
                    <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}" class="text-success text-decoration-none">Data Penduduk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kartu Keluarga {{ $no_kk }}</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark mb-0">
                <i class="fas fa-id-card text-success me-2"></i>Kartu Keluarga No. {{ $no_kk }}
            </h3>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('penduduk.create', ['no_kk' => $no_kk, 'mode' => 'anggota', 'from_kk' => '1']) }}" class="btn btn-success fw-bold shadow-sm" style="border-radius: 10px;">
                <i class="fas fa-user-plus me-1"></i> Tambah Anggota Keluarga Ini
            </a>
            <a href="{{ route('penduduk.index') }}" class="btn btn-outline-secondary fw-semibold" style="border-radius: 10px;">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- HEADER INFO KELUARGA -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #1a472a, #2d6a4f); color: white;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-2">
                        <i class="fas fa-house-user me-1"></i> KARTU KELUARGA
                    </div>
                    <h2 class="fw-bold mb-1">{{ $kepalaKeluarga->nama ?? 'Nama Tidak Terdaftar' }}</h2>
                    <p class="mb-2 opacity-90" style="font-size: 0.95rem;">
                        <i class="fas fa-map-marker-alt me-1 text-warning"></i>
                        {{ $kepalaKeluarga->dusun ? 'Dusun '.$kepalaKeluarga->dusun : $kepalaKeluarga->alamat }} 
                        @if($kepalaKeluarga->rt || $kepalaKeluarga->rw)
                            (RT {{ $kepalaKeluarga->rt ?? '-' }} / RW {{ $kepalaKeluarga->rw ?? '-' }})
                        @endif
                    </p>
                    <div class="d-flex gap-3 flex-wrap small opacity-75">
                        <span><i class="fas fa-fingerprint me-1"></i> NIK KK: {{ $kepalaKeluarga->nik ?? '-' }}</span>
                        <span><i class="fas fa-users me-1"></i> Total: {{ $anggotaKeluarga->count() }} Anggota Keluarga</span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="bg-white bg-opacity-10 p-3 rounded-4 d-inline-block text-center border border-white border-opacity-25">
                        <span class="d-block small text-white-50 text-uppercase fw-semibold">Nomor KK</span>
                        <span class="fs-4 fw-bold font-monospace text-warning">{{ $no_kk }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL DAFTAR ANGGOTA KELUARGA -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fas fa-users me-2 text-success"></i>Daftar Anggota Keluarga ({{ $anggotaKeluarga->count() }} Orang)
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap" style="min-width: 950px;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Hubungan Keluarga</th>
                        <th>Tempat, Tgl Lahir</th>
                        <th>JK</th>
                        <th>Pekerjaan</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anggotaKeluarga as $item)
                    <tr class="{{ $item->is_kepala_keluarga ? 'table-success bg-opacity-10' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="fw-bold text-success font-monospace" style="font-size: 0.85rem;">{{ $item->nik }}</span></td>
                        <td>
                            <strong>{{ $item->nama }}</strong>
                            @if($item->is_kepala_keluarga)
                                <span class="badge bg-success ms-1" style="font-size: 0.65rem;">KEPALA KELUARGA</span>
                            @endif
                        </td>
                        <td>
                            @if($item->is_kepala_keluarga)
                                <span class="badge bg-success text-white px-2 py-1">Kepala Keluarga</span>
                            @else
                                <span class="badge bg-secondary px-2 py-1">{{ $item->hubungan_keluarga ?? 'Anggota Keluarga' }}</span>
                            @endif
                        </td>
                        <td>
                            {{ $item->tempat_lahir }}<br>
                            <small class="text-muted">{{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d/m/Y') : '-' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'danger' }} bg-opacity-10 text-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'danger' }} border border-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'danger' }}">
                                {{ $item->jenis_kelamin }}
                            </span>
                        </td>
                        <td><small>{{ $item->pekerjaan ?? '-' }}</small></td>
                        <td>
                            <span class="badge bg-{{ $item->status_penduduk == 'tetap' ? 'success' : 'warning' }} text-white">
                                {{ ucfirst($item->status_penduduk) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('penduduk.show', $item->id_penduduk) }}" class="btn btn-outline-primary" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(Auth::user()->role == 'kaur_umum')
                                <a href="{{ route('penduduk.edit', $item->id_penduduk) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
