<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FirebaseLoginController;
use App\Http\Controllers\Api\AnggotaController;
use App\Http\Controllers\Api\SimpananController;
use App\Http\Controllers\Api\PinjamanController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\TentangController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\LaporanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Firebase Authentication routes
Route::prefix('firebase')->group(function () {
    Route::post('/verify', [FirebaseLoginController::class, 'verify']);
    Route::post('/register', [FirebaseLoginController::class, 'register']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    
    // Anggota routes
    Route::apiResource('anggota', AnggotaController::class);
    
    // Simpanan routes
    Route::apiResource('simpanan', SimpananController::class);
    Route::post('/simpanan/{simpanan}/approve', [SimpananController::class, 'approve'])->middleware('admin');
    Route::post('/simpanan/{simpanan}/reject', [SimpananController::class, 'reject'])->middleware('admin');
    
    // Pinjaman routes
    Route::apiResource('pinjaman', PinjamanController::class);
    Route::post('/pinjaman/{pinjaman}/approve', [PinjamanController::class, 'approve'])->middleware('admin');
    Route::post('/pinjaman/{pinjaman}/reject', [PinjamanController::class, 'reject'])->middleware('admin');
    
    // Transaksi routes
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index']);
        Route::get('/export', [TransaksiController::class, 'export'])->middleware('admin');
    });
    
    // Laporan routes
    Route::prefix('laporan')->middleware('admin')->group(function () {
        Route::get('/simpanan', [LaporanController::class, 'simpanan']);
        Route::get('/pinjaman', [LaporanController::class, 'pinjaman']);
        Route::get('/transaksi', [LaporanController::class, 'transaksi']);
    });
    
    // Feedback routes
    Route::apiResource('feedback', FeedbackController::class);
    
    // Tentang routes
    Route::get('/tentang', [TentangController::class, 'index']);
    Route::middleware('admin')->group(function () {
        Route::put('/tentang', [TentangController::class, 'update']);
    });
}); 