<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    private function getCart(): array
    {
        $raw = Cookie::get('keranjang');
        if (!$raw) {
            return [];
        }
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }

    private function saveCart(array $cart)
    {
        return Cookie::make('keranjang', json_encode($cart), 60 * 24 * 7, '/', null, false, false);
    }

    public function index()
    {
        $barang = Barang::all();
        $cart = $this->getCart();

        $totalItems = array_sum($cart);

        return view('cart.index', compact('barang', 'totalItems'));
    }

    public function tambah($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return redirect()->route('cart.index');
        }

        $cart = $this->getCart();
        $cart[$id] = ($cart[$id] ?? 0) + 1;

        return redirect()->route('cart.index')->withCookie($this->saveCart($cart));
    }

    public function keranjang()
    {
        $cart = $this->getCart();
        $items = [];
        $total = 0;

        if (!empty($cart)) {
            $barangList = Barang::whereIn('id', array_keys($cart))->get()->keyBy('id');

            foreach ($cart as $id => $qty) {
                if (isset($barangList[$id])) {
                    $b = $barangList[$id];
                    $subtotal = $b->harga * (int)$qty;
                    $total += $subtotal;

                    $items[] = [
                        'id' => $b->id,
                        'nama' => $b->nama,
                        'harga' => $b->harga,
                        'jumlah' => (int)$qty,
                        'subtotal' => $subtotal,
                    ];
                }
            }
        }

        return view('cart.keranjang', compact('items', 'total'));
    }

    public function updateQty($id, $action)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            if ($action === 'plus') {
                $cart[$id]++;
            } elseif ($action === 'minus') {
                $cart[$id]--;
                if ($cart[$id] <= 0) {
                    unset($cart[$id]);
                }
            }
        }

        return redirect()->route('cart.keranjang')->withCookie($this->saveCart($cart));
    }

    public function hapusItem($id)
    {
        $cart = $this->getCart();
        unset($cart[$id]);

        return redirect()->route('cart.keranjang')->withCookie($this->saveCart($cart));
    }

    public function kosongkan()
    {
        return redirect()->route('cart.keranjang')->withCookie(Cookie::forget('keranjang'));
    }
}