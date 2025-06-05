<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';

    protected $fillable = [
        'anggota_id',
        'jumlah_pinjaman',
        'bunga',
        'jangka_waktu',
        'status',
        'tanggal_pinjaman',
        'tanggal_pelunasan',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_pinjaman' => 'datetime',
        'tanggal_pelunasan' => 'datetime',
        'jumlah_pinjaman' => 'decimal:2',
        'bunga' => 'decimal:2'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
