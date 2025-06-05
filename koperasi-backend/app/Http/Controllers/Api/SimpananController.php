<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SimpananController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Simpanan::with('anggota.user');

            if ($request->filled('jenis_simpanan')) {
                $query->where('jenis_simpanan', $request->jenis_simpanan);
            }

            if ($request->filled('anggota_id')) {
                $query->where('anggota_id', $request->anggota_id);
            }

            $simpanan = $query->orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'status' => 'success',
                'data' => $simpanan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data simpanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'anggota_id' => 'required|exists:anggotas,id',
                'jenis_simpanan' => 'required|string',
                'jumlah' => 'required|numeric|min:0',
                'keterangan' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $simpanan = Simpanan::create([
                'anggota_id' => $request->anggota_id,
                'jenis_simpanan' => $request->jenis_simpanan,
                'jumlah' => $request->jumlah,
                'status' => 'pending',
                'keterangan' => $request->keterangan
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Simpanan berhasil dibuat',
                'data' => $simpanan
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membuat simpanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Simpanan $simpanan)
    {
        try {
            $simpanan->load('anggota.user');
            
            return response()->json([
                'status' => 'success',
                'data' => $simpanan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail simpanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function approve(Simpanan $simpanan)
    {
        try {
            if ($simpanan->status !== 'pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Simpanan tidak dapat disetujui karena status bukan pending'
                ], 422);
            }

            $simpanan->update([
                'status' => 'approved'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Simpanan berhasil disetujui',
                'data' => $simpanan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyetujui simpanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function reject(Simpanan $simpanan)
    {
        try {
            if ($simpanan->status !== 'pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Simpanan tidak dapat ditolak karena status bukan pending'
                ], 422);
            }

            $simpanan->update([
                'status' => 'rejected'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Simpanan berhasil ditolak',
                'data' => $simpanan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menolak simpanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 