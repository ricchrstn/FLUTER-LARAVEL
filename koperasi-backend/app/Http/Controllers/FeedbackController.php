<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // Admin: lihat semua feedback
    public function index()
    {
        $feedbacks = Feedback::with('user')->orderBy('created_at', 'desc')->get();
        return view('feedback.index', compact('feedbacks'));
    }

    // User: kirim feedback
    public function store(Request $request)
    {
        $request->validate([
            'pesan' => 'required|string',
        ]);
        Feedback::create([
            'user_id' => Auth::id(),
            'pesan' => $request->pesan,
            'status' => 'baru',
        ]);
        return back()->with('success', 'Feedback berhasil dikirim');
    }

    // Admin: balas feedback
    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'balasan' => 'required|string',
        ]);
        $feedback->update([
            'balasan' => $request->balasan,
            'status' => 'dibalas',
        ]);
        return back()->with('success', 'Feedback berhasil dibalas');
    }

    // Admin: hapus feedback
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return back()->with('success', 'Feedback berhasil dihapus');
    }

    // User: lihat feedback sendiri
    public function myFeedback()
    {
        $feedbacks = Feedback::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('feedback.my', compact('feedbacks'));
    }
} 