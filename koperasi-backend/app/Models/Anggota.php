<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_daftar',
        'status_anggota',
        'alamat'
    ];

    protected $casts = [
        'tanggal_daftar' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
