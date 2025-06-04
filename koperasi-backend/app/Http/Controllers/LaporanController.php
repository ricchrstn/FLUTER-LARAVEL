<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('anggota.user');
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('anggota_id')) {
            $query->where('anggota_id', $request->anggota_id);
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        $transaksis = $query->orderBy('created_at', 'desc')->get();
        $anggotas = Anggota::with('user')->get();
        return view('laporan.index', compact('transaksis', 'anggotas'));
    }

    public function export(Request $request)
    {
        // Export Excel dengan filter yang sama
        return Excel::download(new TransaksiExport($request), 'laporan_transaksi.xlsx');
    }
} 