<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TentangController extends Controller
{
    public function index()
    {
        $data = [
            'nama' => 'Koperasi Mahasiswa',
            'deskripsi' => 'Koperasi Mahasiswa adalah lembaga keuangan yang dikelola oleh dan untuk mahasiswa.',
            'visi' => 'Menjadi lembaga keuangan terpercaya yang mendukung kesejahteraan mahasiswa.',
            'misi' => [
                'Memberikan layanan keuangan yang aman dan terpercaya',
                'Mendukung pengembangan usaha mahasiswa',
                'Meningkatkan literasi keuangan mahasiswa',
                'Mengembangkan jaringan kerjasama dengan berbagai pihak'
            ],
            'alamat' => 'Jl. Kampus No. 1, Kota',
            'telepon' => '(021) 1234567',
            'email' => 'info@kopma.ac.id',
            'website' => 'www.kopma.ac.id'
        ];

        return view('tentang.index', compact('data'));
    }

    public function edit()
    {
        $data = [
            'nama' => 'Koperasi Mahasiswa',
            'deskripsi' => 'Koperasi Mahasiswa adalah lembaga keuangan yang dikelola oleh dan untuk mahasiswa.',
            'visi' => 'Menjadi lembaga keuangan terpercaya yang mendukung kesejahteraan mahasiswa.',
            'misi' => [
                'Memberikan layanan keuangan yang aman dan terpercaya',
                'Mendukung pengembangan usaha mahasiswa',
                'Meningkatkan literasi keuangan mahasiswa',
                'Mengembangkan jaringan kerjasama dengan berbagai pihak'
            ],
            'alamat' => 'Jl. Kampus No. 1, Kota',
            'telepon' => '(021) 1234567',
            'email' => 'info@kopma.ac.id',
            'website' => 'www.kopma.ac.id'
        ];

        return view('tentang.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|array',
            'misi.*' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'required|url|max:255'
        ]);

        // Update data di database atau file konfigurasi
        // Untuk sementara kita hanya menampilkan data yang diupdate
        return redirect()->route('tentang.index')
            ->with('success', 'Informasi tentang koperasi berhasil diperbarui');
    }
} 