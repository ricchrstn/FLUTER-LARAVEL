<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $simpanan = Simpanan::with('anggota')
            ->latest()
            ->paginate(10);

        return view('simpanan.index', compact('simpanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggota = Anggota::all();
        return view('simpanan.create', compact('anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'anggota_id' => 'required|exists:anggota,id',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $data['bukti_transfer'] = $path;
        }

        $data['status'] = 'pending';

        Simpanan::create($data);

        return redirect()->route('simpanan.index')
            ->with('success', 'Simpanan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Simpanan $simpanan)
    {
        return view('simpanan.show', compact('simpanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Simpanan $simpanan)
    {
        $anggota = Anggota::all();
        return view('simpanan.edit', compact('simpanan', 'anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Simpanan $simpanan)
    {
        $validator = Validator::make($request->all(), [
            'anggota_id' => 'required|exists:anggota,id',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
            'status' => 'required|in:pending,approved,rejected',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('bukti_transfer')) {
            // Hapus bukti transfer lama jika ada
            if ($simpanan->bukti_transfer) {
                Storage::disk('public')->delete($simpanan->bukti_transfer);
            }
            
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $data['bukti_transfer'] = $path;
        }

        $simpanan->update($data);

        return redirect()->route('simpanan.index')
            ->with('success', 'Simpanan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Simpanan $simpanan)
    {
        // Hapus bukti transfer jika ada
        if ($simpanan->bukti_transfer) {
            Storage::disk('public')->delete($simpanan->bukti_transfer);
        }

        $simpanan->delete();

        return redirect()->route('simpanan.index')
            ->with('success', 'Simpanan berhasil dihapus');
    }

    public function approve(Simpanan $simpanan)
    {
        $simpanan->update(['status' => 'approved']);

        return redirect()->route('simpanan.index')
            ->with('success', 'Simpanan berhasil disetujui');
    }

    public function reject(Simpanan $simpanan)
    {
        $simpanan->update(['status' => 'rejected']);

        return redirect()->route('simpanan.index')
            ->with('success', 'Simpanan berhasil ditolak');
    }
}
