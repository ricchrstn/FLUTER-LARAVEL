<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class TransaksiExport implements FromView
{
    protected $request;
    
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        try {
            $query = Transaksi::with('anggota.user');

            // Filter berdasarkan jenis transaksi
            if ($this->request->filled('jenis')) {
                $query->where('jenis', $this->request->jenis);
            }

            // Filter berdasarkan anggota
            if ($this->request->filled('anggota_id')) {
                $query->where('anggota_id', $this->request->anggota_id);
            }

            // Filter berdasarkan tanggal
            if ($this->request->filled('tanggal_mulai')) {
                $tanggalMulai = Carbon::parse($this->request->tanggal_mulai)->startOfDay();
                $query->whereDate('created_at', '>=', $tanggalMulai);
            }

            if ($this->request->filled('tanggal_selesai')) {
                $tanggalSelesai = Carbon::parse($this->request->tanggal_selesai)->endOfDay();
                $query->whereDate('created_at', '<=', $tanggalSelesai);
            }

            // Validasi jika tidak ada data
            $transaksis = $query->orderBy('created_at', 'desc')->get();
            
            if ($transaksis->isEmpty()) {
                throw new \Exception('Tidak ada data transaksi yang ditemukan untuk periode ini.');
            }

            return view('laporan.export', compact('transaksis'));
            
        } catch (\Exception $e) {
            // Log error
            \Log::error('Error in TransaksiExport: ' . $e->getMessage());
            throw $e;
        }
    }
} 