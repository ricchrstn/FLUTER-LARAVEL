<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TentangController;

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
    Route::middleware(['auth'])->group(function () {
        Route::get('/simpanan', [SimpananController::class, 'index'])->name('simpanan.index');
        Route::get('/simpanan/create', [SimpananController::class, 'create'])->name('simpanan.create');
        Route::post('/simpanan', [SimpananController::class, 'store'])->name('simpanan.store');
        Route::get('/simpanan/{simpanan}', [SimpananController::class, 'show'])->name('simpanan.show');
        Route::get('/simpanan/{simpanan}/edit', [SimpananController::class, 'edit'])->name('simpanan.edit');
        Route::put('/simpanan/{simpanan}', [SimpananController::class, 'update'])->name('simpanan.update');
        Route::delete('/simpanan/{simpanan}', [SimpananController::class, 'destroy'])->name('simpanan.destroy');
        Route::post('/simpanan/{simpanan}/approve', [SimpananController::class, 'approve'])->name('simpanan.approve');
        Route::post('/simpanan/{simpanan}/reject', [SimpananController::class, 'reject'])->name('simpanan.reject');
    });
});

Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Tentang Routes
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang.index');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/tentang/edit', [TentangController::class, 'edit'])->name('tentang.edit');
    Route::put('/tentang', [TentangController::class, 'update'])->name('tentang.update');
});

// User Management Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // User Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Admin Routes
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
    Route::get('/admins/{admin}', [AdminController::class, 'show'])->name('admins.show');
    Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
    Route::post('/admins/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admins.toggle-status');
});

require __DIR__.'/auth.php';
