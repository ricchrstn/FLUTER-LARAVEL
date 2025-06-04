<?php

namespace App\Exports;

use App\Models\Transaksi;
use App\Models\Anggota;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $query = Transaksi::with('anggota.user');
        if ($this->request->filled('jenis')) {
            $query->where('jenis', $this->request->jenis);
        }
        if ($this->request->filled('anggota_id')) {
            $query->where('anggota_id', $this->request->anggota_id);
        }
        if ($this->request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $this->request->tanggal_mulai);
        }
        if ($this->request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $this->request->tanggal_selesai);
        }
        $transaksis = $query->orderBy('created_at', 'desc')->get();
        return view('laporan.export', compact('transaksis'));
    }
} 