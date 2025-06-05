<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;

    protected $table = 'simpanan';

    protected $fillable = [
        'anggota_id',
        'jenis_simpanan',
        'jumlah',
        'tanggal',
        'keterangan',
        'status',
        'bukti_transfer'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'jumlah' => 'decimal:2'
    ];

    // Relasi dengan model Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // Scope untuk filter berdasarkan jenis simpanan
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis_simpanan', $jenis);
    }

    // Scope untuk filter berdasarkan status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    // Scope untuk filter berdasarkan range tanggal
    public function scopeRangeTanggal($query, $start, $end)
    {
        return $query->whereBetween('tanggal', [$start, $end]);
    }
}
