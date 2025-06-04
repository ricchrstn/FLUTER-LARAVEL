<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'anggota_id',
        'jenis',
        'jumlah',
        'keterangan',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
