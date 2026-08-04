@extends('layouts.dashboard')

@section('page-title', 'Perangkat Desa')

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

    /* ===== FORM ROW ===== */
    .perangkat-row {
        padding: 12px 16px;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        background: #fafbfc;
        margin-bottom: 10px;
    }
    .perangkat-row:hover {
        background: white;
        border-color: #1a472a;
        box-shadow: 0 4px 20px rgba(26, 71, 42, 0.06);
        transform: translateX(4px);
    }
    .perangkat-row .jabatan-label {
        font-weight: 600;
        color: #1a472a;
        font-size: 0.85rem;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .perangkat-row .jabatan-label .badge-jabatan {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-kades {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
    }
    .badge-sekretaris {
        background: linear-gradient(135deg, #00695c, #00897b);
        color: white;
    }
    .badge-seksi {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #1b5e20;
    }
    .badge-urusan {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #0d47a1;
    }
    .badge-dusun {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        color: #bf360c;
    }

    /* ===== FORM CONTROL ===== */
    .form-control {
        border-radius: 10px;
        padding: 10px 16px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        background: #f8f9fa;
        font-size: 0.9rem;
        color: #1a1a1a;
    }
    .form-control:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
        background: white;
    }
    .form-control::placeholder {
        color: #adb5bd;
        font-size: 0.85rem;
    }

    /* ===== BUTTON STYLING ===== */
    .btn-simpan {
        padding: 10px 40px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        box-shadow: 0 4px 20px rgba(26, 71, 42, 0.25);
    }
    .btn-simpan:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 8px 30px rgba(26, 71, 42, 0.35);
        color: white;
    }
    .btn-simpan:active {
        transform: scale(0.95);
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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-body {
            padding: 16px;
        }
        .perangkat-row {
            padding: 10px 12px;
        }
        .perangkat-row .jabatan-label {
            font-size: 0.75rem;
            margin-bottom: 6px;
        }
        .form-control {
            padding: 8px 14px;
            font-size: 0.85rem;
        }
        .btn-simpan {
            padding: 8px 30px;
            font-size: 0.85rem;
            width: 100%;
        }
        .text-end {
            text-align: center !important;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .perangkat-row {
            padding: 8px 10px;
            border-radius: 8px;
        }
        .perangkat-row .jabatan-label {
            font-size: 0.65rem;
        }
        .perangkat-row .jabatan-label .badge-jabatan {
            font-size: 0.5rem;
            padding: 1px 8px;
        }
        .form-control {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }
        .btn-simpan {
            padding: 6px 20px;
            font-size: 0.8rem;
        }
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold text-success">
            <i class="fas fa-users me-2"></i>Perangkat Desa Sidomulyo
        </h5>
    </div>
    <div class="card-body">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                Terjadi kesalahan:
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('perangkat.update.all') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            @php
                $jabatans = [
                    'Kepala Desa' => 'kades',
                    'Sekretaris Desa' => 'sekretaris',
                    'Kepala Seksi Pemerintahan' => 'seksi',
                    'Kepala Seksi Kesejahteraan' => 'seksi',
                    'Kepala Seksi Pelayanan' => 'seksi',
                    'Kepala Urusan Tata Usaha & Umum' => 'urusan',
                    'Kepala Urusan Keuangan' => 'urusan',
                    'Kepala Urusan Perencanaan' => 'urusan',
                    'Kepala Dusun I' => 'dusun',
                    'Kepala Dusun II' => 'dusun',
                    'Kepala Dusun III' => 'dusun',
                    'Kepala Dusun IV' => 'dusun',
                    'Kepala Dusun V' => 'dusun',
                    'Kepala Dusun VI' => 'dusun',
                ];
            @endphp

            @foreach($jabatans as $jabatan => $jenis)
                @php
                    $index = $loop->index;
                    $perangkat = $perangkatData->firstWhere('jabatan', $jabatan);
                    $badgeClass = match($jenis) {
                        'kades' => 'badge-kades',
                        'sekretaris' => 'badge-sekretaris',
                        'seksi' => 'badge-seksi',
                        'urusan' => 'badge-urusan',
                        'dusun' => 'badge-dusun',
                        default => 'badge-seksi'
                    };
                    $fotoUrl = ($perangkat && $perangkat->foto) 
                        ? asset('storage/' . $perangkat->foto) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode(($perangkat->nama ?? '') ?: $jabatan) . '&background=1a472a&color=fff';
                @endphp
                <div class="perangkat-row row align-items-center py-2 mb-2 border-bottom">
                    <div class="col-lg-3 col-md-4 mb-2 mb-md-0">
                        <label class="jabatan-label d-block">
                            {{ $jabatan }}
                            <span class="badge-jabatan {{ $badgeClass }} ms-1">
                                {{ ucfirst($jenis) }}
                            </span>
                        </label>
                        <input type="hidden" name="jabatan[]" value="{{ $jabatan }}">
                    </div>
                    <div class="col-lg-4 col-md-4 mb-2 mb-md-0">
                        <input type="text" 
                               name="nama[]" 
                               class="form-control" 
                               value="{{ $perangkat->nama ?? '' }}"
                               placeholder="Masukkan nama {{ $jabatan }}">
                    </div>
                    <div class="col-lg-5 col-md-4 d-flex align-items-center gap-2">
                        <div class="flex-shrink-0">
                            <img id="preview-img-{{ $index }}" 
                                 src="{{ $fotoUrl }}" 
                                 alt="Foto {{ $jabatan }}" 
                                 class="rounded-circle border shadow-sm" 
                                 style="width: 48px; height: 48px; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1">
                            <input type="file" 
                                   name="foto[{{ $index }}]" 
                                   class="form-control form-control-sm foto-input" 
                                   accept="image/*"
                                   data-preview="preview-img-{{ $index }}">
                        </div>
                        @if($perangkat && $perangkat->foto)
                            <div class="form-check ms-1" title="Hapus foto saat ini">
                                <input class="form-check-input" type="checkbox" name="hapus_foto[{{ $index }}]" value="1" id="hapus_foto_{{ $index }}">
                                <label class="form-check-label text-danger small" for="hapus_foto_{{ $index }}">
                                    <i class="fas fa-trash-alt"></i>
                                </label>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <!-- Tombol Simpan di Kanan -->
            <div class="mt-4 text-end">
                <button type="submit" class="btn-simpan">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto hide alert setelah 5 detik
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        });
    }, 5000);

    // Live preview foto yang di-upload
    document.querySelectorAll('.foto-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const previewId = this.getAttribute('data-preview');
            const previewImg = document.getElementById(previewId);
            if (this.files && this.files[0] && previewImg) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    previewImg.src = evt.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
});
</script>

@endsection