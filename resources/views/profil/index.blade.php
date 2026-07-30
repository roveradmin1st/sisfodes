@extends('layouts.dashboard')

@section('page-title', 'Profil Desa')

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

    /* ===== SECTION BOX ===== */
    .section-box {
        border: 2px solid #e9ecef;
        border-radius: 14px;
        padding: 18px 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: white;
        position: relative;
        overflow: hidden;
    }
    .section-box:hover {
        border-color: #1a472a;
        box-shadow: 0 8px 30px rgba(26, 71, 42, 0.06);
        transform: translateY(-2px);
    }
    .section-box .section-title {
        font-weight: 700;
        color: #1a472a;
        font-size: 0.9rem;
        margin-bottom: 0;
    }
    .section-box .section-title i {
        margin-right: 8px;
        color: #1a472a;
    }

    /* ===== TABLE STYLING ===== */
    .info-table {
        margin-bottom: 0;
    }
    .info-table tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-table tr:last-child {
        border-bottom: none;
    }
    .info-table tr:hover {
        background: linear-gradient(90deg, #f8f9fa, #ffffff);
    }
    .info-table th {
        font-weight: 600;
        color: #495057;
        padding: 10px 16px 10px 0;
        width: 25%;
        font-size: 0.85rem;
        position: relative;
    }
    .info-table th::after {
        content: ':';
        position: absolute;
        right: 8px;
        color: #adb5bd;
    }
    .info-table td {
        padding: 10px 16px;
        color: #212529;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .info-table td strong {
        color: #1a472a;
    }

    /* ===== BUTTON EDIT ===== */
    .btn-edit-section {
        background: linear-gradient(135deg, #fff3cd, #ffe69c);
        color: #856404;
        border: none;
        border-radius: 8px;
        padding: 4px 14px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-edit-section:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(133, 100, 4, 0.2);
        color: #856404;
    }

    /* ===== BUTTON SIMPAN ===== */
    .btn-simpan-section {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 6px 18px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-simpan-section:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
        color: white;
    }

    .btn-batal-section {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
        border: none;
        border-radius: 8px;
        padding: 6px 18px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-batal-section:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    /* ===== IMAGE CONTAINER ===== */
    .img-container {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 8px;
        transition: all 0.3s ease;
        background: white;
    }
    .img-container:hover {
        border-color: #1a472a;
        box-shadow: 0 8px 25px rgba(26, 71, 42, 0.08);
    }
    .img-container img {
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
    .img-container:hover img {
        transform: scale(1.02);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        padding: 40px 20px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border: 2px dashed #dee2e6;
    }
    .empty-state i {
        color: #adb5bd;
    }
    .empty-state h5 {
        color: #495057;
        font-weight: 600;
    }
    .empty-state p {
        color: #6c757d;
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

    /* ===== FORM ELEMENTS ===== */
    .form-control {
        border-radius: 10px;
        padding: 8px 14px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        background: #f8f9fa;
        font-size: 0.85rem;
    }
    .form-control:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
        background: white;
    }
    .form-label {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.8rem;
        margin-bottom: 2px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-body {
            padding: 16px;
        }
        .section-box {
            padding: 14px 16px;
        }
        .info-table th {
            font-size: 0.75rem;
            padding: 8px 10px 8px 0;
            width: 30%;
        }
        .info-table td {
            font-size: 0.8rem;
            padding: 8px 10px;
        }
        .img-container img {
            max-height: 120px !important;
        }
        .btn-edit-section {
            font-size: 0.65rem;
            padding: 3px 10px;
        }
        .btn-simpan-section, .btn-batal-section {
            font-size: 0.7rem;
            padding: 4px 12px;
        }
        .col-md-8 {
            margin-bottom: 16px;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .section-box {
            padding: 10px 12px;
            border-radius: 10px;
        }
        .section-box .section-title {
            font-size: 0.8rem;
        }
        .info-table th {
            font-size: 0.65rem;
            padding: 6px 6px 6px 0;
            width: 35%;
        }
        .info-table td {
            font-size: 0.7rem;
            padding: 6px 6px;
        }
        .info-table th::after {
            right: 4px;
        }
        .img-container img {
            max-height: 100px !important;
        }
        .btn-edit-section {
            font-size: 0.55rem;
            padding: 2px 8px;
        }
        .btn-simpan-section, .btn-batal-section {
            font-size: 0.6rem;
            padding: 3px 10px;
        }
        .empty-state {
            padding: 24px 12px;
        }
        .empty-state i {
            font-size: 2.5rem !important;
        }
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold text-success">
            <i class="fas fa-building me-2"></i>Profil Desa Sidomulyo
        </h5>
    </div>
    <div class="card-body">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>Terjadi kesalahan:
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if($profil)
            <!-- ==================== SEJARAH ==================== -->
            <div class="section-box mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="section-title">
                        <i class="fas fa-history"></i>Sejarah Singkat
                    </h6>
                    <button class="btn-edit-section" onclick="editSejarah()">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <div class="bg-light p-3 rounded-3" id="sejarahDisplay" style="border-left: 3px solid #1a472a;">
                    <p style="text-align: justify;" class="mb-0">{{ $profil->sejarah ?? 'Belum ada data sejarah' }}</p>
                </div>
                <div id="sejarahForm" style="display: none;" class="mt-2">
                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="sejarah" class="form-control" rows="4">{{ $profil->sejarah ?? '' }}</textarea>
                        <div class="mt-2">
                            <button type="submit" class="btn-simpan-section">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                            <button type="button" class="btn-batal-section" onclick="batalSejarah()">
                                <i class="fas fa-times me-1"></i>Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ==================== INFORMASI DESA ==================== -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="section-box">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="section-title">
                                <i class="fas fa-info-circle"></i>Informasi Desa
                            </h6>
                            <button class="btn-edit-section" onclick="editInfo()">
                                <i class="fas fa-edit me-1"></i>Edit
                            </button>
                        </div>
                        
                        <div id="infoDisplay">
                            <table class="info-table table table-borderless mb-0">
                                <tr>
                                    <th>Nama Desa</th>
                                    <td><strong>{{ $profil->nama_desa }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $profil->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <td>{{ $profil->kecamatan }}</td>
                                </tr>
                                <tr>
                                    <th>Kabupaten</th>
                                    <td>{{ $profil->kabupaten }}</td>
                                </tr>
                                <tr>
                                    <th>Luas Wilayah</th>
                                    <td>{{ $profil->luas_wilayah ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div id="infoForm" style="display: none;" class="mt-2">
                            <form action="{{ route('profil.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Nama Desa</label>
                                        <input type="text" name="nama_desa" class="form-control" value="{{ $profil->nama_desa }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" value="{{ $profil->alamat }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Kecamatan</label>
                                        <input type="text" name="kecamatan" class="form-control" value="{{ $profil->kecamatan }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Kabupaten</label>
                                        <input type="text" name="kabupaten" class="form-control" value="{{ $profil->kabupaten }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Luas Wilayah</label>
                                        <input type="text" name="luas_wilayah" class="form-control" value="{{ $profil->luas_wilayah }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Provinsi</label>
                                        <input type="text" name="provinsi" class="form-control" value="{{ $profil->provinsi ?? '' }}">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn-simpan-section">
                                        <i class="fas fa-save me-1"></i>Simpan
                                    </button>
                                    <button type="button" class="btn-batal-section" onclick="batalInfo()">
                                        <i class="fas fa-times me-1"></i>Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- ==================== KANTOR KEPALA DESA ==================== -->
                <div class="col-md-4">
                    <div class="section-box text-center">
                        <h6 class="section-title text-center mb-3">
                            <i class="fas fa-home"></i>Kantor Kepala Desa
                        </h6>
                        <div class="img-container">
                            @if($profil->logo)
                                <img src="{{ asset('storage/' . $profil->logo) }}" 
                                     alt="Kantor Kepala Desa" 
                                     class="img-fluid mb-2" 
                                     style="max-height: 150px; width: auto;">
                            @else
                                <div class="bg-light rounded-3 p-3 mb-2" style="border-radius: 8px;">
                                    <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted small mt-1">Belum ada gambar</p>
                                </div>
                            @endif
                        </div>
                        <form action="{{ url('/profil-desa/logo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input type="file" name="logo" class="form-control" accept="image/*" required style="border-radius: 8px 0 0 8px;">
                                <button type="submit" class="btn-simpan-section" style="border-radius: 0 8px 8px 0;">
                                    <i class="fas fa-upload me-1"></i>Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ==================== VISI ==================== -->
            <div class="section-box mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="section-title">
                        <i class="fas fa-eye"></i>Visi Desa Sidomulyo
                    </h6>
                    <button class="btn-edit-section" onclick="editVisi()">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                
                <div id="visiDisplay" class="bg-light p-3 rounded-3" style="border-left: 3px solid #0d6efd;">
                    <p style="text-align: justify;" class="mb-0">{{ $profil->visi ?? 'Belum ada visi' }}</p>
                </div>
                
                <div id="visiForm" style="display: none;" class="mt-2">
                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="visi" class="form-control" rows="3">{{ $profil->visi ?? '' }}</textarea>
                        <div class="mt-2">
                            <button type="submit" class="btn-simpan-section">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                            <button type="button" class="btn-batal-section" onclick="batalVisi()">
                                <i class="fas fa-times me-1"></i>Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ==================== MISI ==================== -->
            <div class="section-box mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="section-title">
                        <i class="fas fa-bullseye"></i>Misi Desa Sidomulyo
                    </h6>
                    <button class="btn-edit-section" onclick="editMisi()">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                
                <div id="misiDisplay" class="bg-light p-3 rounded-3" style="border-left: 3px solid #ffc107;">
                    <ol style="text-align: justify;" class="mb-0">
                        @if($profil->misi)
                            @foreach(explode("\n", $profil->misi) as $misi)
                                @if(trim($misi))
                                    <li>{{ trim($misi) }}</li>
                                @endif
                            @endforeach
                        @else
                            <li class="text-muted">Belum ada misi</li>
                        @endif
                    </ol>
                </div>
                
                <div id="misiForm" style="display: none;" class="mt-2">
                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="misi" class="form-control" rows="4">{{ $profil->misi ?? '' }}</textarea>
                        <small class="text-muted">* Pisahkan setiap misi dengan baris baru</small>
                        <div class="mt-2">
                            <button type="submit" class="btn-simpan-section">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                            <button type="button" class="btn-batal-section" onclick="batalMisi()">
                                <i class="fas fa-times me-1"></i>Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ==================== MAP / LOKASI ==================== -->
            <div class="section-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="section-title">
                        <i class="fas fa-map-marker-alt"></i>Lokasi Desa
                    </h6>
                    <button class="btn-simpan-section" onclick="uploadMap()">
                        <i class="fas fa-upload me-1"></i>Upload
                    </button>
                </div>
                @if($profil->map)
                    <div class="img-container text-center">
                        <img src="{{ asset('storage/' . $profil->map) }}" 
                             alt="Peta Desa" 
                             class="img-fluid rounded-3" 
                             style="max-height: 300px; width: 100%; object-fit: cover;">
                    </div>
                @else
                    <div class="empty-state text-center">
                        <i class="fas fa-map-marked-alt" style="font-size: 4rem;"></i>
                        <p class="text-muted mt-2">Belum ada peta lokasi</p>
                    </div>
                @endif
                
                <div id="mapForm" style="display: none;" class="mt-3">
                    <form action="{{ url('/profil-desa/map') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="file" name="map" class="form-control" accept="image/*" required style="border-radius: 8px 0 0 8px;">
                            <button type="submit" class="btn-simpan-section" style="border-radius: 0 8px 8px 0;">
                                <i class="fas fa-upload me-1"></i>Upload
                            </button>
                            <button type="button" class="btn-batal-section" onclick="batalMap()" style="border-radius: 8px;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        @else
            <div class="empty-state text-center">
                <i class="fas fa-building" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Belum ada data profil desa</h5>
                <p class="text-muted">Silakan tambahkan profil desa terlebih dahulu</p>
                <form action="{{ route('profil.store') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-simpan-section" style="padding: 10px 30px; font-size: 0.9rem;">
                        <i class="fas fa-plus me-1"></i>Tambah Profil
                    </button>
                </form>
            </div>
        @endif
        
    </div>
</div>

<script>
function editSejarah() {
    document.getElementById('sejarahDisplay').style.display = 'none';
    document.getElementById('sejarahForm').style.display = 'block';
}

function batalSejarah() {
    document.getElementById('sejarahDisplay').style.display = 'block';
    document.getElementById('sejarahForm').style.display = 'none';
}

function editInfo() {
    document.getElementById('infoDisplay').style.display = 'none';
    document.getElementById('infoForm').style.display = 'block';
}

function batalInfo() {
    document.getElementById('infoDisplay').style.display = 'block';
    document.getElementById('infoForm').style.display = 'none';
}

function editVisi() {
    document.getElementById('visiDisplay').style.display = 'none';
    document.getElementById('visiForm').style.display = 'block';
}

function batalVisi() {
    document.getElementById('visiDisplay').style.display = 'block';
    document.getElementById('visiForm').style.display = 'none';
}

function editMisi() {
    document.getElementById('misiDisplay').style.display = 'none';
    document.getElementById('misiForm').style.display = 'block';
}

function batalMisi() {
    document.getElementById('misiDisplay').style.display = 'block';
    document.getElementById('misiForm').style.display = 'none';
}

function uploadMap() {
    document.getElementById('mapForm').style.display = 'block';
}

function batalMap() {
    document.getElementById('mapForm').style.display = 'none';
}
</script>

@endsection