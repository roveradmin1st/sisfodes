<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaBantuan extends Model
{
    use HasFactory;

    protected $table = 'penerima_bantuan';

    protected $primaryKey = 'id_penerima';

    protected $fillable = [
        'id_penduduk',
        'program_bantuan',
        'keterangan',
        'tanggal_terima',
        'status',
    ];

    protected $casts = [
        'tanggal_terima' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'id_penduduk', 'id_penduduk');
    }
}
