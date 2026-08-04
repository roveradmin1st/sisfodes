<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BantuanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformasiDesaController;
use App\Http\Controllers\KelolaAkunController;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PerangkatDesaController;
use App\Http\Controllers\ProfilDesaController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
// ==================== TEMPORARY CLEANUP ROUTE ====================
Route::get('/cleanup-nik', function() {
    App\Models\User::where('nik', '1207070608980001')->delete();
    return "Data akun NIK 1207070608980001 telah berhasil di-reset! Silakan coba registrasi ulang dari awal.";
});

Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/profil-desa', [ProfilDesaController::class, 'publicIndex'])->name('public.profil');
Route::get('/perangkat-desa', [PerangkatDesaController::class, 'publicIndex'])->name('public.perangkat');
Route::get('/informasi-desa', [InformasiDesaController::class, 'publicIndex'])->name('public.informasi');
Route::get('/informasi-desa/{id}', [InformasiDesaController::class, 'publicShow'])->name('public.informasi.show');
Route::get('/bantuan-desa', [BantuanController::class, 'publicIndex'])->name('public.bantuan');
Route::get('/data-penduduk', [PendudukController::class, 'publicIndex'])->name('public.penduduk');
Route::get('/apbdesa', [\App\Http\Controllers\ApbdesaController::class, 'publicIndex'])->name('public.apbdesa');
Route::get('/umkm-desa', [\App\Http\Controllers\UmkmDesaController::class, 'publicIndex'])->name('public.umkm');
Route::get('/umkm-desa/{id}', [\App\Http\Controllers\UmkmDesaController::class, 'publicShow'])->name('public.umkm.show');
Route::get('/kritik-saran', [KritikSaranController::class, 'publicIndex'])->name('public.kritik-saran');
Route::post('/kritik-saran', [KritikSaranController::class, 'store'])->name('public.kritik-saran.store');

