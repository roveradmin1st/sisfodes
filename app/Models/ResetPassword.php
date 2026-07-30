<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    use HasFactory;

    protected $table = 'reset_password';

    protected $primaryKey = 'id_reset';

    protected $fillable = [
        'id_user',
        'email',
        'token',
        'expired_at',
        'status',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function isValid()
    {
        return $this->status === 'pending' && $this->expired_at > now();
    }
}
