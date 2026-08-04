<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmDesa extends Model
{
    use HasFactory;

    protected $table = 'umkm_desa';

    protected $primaryKey = 'id_umkm';

    protected $fillable = [
        'nama_usaha',
        'pemilik',
        'kategori',
        'deskripsi',
        'alamat',
        'no_hp',
        'harga',
        'foto',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
