<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - Toko Online</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background: #fafafa; }
        .navbar { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .nav-links { display: flex; gap: 15px; align-items: center; }
        .nav-links a { text-decoration: none; color: #007bff; font-weight: bold; }
        .container { background: white; border: 1px solid #e1e4e8; border-radius: 8px; padding: 25px; max-width: 900px; margin: 0 auto; }
        .alert { padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .qty-control { display: inline-flex; align-items: center; gap: 8px; }
        .btn-qty { background: #e9ecef; border: 1px solid #ced4da; padding: 2px 8px; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-qty:hover { background: #dee2e6; }
        .btn-remove { background: #dc3545; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 12px; }
        .btn-clear { background: #6c757d; color: white; border: none; padding: 8px 14px; border-radius: 4px; cursor: pointer; }
        .btn-checkout { background: #28a745; color: white; border: none; padding: 12px 24px; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .btn-checkout:hover { background: #218838; }
        .total-box { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-top: 2px solid #333; font-size: 18px; font-weight: bold; }
        .checkout-box { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 6px; padding: 20px; margin-top: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-size: 14px; font-weight: bold; }
        .form-group textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ced4da; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Toko Online Mandiri</h2>
        <div class="nav-links">
            <span>Halo, <strong>{{ Auth::user()->nama_lengkap }}</strong></span>
            <a href="{{ route('shop.index') }}">&laquo; Katalog Belanja</a>
            <a href="{{ route('orders.index') }}">Riwayat Pesanan</a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: bold;">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h3>Keranjang Belanja Anda</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if (count($items) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item['nama_barang'] }}</strong><br>
                                <small style="color: #666;">Stok tersedia: {{ $item['stok'] }}</small>
                            </td>
                            <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>
                                <div class="qty-control">
                                    <form action="{{ route('cart.update', [$item['id_barang'], 'minus']) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="btn-qty">-</button>
                                    </form>
                                    <span style="font-weight: bold; min-width: 20px; text-align: center;">{{ $item['jumlah'] }}</span>
                                    <form action="{{ route('cart.update', [$item['id_barang'], 'plus']) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="btn-qty" {{ $item['jumlah'] >= $item['stok'] ? 'disabled' : '' }}>+</button>
                                    </form>
                                </div>
                            </td>
                            <td style="font-weight: bold; color: #e65100;">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $item['id_barang']) }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="btn-remove">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-box">
                <span>Total Tagihan (Ongkir Rp 0):</span>
                <span style="color: #28a745;">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-clear" onclick="return confirm('Kosongkan semua barang dari keranjang?')">Kosongkan Keranjang</button>
                </form>
                <a href="{{ route('shop.index') }}" style="text-decoration: none; color: #007bff; font-weight: bold;">+ Tambah Barang Lain</a>
            </div>

            <div class="checkout-box">
                <h4 style="margin-top:0;">Form Konfirmasi Checkout</h4>
                <form action="{{ route('order.checkout') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="alamat">Alamat Pengiriman:</label>
                        <textarea id="alamat" name="alamat_pengiriman" rows="3" required placeholder="Masukkan alamat lengkap tujuan pengiriman">{{ Auth::user()->alamat ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn-checkout">Checkout Sekarang &raquo;</button>
                </form>
            </div>
        @else
            <div style="text-align: center; padding: 40px 20px;">
                <p style="color: #666; font-size: 16px;">Keranjang belanja Anda saat ini masih kosong.</p>
                <a href="{{ route('shop.index') }}" style="display: inline-block; background: #007bff; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">Mulai Belanja Sekarang</a>
            </div>
        @endif
    </div>
</body>
</html>
