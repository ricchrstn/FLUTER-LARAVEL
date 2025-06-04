<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('anggota', AnggotaController::class);
    Route::resource('transaksi', \App\Http\Controllers\TransaksiController::class);
    Route::get('/feedback', [\App\Http\Controllers\FeedbackController::class, 'myFeedback'])->name('feedback.my');
    Route::post('/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');
    Route::middleware('admin')->group(function () {
        Route::get('/admin/feedback', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedback.index');
        Route::put('/admin/feedback/{feedback}', [\App\Http\Controllers\FeedbackController::class, 'update'])->name('feedback.update');
        Route::delete('/admin/feedback/{feedback}', [\App\Http\Controllers\FeedbackController::class, 'destroy'])->name('feedback.destroy');
    });
});

Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

require __DIR__.'/auth.php';
