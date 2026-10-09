<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cart = session()->get('cart', []);
        $totalItems = array_sum($cart);

        return view('shop.index', compact('products', 'totalItems'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->stok <= 0) {
            return back()->with('error', 'Barang ini sedang habis stok!');
        }

        $cart = session()->get('cart', []);
        $currentQty = $cart[$id] ?? 0;

        if ($currentQty + 1 > $product->stok) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia!');
        }

        $cart[$id] = $currentQty + 1;
        session()->put('cart', $cart);

        return back()->with('success', 'Barang berhasil dimasukkan ke keranjang.');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

        if (!empty($cart)) {
            $products = Product::whereIn('id_barang', array_keys($cart))->get()->keyBy('id_barang');

            foreach ($cart as $id => $qty) {
                if (isset($products[$id])) {
                    $p = $products[$id];
                    $subtotal = $p->harga * $qty;
                    $total += $subtotal;

                    $items[] = [
                        'id_barang' => $p->id_barang,
                        'nama_barang' => $p->nama_barang,
                        'harga' => $p->harga,
                        'stok' => $p->stok,
                        'gambar' => $p->gambar,
                        'jumlah' => $qty,
                        'subtotal' => $subtotal,
                    ];
                }
            }
        }

        return view('shop.cart', compact('items', 'total'));
    }

    public function updateCart(Request $request, $id, $action)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($action === 'plus') {
                if ($cart[$id] + 1 > $product->stok) {
                    return back()->with('error', 'Jumlah tidak boleh melebihi stok tersedia!');
                }
                $cart[$id]++;
            } elseif ($action === 'minus') {
                $cart[$id]--;
                if ($cart[$id] <= 0) {
                    unset($cart[$id]);
                }
            }
        }

        session()->put('cart', $cart);
        return back();
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Barang dihapus dari keranjang.');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang telah dikosongkan.');
    }
}