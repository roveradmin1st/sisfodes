@extends('layouts.dashboard')

@section('page-title', 'Laporan Pengajuan Surat')

@section('dashboard-content')
<style>
    html { scroll-behavior: smooth; }

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
    .card-header .card-title { font-weight: 700; color: #1a472a; font-size: 1rem; }
    .card-body { padding: 24px; }

    .filter-input {
        border-radius: 10px !important;
        border: 2px solid #e9ecef !important;
        padding: 8px 14px !important;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    .filter-input:focus {
        border-color: #1a472a !important;
        box-shadow: 0 0 0 4px rgba(26,71,42,0.08) !important;
        background: white;
    }
    .btn-filter {
        border-radius: 10px !important;
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white; border: none;
        padding: 10px 24px; font-size: 0.9rem; font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(26,71,42,0.2);
    }
    .btn-filter:hover { background: linear-gradient(135deg, #2d6a4f, #1a472a); color: white; transform: scale(1.02); }

    .btn-cetak {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white; border: none;
        padding: 8px 20px; border-radius: 10px; font-weight: 600; font-size: 0.85rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(13,110,253,0.2);
        text-decoration: none;
    }
    .btn-cetak:hover { transform: translateY(-2px) scale(1.03); box-shadow: 0 4px 15px rgba(13,110,253,0.3); color: white; }

    .table { margin-bottom: 0; font-size: 0.85rem; }
    .table thead th {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white; font-weight: 600; padding: 12px 14px;
        border-bottom: none; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.3px;
    }
    .table thead th:first-child { border-radius: 10px 0 0 0; }
    .table thead th:last-child  { border-radius: 0 10px 0 0; }
    .table tbody td { padding: 12px 14px; vertical-align: middle; border-bottom: 1px solid #f0f0f0; }
    .table tbody tr:hover { background: linear-gradient(90deg, #f8f9fa, #ffffff); }

    .badge-status { padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 0.75rem; }
    .badge-menunggu { background: #fff3cd; color: #856404; }
    .badge-diproses { background: #cff4fc; color: #055160; }
    .badge-selesai  { background: #d1e7dd; color: #0a3622; }
    .badge-ditolak  { background: #f8d7da; color: #58151c; }

    .nomor-surat { font-family: monospace; font-size: 0.8rem; color: #1a472a; font-weight: 600; }
    .text-keperluan { max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
</style>

{{-- FILTER --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('surat.laporan.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold" style="color:#1a472a; font-size:0.9rem;">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control filter-input" value="{{ $dari }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold" style="color:#1a472a; font-size:0.9rem;">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control filter-input" value="{{ $sampai }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-filter w-100">
                            <i class="fas fa-search me-1"></i> Tampilkan Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- TABEL LAPORAN --}}
<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">
            <i class="fas fa-file-alt me-2" style="color:#1a472a;"></i>
            Laporan Pengajuan Surat
            <small class="text-muted fw-normal ms-2" style="font-size:0.8rem;">
                Periode: {{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}
            </small>
        </h5>
        <a href="{{ route('surat.laporan.cetak-pdf', ['dari' => $dari, 'sampai' => $sampai]) }}"
           target="_blank" class="btn-cetak">
            <i class="fas fa-file-pdf me-1"></i> Unduh PDF
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width:45px;" class="text-center">No</th>
                        <th>Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Keperluan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Status</th>
                        <th>Nomor Surat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permohonan as $idx => $item)
                        <tr>
                            <td class="text-center fw-bold" style="color:#1a472a;">{{ $idx + 1 }}</td>
                            <td>
                                <strong>{{ $item->penduduk->nama ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $item->penduduk->nik ?? '-' }}</small>
                            </td>
                            <td>{{ $item->jenisSurat->nama_surat ?? '-' }}</td>
                            <td class="text-keperluan" title="{{ $item->keperluan }}">{{ $item->keperluan }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <span class="badge-status badge-{{ $item->status_permohonan }}">
                                    {{ ucfirst($item->status_permohonan) }}
                                </span>
                            </td>
                            <td class="nomor-surat">{{ $item->nomor_surat ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                Tidak ada data pengajuan surat pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($permohonan->count() > 0)
                <tfoot>
                    <tr style="background: #f8f9fa;">
                        <td colspan="6" class="text-end fw-bold pe-3" style="color:#1a472a;">Total Pengajuan:</td>
                        <td class="fw-bold" style="color:#1a472a;">{{ $permohonan->count() }} surat</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection
