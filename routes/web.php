<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;


//login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);

//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

//barang
Route::middleware('auth')->group(function () {
    Route::resource('barang', BarangController::class);
});

//kategori
Route::middleware('auth')->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('barang', BarangController::class);
});

//merek
Route::resource('merek', \App\Http\Controllers\MerekController::class)->middleware('auth');

//transaksi
Route::resource('transaksi', TransaksiController::class);
Route::put('/transaksi/{id_transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update');


//cetak
Route::get('transaksi/{id}/cetak', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');

//logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

