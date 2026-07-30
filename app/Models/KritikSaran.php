<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KritikSaran extends Model
{
    use HasFactory;

    protected $table = 'kritik_saran';

    protected $primaryKey = 'id_pesan';

    protected $fillable = [
        'nama_pengirim',
        'email',
        'isi_pesan',
        'status',
        'balasan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
