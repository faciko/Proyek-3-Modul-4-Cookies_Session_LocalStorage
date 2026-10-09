<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. Proses Checkout
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Keranjang Anda kosong!');
        }

        $user = Auth::user();

        // Gunakan Database Transaction agar aman jika terjadi kegagalan
        DB::beginTransaction();
        try {
            $products = Product::whereIn('id_barang', array_keys($cart))->lockForUpdate()->get()->keyBy('id_barang');
            $totalHarga = 0;

            // Validasi ketersediaan stok sebelum checkout
            foreach ($cart as $id => $qty) {
                if (!isset($products[$id]) || $products[$id]->stok < $qty) {
                    DB::rollBack();
                    return redirect()->route('shop.cart')->with('error', 'Stok untuk barang ' . ($products[$id]->nama_barang ?? $id) . ' tidak mencukupi!');
                }
                $totalHarga += $products[$id]->harga * $qty;
            }

            // Buat ID Order unik (maks 15 karakter)
            $orderId = 'ORD' . date('ymd') . rand(100, 999);

            // Simpan ke tabel orders
            $order = Order::create([
                'id_order' => $orderId,
                'id_user' => $user->id_user,
                'tanggal_order' => now(),
                'total_harga' => $totalHarga,
                'alamat_pengiriman' => $user->alamat ?? 'Alamat default pelanggan',
            ]);

            // Simpan ke order_details dan kurangi stok
            foreach ($cart as $id => $qty) {
                $product = $products[$id];

                OrderDetail::create([
                    'id_order' => $orderId,
                    'id_barang' => $product->id_barang,
                    'harga_satuan' => $product->harga,
                    'jumlah_beli' => $qty,
                ]);

                // Kurangi stok barang
                $product->decrement('stok', $qty);
            }

            DB::commit();

            // Kosongkan keranjang belanja
            session()->forget('cart');

            return redirect()->route('orders.index')->with('success', 'Checkout berhasil! Pesanan ' . $orderId . ' telah dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('shop.cart')->with('error', 'Terjadi kesalahan saat memproses checkout: ' . $e->getMessage());
        }
    }

    // 2. Riwayat Pesanan Pengguna
    public function index()
    {
        $userId = Auth::user()->id_user;
        $orders = Order::with('details.product')
            ->where('id_user', $userId)
            ->orderBy('tanggal_order', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }
}