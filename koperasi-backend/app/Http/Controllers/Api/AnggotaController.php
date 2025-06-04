<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Anggota::with('user')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_daftar' => 'required|date',
            'status_anggota' => 'required|string',
            'alamat' => 'required|string'
        ]);

        $anggota = Anggota::create($request->all());

        return response()->json([
            'message' => 'Anggota created successfully',
            'data' => $anggota->load('user')
        ], 201);
    }
} 