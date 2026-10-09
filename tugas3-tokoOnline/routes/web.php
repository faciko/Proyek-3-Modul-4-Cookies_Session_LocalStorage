<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// 1. Halaman Utama / Katalog Produk (Bisa diakses publik / tanpa login)
Route::get('/', [ShopController::class, 'index'])->name('shop.index');

// 2. Auth Routes (Login/Logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 3. Fitur yang Wajib Login (Keranjang, Checkout, & Riwayat Pesanan)
Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{id}', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
    Route::post('/cart/update/{id}/{action}', [ShopController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [ShopController::class, 'clearCart'])->name('cart.clear');

    Route::post('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});