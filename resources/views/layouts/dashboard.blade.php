@extends('layouts.app')

@section('content')
    @php 
            $role = Auth::user()->role;
        $sidebarConfig = [
            'kaur_umum' => [
                'gradient' => 'linear-gradient(135deg, #0d2b5e, #1a4a7a)',
                'active_bg' => 'rgba(33, 150, 243, 0.25)',
                'badge_bg' => '#2196f3',
                'icon' => 'fa-user-tie'
            ],
            'kepala_desa' => [
                'gradient' => 'linear-gradient(135deg, #0d2b5e, #1a4a7a)',
                'active_bg' => 'rgba(33, 150, 243, 0.25)',
                'badge_bg' => '#2196f3',
                'icon' => 'fa-user-cog'
            ],
            'penduduk' => [
                'gradient' => 'linear-gradient(135deg, #0d2b5e, #1a4a7a)',
                'active_bg' => 'rgba(33, 150, 243, 0.25)',
                'badge_bg' => '#2196f3',
                'icon' => 'fa-user'
            ]
        ];
        $config = $sidebarConfig[$role] ?? $sidebarConfig['kepala_desa'];
    @endphp

    <!-- SIDEBAR -->
    <div class="sidebar p-3 d-flex flex-column" style="width: 280px; background: {{ $config['gradient'] }};">
        <!-- Brand (Desktop) -->
        <div class="d-flex align-items-center mb-4 px-3">
            @if(Auth::user()->foto && Storage::disk('public')->exists(Auth::user()->foto))
                <img src="{{ asset('storage/' . Auth::user()->foto) }}" 
                     alt="Foto Profil" 
                     class="me-2 rounded-circle" 
                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);">
            @else
                <div class="me-2"
                    style="width: 40px; height: 40px; background: rgba(255,255,255,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas {{ $config['icon'] }} text-white fs-5"></i>
                </div>
            @endif
            <div>
                <span class="text-white fw-bold d-block" style="font-size: 0.95rem;">Desa Sidomulyo</span>
                <small class="text-white-50 d-block" style="font-size: 0.7rem; margin-top: -2px;">Kabupaten Deli Serdang</small>
                <small class="text-white-50" style="font-size: 0.75rem;">{{ Auth::user()->nama }}</small>
            </div>
        </div>
        <hr class="border-light opacity-25">

        <nav class="nav flex-column">
            @if($role == 'kaur_umum')
                <a href="{{ route('dashboard.kaur-umum') }}"
                    class="nav-link {{ request()->routeIs('dashboard.kaur-umum') ? 'active' : '' }}"
                    style="{{ request()->routeIs('dashboard.kaur-umum') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Dashboard</a>
                <a href="{{ route('penduduk.index') }}" class="nav-link {{ request()->routeIs('penduduk.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('penduduk.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Data Penduduk</a>
                <a href="{{ route('profil.index') }}" class="nav-link {{ request()->routeIs('profil.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('profil.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Profil Desa</a>
                <a href="{{ route('perangkat.index') }}"
                    class="nav-link {{ request()->routeIs('perangkat.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('perangkat.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Perangkat Desa</a>
                <a href="{{ route('informasi.index') }}"
                    class="nav-link {{ request()->routeIs('informasi.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('informasi.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Informasi Desa</a>
                <a href="{{ route('surat.jenis.index') }}"
                    class="nav-link {{ request()->routeIs('surat.jenis.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('surat.jenis.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Surat Keterangan</a>
                <a href="{{ route('surat.permohonan.index') }}"
                    class="nav-link {{ request()->routeIs('surat.permohonan.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('surat.permohonan.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Pengajuan Surat</a>
                <a href="{{ route('surat.laporan.index') }}"
                    class="nav-link {{ request()->routeIs('surat.laporan.index') ? 'active' : '' }}"
                    style="{{ request()->routeIs('surat.laporan.index') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Laporan Surat</a>
                <a href="{{ route('bantuan.index') }}" class="nav-link {{ request()->routeIs('bantuan.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('bantuan.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Data Bantuan</a>
                <a href="{{ route('umkm.index') }}" class="nav-link {{ request()->routeIs('umkm.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('umkm.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">UMKM Desa</a>
                <a href="{{ route('kritik-saran.index') }}"
                    class="nav-link {{ request()->routeIs('kritik-saran.index') ? 'active' : '' }}"
                    style="{{ request()->routeIs('kritik-saran.index') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Kritik & Saran</a>
                <a href="{{ route('kelola-akun.index') }}"
                    class="nav-link {{ request()->routeIs('kelola-akun.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('kelola-akun.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Kelola Akun</a>
            @elseif($role == 'kepala_desa')
                <a href="{{ route('dashboard.kepala-desa') }}"
                    class="nav-link {{ request()->routeIs('dashboard.kepala-desa') ? 'active' : '' }}"
                    style="{{ request()->routeIs('dashboard.kepala-desa') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Dashboard</a>
                <a href="{{ route('penduduk.index') }}" class="nav-link {{ request()->routeIs('penduduk.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('penduduk.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Data Penduduk</a>
                <a href="{{ route('surat.jenis.index') }}"
                    class="nav-link {{ request()->routeIs('surat.jenis.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('surat.jenis.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Surat Keterangan</a>
                <a href="{{ route('surat.permohonan.index') }}"
                    class="nav-link {{ request()->routeIs('surat.permohonan.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('surat.permohonan.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Pengajuan Surat</a>
                <a href="{{ route('surat.laporan.index') }}"
                    class="nav-link {{ request()->routeIs('surat.laporan.index') ? 'active' : '' }}"
                    style="{{ request()->routeIs('surat.laporan.index') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Laporan Surat</a>
                <a href="{{ route('bantuan.index') }}" class="nav-link {{ request()->routeIs('bantuan.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('bantuan.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Data Bantuan</a>
                <a href="{{ route('kritik-saran.index') }}"
                    class="nav-link {{ request()->routeIs('kritik-saran.index') ? 'active' : '' }}"
                    style="{{ request()->routeIs('kritik-saran.index') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Kritik & Saran</a>
                <a href="{{ route('kelola-akun.index') }}"
                    class="nav-link {{ request()->routeIs('kelola-akun.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('kelola-akun.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Kelola Akun</a>
            @elseif($role == 'penduduk')
                <a href="{{ route('dashboard.penduduk') }}"
                    class="nav-link {{ request()->routeIs('dashboard.penduduk') ? 'active' : '' }}"
                    style="{{ request()->routeIs('dashboard.penduduk') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Dashboard</a>
                <a href="{{ route('surat.jenis.index') }}"
                    class="nav-link {{ request()->routeIs('surat.jenis.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('surat.jenis.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Surat Keterangan</a>
                <a href="{{ route('surat.permohonan.create') }}"
                    class="nav-link {{ request()->routeIs('surat.permohonan.create') ? 'active' : '' }}"
                    style="{{ request()->routeIs('surat.permohonan.create') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Pengajuan Surat</a>
                <a href="{{ route('surat.permohonan.index') }}"
                    class="nav-link {{ request()->routeIs('surat.permohonan.index') ? 'active' : '' }}"
                    style="{{ request()->routeIs('surat.permohonan.index') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Status Pengajuan</a>
                <a href="{{ route('bantuan.penduduk') }}"
                    class="nav-link {{ request()->routeIs('bantuan.penduduk') ? 'active' : '' }}"
                    style="{{ request()->routeIs('bantuan.penduduk') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Data Bantuan</a>
                <a href="{{ route('kritik-saran.penduduk') }}"
                    class="nav-link {{ request()->routeIs('kritik-saran.penduduk') ? 'active' : '' }}"
                    style="{{ request()->routeIs('kritik-saran.penduduk') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Kritik & Saran</a>
                <a href="{{ route('kelola-akun.index') }}"
                    class="nav-link {{ request()->routeIs('kelola-akun.*') ? 'active' : '' }}"
                    style="{{ request()->routeIs('kelola-akun.*') ? 'background: ' . $config['active_bg'] . '; color: #fff;' : '' }}">Kelola Akun</a>
            @endif

            <div class="mt-2">
                <button type="button" id="btnLogout" class="nav-link text-white border-0 bg-transparent w-100 text-start">Logout</button>
                <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">@csrf</form>
            </div>
        </nav>

        <div class="mt-auto pt-4 pb-2 text-center">
            <small class="text-white-50">© 2026 Desa Sidomulyo</small>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <div>
                <h4 class="fw-bold mb-0">@yield('page-title', 'Dashboard')</h4>
                <small class="text-muted">Selamat datang, {{ Auth::user()->nama }}</small>
            </div>
            <div class="mt-2 mt-md-0">
                <span class="badge px-3 py-2" style="background: {{ $config['badge_bg'] }};">
                    <i class="fas {{ $config['icon'] }} me-1"></i>
                    {{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}
                </span>
            </div>
        </div>
        @yield('dashboard-content')
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const btnLogout = document.getElementById('btnLogout');
                const logoutForm = document.getElementById('logoutForm');
                if (btnLogout && logoutForm) {
                    btnLogout.addEventListener('click', function () {
                        Swal.fire({
                            title: 'Konfirmasi Logout',
                            html: `<div style="text-align: center;"><p style="font-size: 1.1rem; margin-bottom: 15px; color: #333;">Apakah Anda Yakin Ingin Logout?</p></div>`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Logout',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            background: 'white',
                            backdrop: 'rgba(0,0,0,0.5)',
                            customClass: { popup: 'rounded-4', title: 'fw-bold text-dark fs-4', confirmButton: 'btn btn-danger px-4 py-2', cancelButton: 'btn btn-secondary px-4 py-2', htmlContainer: 'text-center' }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({ icon: 'success', title: 'Berhasil Logout!', text: 'Anda telah berhasil keluar dari sistem.', timer: 1500, showConfirmButton: false, customClass: { popup: 'rounded-4', title: 'fw-bold text-success' } })
                                    .then(() => logoutForm.submit());
                            }
                        });
                    });
                }
            });
        </script>
    @endpush

@endsection