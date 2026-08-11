@extends('layouts.public')

@section('title', 'Data Penduduk - Desa Sidomulyo')

@section('public-content')
<div class="container py-5">
    
    <!-- Searchable Table Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3 d-flex flex-column align-items-center text-center">
                    <h4 class="fw-bold text-success mb-2">Cek Data Penduduk</h4>
                    <p class="text-muted mb-4">Masukkan 16 digit NIK Anda untuk memverifikasi data kependudukan secara detail.</p>
                    <form action="{{ route('public.penduduk') }}" method="GET" class="w-100" style="max-width: 600px;">
                        @if(request('dusun'))
                            <input type="hidden" name="dusun" value="{{ request('dusun') }}">
                        @endif
                        <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden">
                            <input type="text" name="search" class="form-control border-0 px-4" placeholder="Masukkan 16 Digit NIK..." value="{{ $search }}" maxlength="16" required>
                            <button type="submit" class="btn btn-success px-4 fw-bold">Cari Data</button>
                        </div>
                    </form>
                </div>
                
                @if($search)
                <div class="card-body bg-light mt-2 rounded-bottom">
                    @if($searchedPenduduk)
                        <div class="p-4 bg-white rounded-3 shadow-sm border-start border-4 border-success">
                            <h5 class="fw-bold mb-4 border-bottom pb-2">Informasi Detail Penduduk</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Nomor Induk Kependudukan (NIK)</small>
                                    <span class="fw-bold fs-6">{{ $searchedPenduduk->nik }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Nomor Kartu Keluarga (KK)</small>
                                    <span class="fw-bold fs-6">{{ $searchedPenduduk->no_kk }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Nama Lengkap</small>
                                    <span class="fw-bold fs-6 text-uppercase">{{ $searchedPenduduk->nama }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Tempat, Tanggal Lahir</small>
                                    <span class="fw-bold fs-6">{{ $searchedPenduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($searchedPenduduk->tanggal_lahir)->format('d F Y') }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Jenis Kelamin</small>
                                    <span class="fw-bold fs-6">{{ $searchedPenduduk->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Agama</small>
                                    <span class="fw-bold fs-6">{{ $searchedPenduduk->agama }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Status Perkawinan</small>
                                    <span class="fw-bold fs-6">{{ $searchedPenduduk->status_perkawinan }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Pekerjaan</small>
                                    <span class="fw-bold fs-6">{{ $searchedPenduduk->pekerjaan }}</span>
                                </div>
                                <div class="col-12 mt-2">
                                    <small class="text-muted d-block">Alamat Lengkap</small>
                                    <span class="fw-bold fs-6">{{ $searchedPenduduk->alamat }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="text-danger mb-3"><i class="fas fa-exclamation-circle fa-4x opacity-50"></i></div>
                            <h5 class="fw-bold text-dark">Data Tidak Ditemukan!</h5>
                            <p class="text-muted mb-0">NIK <strong>{{ $search }}</strong> tidak terdaftar dalam database kependudukan Desa Sidomulyo.</p>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="mb-5 border-bottom pb-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h3 class="fw-bold text-dark text-uppercase mb-0">Statistik Data Penduduk</h3>
            <p class="text-muted mt-2 mb-0">Visualisasi data kependudukan Desa Sidomulyo Tahun 2025</p>
        </div>
        <div>
            <form action="{{ route('public.penduduk') }}" method="GET" class="d-flex gap-2">
                <select name="dusun" class="form-select border-0 shadow-sm" onchange="this.form.submit()" style="min-width: 200px;">
                    <option value="">Semua Dusun</option>
                    @foreach($allDusun as $d)
                        <option value="{{ $d }}" {{ $selectedDusun == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <!-- Chart Row 1 -->
    <div class="row g-4 mb-4">
        <!-- Gender Chart (Pie) -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h5 class="fw-bold text-success mb-0">Berdasarkan Jenis Kelamin</h5>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="position: relative; height:350px;">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Religion Chart (Doughnut) -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h5 class="fw-bold text-success mb-0">Berdasarkan Agama</h5>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="position: relative; height:350px;">
                    <canvas id="agamaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Row 2 -->
    <div class="row g-4">
        <!-- Dusun Chart (Bar) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h5 class="fw-bold text-success mb-0">Sebaran Penduduk per Dusun</h5>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="position: relative; height:400px; width:100%;">
                    @if(empty($dusunData) || count($dusunData) <= 1)
                        <div class="text-muted">Data hanya menampilkan 1 dusun. Silakan ubah filter ke "Semua Dusun".</div>
                    @else
                        <canvas id="dusunChart"></canvas>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Row 3 (Pendidikan & Pekerjaan) -->
    <div class="row g-4 mt-1">
        <!-- Pendidikan Chart (Pie) -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h5 class="fw-bold text-success mb-0">Berdasarkan Pendidikan</h5>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="position: relative; height:400px;">
                    <canvas id="pendidikanChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pekerjaan Chart (Bar Horizontal) -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h5 class="fw-bold text-success mb-0">Top 10 Pekerjaan</h5>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="position: relative; height:400px; width: 100%;">
                    <canvas id="pekerjaanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Default Font Family
    Chart.defaults.font.family = "'Nunito', 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif";
    Chart.defaults.color = '#555';

    // 1. Gender Pie Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    const genderLabels = {!! json_encode(array_keys($genderData)) !!};
    const genderValues = {!! json_encode(array_values($genderData)) !!};
    
    new Chart(genderCtx, {
        type: 'pie',
        data: {
            labels: genderLabels,
            datasets: [{
                data: genderValues,
                backgroundColor: ['#4e73df', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#e02d1b'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                borderWidth: 2
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 2. Religion Doughnut Chart
    const agamaCtx = document.getElementById('agamaChart').getContext('2d');
    const agamaLabels = {!! json_encode(array_keys($agamaData)) !!};
    const agamaValues = {!! json_encode(array_values($agamaData)) !!};
    
    // Generate dynamic colors based on length
    const colors = ['#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69'];
    
    new Chart(agamaCtx, {
        type: 'doughnut',
        data: {
            labels: agamaLabels,
            datasets: [{
                data: agamaValues,
                backgroundColor: colors.slice(0, agamaLabels.length),
                borderWidth: 2
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 3. Dusun Bar Chart
    @if(count($dusunData) > 1)
    const dusunCtx = document.getElementById('dusunChart').getContext('2d');
    const dusunLabels = {!! json_encode(array_keys($dusunData)) !!};
    const dusunValues = {!! json_encode(array_values($dusunData)) !!};
    
    new Chart(dusunCtx, {
        type: 'bar',
        data: {
            labels: dusunLabels,
            datasets: [{
                label: 'Jumlah Penduduk',
                data: dusunValues,
                backgroundColor: '#1cc88a',
                hoverBackgroundColor: '#17a673',
                borderColor: '#17a673',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10
                    }
                }
            }
        }
    });
    @endif

    // 4. Pendidikan Doughnut Chart
    const pendidikanCtx = document.getElementById('pendidikanChart').getContext('2d');
    const pendidikanLabels = {!! json_encode(array_keys($pendidikanData)) !!};
    const pendidikanValues = {!! json_encode(array_values($pendidikanData)) !!};
    
    const pendColors = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
        '#858796', '#5a5c69', '#fd7e14', '#20c997', '#6f42c1', '#e83e8c'
    ];
    
    new Chart(pendidikanCtx, {
        type: 'doughnut',
        data: {
            labels: pendidikanLabels,
            datasets: [{
                data: pendidikanValues,
                backgroundColor: pendColors.slice(0, pendidikanLabels.length),
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '50%',
            plugins: {
                legend: { position: 'right' }
            }
        }
    });

    // 5. Pekerjaan Horizontal Bar Chart
    const pekerjaanCtx = document.getElementById('pekerjaanChart').getContext('2d');
    const pekerjaanLabels = {!! json_encode(array_keys($pekerjaanData)) !!};
    const pekerjaanValues = {!! json_encode(array_values($pekerjaanData)) !!};
    
    new Chart(pekerjaanCtx, {
        type: 'bar',
        data: {
            labels: pekerjaanLabels,
            datasets: [{
                label: 'Jumlah',
                data: pekerjaanValues,
                backgroundColor: '#36b9cc',
                hoverBackgroundColor: '#2c9faf',
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y', // Makes it horizontal
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection
