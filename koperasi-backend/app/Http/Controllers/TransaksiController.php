<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Anggota;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jenis = $request->get('jenis');
        $query = Transaksi::with('anggota.user');
        if ($jenis) {
            $query->where('jenis', $jenis);
        }
        $transaksis = $query->orderBy('created_at', 'desc')->get();
        return view('transaksi.index', compact('transaksis', 'jenis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggotas = Anggota::with('user')->get();
        return view('transaksi.create', compact('anggotas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'jenis' => 'required|in:simpanan,pinjaman',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);
        Transaksi::create($request->all());
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $anggotas = Anggota::with('user')->get();
        return view('transaksi.edit', compact('transaksi', 'anggotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'jenis' => 'required|in:simpanan,pinjaman',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);
        $transaksi->update($request->all());
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
