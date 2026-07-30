<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat';

    protected $primaryKey = 'id_jenis_surat';

    protected $fillable = [
        'nama_surat',
        'deskripsi',
        'syarat',
        'template_surat',
    ];

    public function permohonanSurat()
    {
        return $this->hasMany(PermohonanSurat::class, 'id_jenis_surat', 'id_jenis_surat');
    }
}
