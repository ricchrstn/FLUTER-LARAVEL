<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function simpanan(Request $request)
    {
        try {
            $request->validate([
                'tanggal_mulai' => 'nullable|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
            ]);

            $query = Simpanan::with('anggota.user')
                ->select(
                    'jenis_simpanan',
                    DB::raw('COUNT(*) as total_transaksi'),
                    DB::raw('SUM(jumlah) as total_jumlah')
                )
                ->groupBy('jenis_simpanan');

            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('created_at', '>=', $request->tanggal_mulai);
            }

            if ($request->filled('tanggal_selesai')) {
                $query->whereDate('created_at', '<=', $request->tanggal_selesai);
            }

            $laporan = $query->get();

            return response()->json([
                'status' => 'success',
                'data' => $laporan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil laporan simpanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function pinjaman(Request $request)
    {
        try {
            $request->validate([
                'tanggal_mulai' => 'nullable|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
            ]);

            $query = Pinjaman::with('anggota.user')
                ->select(
                    'status',
                    DB::raw('COUNT(*) as total_pinjaman'),
                    DB::raw('SUM(jumlah_pinjaman) as total_jumlah'),
                    DB::raw('SUM(jumlah_pinjaman * bunga / 100) as total_bunga')
                )
                ->groupBy('status');

            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('created_at', '>=', $request->tanggal_mulai);
            }

            if ($request->filled('tanggal_selesai')) {
                $query->whereDate('created_at', '<=', $request->tanggal_selesai);
            }

            $laporan = $query->get();

            return response()->json([
                'status' => 'success',
                'data' => $laporan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil laporan pinjaman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function transaksi(Request $request)
    {
        try {
            $request->validate([
                'tanggal_mulai' => 'nullable|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
            ]);

            $query = Transaksi::with('anggota.user')
                ->select(
                    'jenis',
                    DB::raw('COUNT(*) as total_transaksi'),
                    DB::raw('SUM(jumlah) as total_jumlah')
                )
                ->groupBy('jenis');

            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('created_at', '>=', $request->tanggal_mulai);
            }

            if ($request->filled('tanggal_selesai')) {
                $query->whereDate('created_at', '<=', $request->tanggal_selesai);
            }

            $laporan = $query->get();

            return response()->json([
                'status' => 'success',
                'data' => $laporan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil laporan transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 