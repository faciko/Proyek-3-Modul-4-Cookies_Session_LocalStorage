<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('cart.index');
});

Route::prefix('tugas2')->name('cart.')->group(function () {
    Route::get('/index', [CartController::class, 'index'])->name('index');
    Route::post('/tambah/{id}', [CartController::class, 'tambah'])->name('tambah');
    Route::get('/keranjang', [CartController::class, 'keranjang'])->name('keranjang');
    Route::post('/update/{id}/{action}', [CartController::class, 'updateQty'])->name('update');
    Route::post('/hapus/{id}', [CartController::class, 'hapusItem'])->name('hapus');
    Route::post('/kosongkan', [CartController::class, 'kosongkan'])->name('kosongkan');
});