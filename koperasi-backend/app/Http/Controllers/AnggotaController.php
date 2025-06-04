<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::with('user')->get();
        return view('anggota.index', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nim' => 'required|string|unique:users',
            'phone' => 'nullable|string',
            'tanggal_daftar' => 'required|date',
            'status_anggota' => 'required|string',
            'alamat' => 'required|string'
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim,
            'phone' => $request->phone,
        ]);

        // Create anggota
        Anggota::create([
            'user_id' => $user->id,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status_anggota' => $request->status_anggota,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $anggota->user_id,
            'nim' => 'required|string|unique:users,nim,' . $anggota->user_id,
            'phone' => 'nullable|string',
            'tanggal_daftar' => 'required|date',
            'status_anggota' => 'required|string',
            'alamat' => 'required|string'
        ]);

        // Update user
        $anggota->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'phone' => $request->phone,
        ]);

        // Update anggota
        $anggota->update([
            'tanggal_daftar' => $request->tanggal_daftar,
            'status_anggota' => $request->status_anggota,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota)
    {
        $anggota->user->delete();
        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus');
    }
}
