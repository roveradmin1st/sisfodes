<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penduduk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penduduk';

    protected $primaryKey = 'id_penduduk';

    protected $fillable = [
        'nik',
        'no_kk',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_perkawinan',
        'kewarganegaraan',
        'alamat',
        'dusun',
        'rt',
        'rw',
        'no_hp',
        'email',
        'status_penduduk',
        'is_kepala_keluarga',
        'tahun',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'nik', 'nik');
    }

    public function permohonanSurat()
    {
        return $this->hasMany(PermohonanSurat::class, 'id_penduduk', 'id_penduduk');
    }

    public function penerimaBantuan()
    {
        return $this->hasMany(PenerimaBantuan::class, 'id_penduduk', 'id_penduduk');
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }
}
