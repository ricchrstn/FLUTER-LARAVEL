<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pinjaman = Pinjaman::with('anggota')
            ->latest()
            ->paginate(10);

        return view('pinjaman.index', compact('pinjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggota = Anggota::all();
        return view('pinjaman.create', compact('anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah' => 'required|numeric|min:0',
            'tenor' => 'required|integer|min:1',
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
        $data['angsuran'] = $data['jumlah'] / $data['tenor'];

        Pinjaman::create($data);

        return redirect()->route('pinjaman.index')
            ->with('success', 'Pinjaman berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pinjaman $pinjaman)
    {
        return view('pinjaman.show', compact('pinjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pinjaman $pinjaman)
    {
        $anggota = Anggota::all();
        return view('pinjaman.edit', compact('pinjaman', 'anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pinjaman $pinjaman)
    {
        $validator = Validator::make($request->all(), [
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah' => 'required|numeric|min:0',
            'tenor' => 'required|integer|min:1',
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
            if ($pinjaman->bukti_transfer) {
                Storage::disk('public')->delete($pinjaman->bukti_transfer);
            }
            
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $data['bukti_transfer'] = $path;
        }

        $data['angsuran'] = $data['jumlah'] / $data['tenor'];

        $pinjaman->update($data);

        return redirect()->route('pinjaman.index')
            ->with('success', 'Pinjaman berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pinjaman $pinjaman)
    {
        if ($pinjaman->bukti_transfer) {
            Storage::disk('public')->delete($pinjaman->bukti_transfer);
        }

        $pinjaman->delete();

        return redirect()->route('pinjaman.index')
            ->with('success', 'Pinjaman berhasil dihapus');
    }

    public function approve(Pinjaman $pinjaman)
    {
        $pinjaman->update(['status' => 'approved']);

        return redirect()->route('pinjaman.index')
            ->with('success', 'Pinjaman berhasil disetujui');
    }

    public function reject(Pinjaman $pinjaman)
    {
        $pinjaman->update(['status' => 'rejected']);

        return redirect()->route('pinjaman.index')
            ->with('success', 'Pinjaman berhasil ditolak');
    }
}
