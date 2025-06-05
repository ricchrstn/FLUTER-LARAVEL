<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Exports\TransaksiExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Transaksi::with('anggota.user');

            // Filter berdasarkan jenis transaksi
            if ($request->filled('jenis')) {
                $query->where('jenis', $request->jenis);
            }

            // Filter berdasarkan anggota
            if ($request->filled('anggota_id')) {
                $query->where('anggota_id', $request->anggota_id);
            }

            // Filter berdasarkan tanggal
            if ($request->filled('tanggal_mulai')) {
                $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
                $query->whereDate('created_at', '>=', $tanggalMulai);
            }

            if ($request->filled('tanggal_selesai')) {
                $tanggalSelesai = Carbon::parse($request->tanggal_selesai)->endOfDay();
                $query->whereDate('created_at', '<=', $tanggalSelesai);
            }

            $transaksis = $query->orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'status' => 'success',
                'data' => $transaksis
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function export(Request $request)
    {
        try {
            $request->validate([
                'jenis' => 'nullable|string',
                'anggota_id' => 'nullable|exists:anggotas,id',
                'tanggal_mulai' => 'nullable|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
            ]);

            $fileName = 'transaksi-' . Carbon::now()->format('Y-m-d') . '.xlsx';
            
            return Excel::download(new TransaksiExport($request), $fileName);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengekspor data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 