<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanSurat extends Model
{
    use HasFactory;

    protected $table = 'permohonan_surat';

    protected $primaryKey = 'id_permohonan';

    protected $fillable = [
        'id_penduduk',
        'id_jenis_surat',
        'tanggal_pengajuan',
        'keperluan',
        'tanggal_meninggal',
        'tempat_meninggal',
        'file_persyaratan',
        'file_surat_scan',
        'status_permohonan',
        'catatan',
        'nomor_surat',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_meninggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'id_penduduk', 'id_penduduk');
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'id_jenis_surat', 'id_jenis_surat');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'menunggu' => 'Menunggu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        return $labels[$this->status_permohonan] ?? $this->status_permohonan;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'menunggu' => 'warning',
            'diproses' => 'info',
            'selesai' => 'success',
            'ditolak' => 'danger',
        ];

        return $badges[$this->status_permohonan] ?? 'secondary';
    }
}