// ==================== AUTH ROUTES ====================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== RESET PASSWORD ROUTES ====================
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('/reset-password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/verify', [AuthController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('/reset-password/verify', [AuthController::class, 'verifyCode'])->name('password.verify');
Route::post('/reset-password/update', [AuthController::class, 'updatePassword'])->name('password.update');

// ==================== PROTECTED ROUTES ====================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard/kaur-umum', [DashboardController::class, 'kaurUmum'])
        ->name('dashboard.kaur-umum')
        ->middleware('role:kaur_umum');

    Route::get('/dashboard/kepala-desa', [DashboardController::class, 'kepalaDesa'])
        ->name('dashboard.kepala-desa')
        ->middleware('role:kepala_desa');

    Route::get('/dashboard/penduduk', [DashboardController::class, 'penduduk'])
        ->name('dashboard.penduduk')
        ->middleware('role:penduduk');

    // ==================== PENDUDUK ====================
    Route::get('/penduduk/search', [PendudukController::class, 'search'])->name('penduduk.search')->middleware('role:kaur_umum,kepala_desa');
    Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create')->middleware('role:kaur_umum');
    Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store')->middleware('role:kaur_umum');
    Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk.index')->middleware('role:kaur_umum,kepala_desa');
    Route::get('/penduduk/{penduduk}', [PendudukController::class, 'show'])->name('penduduk.show')->middleware('role:kaur_umum,kepala_desa');
    Route::get('/penduduk/{penduduk}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit')->middleware('role:kaur_umum');
    Route::put('/penduduk/{penduduk}', [PendudukController::class, 'update'])->name('penduduk.update')->middleware('role:kaur_umum');
    Route::delete('/penduduk/{penduduk}', [PendudukController::class, 'destroy'])->name('penduduk.destroy')->middleware('role:kaur_umum');

    // ==================== SURAT ====================
    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/jenis', [SuratController::class, 'jenisIndex'])->name('jenis.index');
        Route::middleware('role:kaur_umum')->group(function () {
            Route::get('/jenis/create', [SuratController::class, 'jenisCreate'])->name('jenis.create');
            Route::post('/jenis', [SuratController::class, 'jenisStore'])->name('jenis.store');
            Route::get('/jenis/{id}/edit', [SuratController::class, 'jenisEdit'])->name('jenis.edit');
            Route::put('/jenis/{id}', [SuratController::class, 'jenisUpdate'])->name('jenis.update');
            Route::delete('/jenis/{id}', [SuratController::class, 'jenisDestroy'])->name('jenis.destroy');
        });

        Route::get('/permohonan', [SuratController::class, 'permohonanIndex'])->name('permohonan.index');
        Route::get('/permohonan/create', [SuratController::class, 'permohonanCreate'])->name('permohonan.create')->middleware('role:penduduk');
        Route::post('/permohonan', [SuratController::class, 'permohonanStore'])->name('permohonan.store')->middleware('role:penduduk');
        Route::get('/permohonan/{id}', [SuratController::class, 'permohonanShow'])->name('permohonan.show');
        Route::get('/permohonan/{id}/cetak', [SuratController::class, 'permohonanCetak'])->name('permohonan.cetak');
        
        Route::middleware('role:kaur_umum,kepala_desa')->group(function () {
            Route::delete('/permohonan/{id}', [SuratController::class, 'permohonanDestroy'])->name('permohonan.destroy');
            Route::post('/permohonan/{id}/verifikasi', [SuratController::class, 'permohonanVerifikasi'])->name('permohonan.verifikasi');
            Route::post('/permohonan/{id}/upload-surat', [SuratController::class, 'permohonanUploadSurat'])->name('permohonan.upload-surat');
        });
    });

    // ==================== INFORMASI DESA ====================
    Route::resource('informasi', InformasiDesaController::class)->middleware('role:kaur_umum');

    // ==================== PROFIL DESA ====================
    Route::prefix('profil-desa')->name('profil.')->middleware('role:kaur_umum')->group(function () {
        Route::get('/admin', [ProfilDesaController::class, 'index'])->name('index');
        Route::get('/admin/edit', [ProfilDesaController::class, 'edit'])->name('edit');
        Route::post('/admin', [ProfilDesaController::class, 'store'])->name('store');
        Route::put('/admin', [ProfilDesaController::class, 'update'])->name('update');
        Route::post('/logo', [ProfilDesaController::class, 'updateLogo'])->name('update.logo');
        Route::post('/map', [ProfilDesaController::class, 'updateMap'])->name('update.map');
    });

    // ==================== PERANGKAT DESA ====================
    Route::resource('perangkat', PerangkatDesaController::class)->except(['show'])->middleware('role:kaur_umum');
    Route::post('/perangkat/update-all', [PerangkatDesaController::class, 'updateAll'])->name('perangkat.update.all')->middleware('role:kaur_umum');

    // ==================== BANTUAN ====================
    Route::get('/bantuan/search-penduduk', [BantuanController::class, 'searchPenduduk'])->name('bantuan.search-penduduk')->middleware('role:kaur_umum,kepala_desa');
    Route::get('/bantuan/filter', [BantuanController::class, 'filter'])->name('bantuan.filter')->middleware('role:kaur_umum,kepala_desa');
    Route::get('/bantuan/create', [BantuanController::class, 'create'])->name('bantuan.create')->middleware('role:kaur_umum');
    Route::post('/bantuan', [BantuanController::class, 'store'])->name('bantuan.store')->middleware('role:kaur_umum');
    Route::get('/bantuan', [BantuanController::class, 'index'])->name('bantuan.index')->middleware('role:kaur_umum,kepala_desa');
    Route::get('/bantuan/{bantuan}', [BantuanController::class, 'show'])->name('bantuan.show')->middleware('role:kaur_umum,kepala_desa');
    Route::get('/bantuan/{bantuan}/edit', [BantuanController::class, 'edit'])->name('bantuan.edit')->middleware('role:kaur_umum');
    Route::put('/bantuan/{bantuan}', [BantuanController::class, 'update'])->name('bantuan.update')->middleware('role:kaur_umum');
    Route::delete('/bantuan/{bantuan}', [BantuanController::class, 'destroy'])->name('bantuan.destroy')->middleware('role:kaur_umum');

    // ==================== BANTUAN PENDUDUK (TERPISAH) ====================
    Route::get('/data-bantuan-saya', [BantuanController::class, 'pendudukIndex'])->name('bantuan.penduduk');

    // ==================== UMKM DESA ====================
    Route::resource('umkm', \App\Http\Controllers\UmkmDesaController::class)->middleware('role:kaur_umum,kepala_desa');

    // ==================== KRITIK SARAN ====================
    Route::get('/kritik-saran', [KritikSaranController::class, 'index'])->name('kritik-saran.index')->middleware('role:kaur_umum,kepala_desa');
    Route::post('/kritik-saran/{id}/balas', [KritikSaranController::class, 'balas'])->name('kritik-saran.balas')->middleware('role:kaur_umum');
    Route::delete('/kritik-saran/{id}', [KritikSaranController::class, 'destroy'])->name('kritik-saran.destroy')->middleware('role:kaur_umum');

    // ==================== KRITIK SARAN PENDUDUK ====================
    Route::get('/kritik-saran-saya', [KritikSaranController::class, 'pendudukIndex'])->name('kritik-saran.penduduk')->middleware('role:penduduk');
    Route::post('/kritik-saran-saya', [KritikSaranController::class, 'pendudukStore'])->name('kritik-saran.penduduk.store')->middleware('role:penduduk');

    // ==================== KELOLA AKUN ====================
    Route::prefix('kelola-akun')->name('kelola-akun.')->middleware(['auth'])->group(function () {
        Route::get('/', [KelolaAkunController::class, 'index'])->name('index');
        Route::put('/update-foto', [KelolaAkunController::class, 'updateFoto'])->name('update-foto');
        Route::put('/update-password', [KelolaAkunController::class, 'updatePassword'])->name('update-password');
        Route::get('/hapus-foto', [KelolaAkunController::class, 'hapusFoto'])->name('hapus-foto');
    });
});
