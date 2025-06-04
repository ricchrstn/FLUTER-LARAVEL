<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $jumlahAnggota = Anggota::count();
            $totalSimpanan = Transaksi::where('jenis', 'simpanan')->sum('jumlah');
            $totalPinjaman = Transaksi::where('jenis', 'pinjaman')->sum('jumlah');
            $jumlahTransaksi = Transaksi::count();
            return view('dashboard_admin', compact('jumlahAnggota', 'totalSimpanan', 'totalPinjaman', 'jumlahTransaksi'));
        } else {
            $anggota = Anggota::where('user_id', $user->id)->first();
            $totalSimpanan = $anggota ? Transaksi::where('anggota_id', $anggota->id)->where('jenis', 'simpanan')->sum('jumlah') : 0;
            $totalPinjaman = $anggota ? Transaksi::where('anggota_id', $anggota->id)->where('jenis', 'pinjaman')->sum('jumlah') : 0;
            $jumlahTransaksi = $anggota ? Transaksi::where('anggota_id', $anggota->id)->count() : 0;
            return view('dashboard_user', compact('totalSimpanan', 'totalPinjaman', 'jumlahTransaksi', 'user', 'anggota'));
        }
    }
} 