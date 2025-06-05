<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PinjamanController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Pinjaman::with('anggota.user');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('anggota_id')) {
                $query->where('anggota_id', $request->anggota_id);
            }

            $pinjaman = $query->orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'status' => 'success',
                'data' => $pinjaman
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data pinjaman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'anggota_id' => 'required|exists:anggotas,id',
                'jumlah_pinjaman' => 'required|numeric|min:0',
                'bunga' => 'required|numeric|min:0',
                'jangka_waktu' => 'required|integer|min:1',
                'keterangan' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $pinjaman = Pinjaman::create([
                'anggota_id' => $request->anggota_id,
                'jumlah_pinjaman' => $request->jumlah_pinjaman,
                'bunga' => $request->bunga,
                'jangka_waktu' => $request->jangka_waktu,
                'status' => 'pending',
                'keterangan' => $request->keterangan
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pinjaman berhasil dibuat',
                'data' => $pinjaman
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membuat pinjaman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Pinjaman $pinjaman)
    {
        try {
            $pinjaman->load('anggota.user');
            
            return response()->json([
                'status' => 'success',
                'data' => $pinjaman
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail pinjaman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function approve(Pinjaman $pinjaman)
    {
        try {
            if ($pinjaman->status !== 'pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pinjaman tidak dapat disetujui karena status bukan pending'
                ], 422);
            }

            $pinjaman->update([
                'status' => 'approved',
                'tanggal_pinjaman' => Carbon::now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pinjaman berhasil disetujui',
                'data' => $pinjaman
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyetujui pinjaman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function reject(Pinjaman $pinjaman)
    {
        try {
            if ($pinjaman->status !== 'pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pinjaman tidak dapat ditolak karena status bukan pending'
                ], 422);
            }

            $pinjaman->update([
                'status' => 'rejected'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pinjaman berhasil ditolak',
                'data' => $pinjaman
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menolak pinjaman',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 