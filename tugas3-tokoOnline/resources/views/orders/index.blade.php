<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan - Toko Online</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background: #fafafa; }
        .navbar { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .nav-links { display: flex; gap: 15px; align-items: center; }
        .nav-links a { text-decoration: none; color: #007bff; font-weight: bold; }
        .container { max-width: 900px; margin: 0 auto; }
        .alert { padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .order-card { background: white; border: 1px solid #e1e4e8; border-radius: 8px; margin-bottom: 20px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .order-header { background: #f8f9fa; padding: 15px 20px; border-bottom: 1px solid #e1e4e8; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
        .order-body { padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
        th { font-size: 13px; color: #666; background: #fcfcfc; }
        .total-badge { font-size: 16px; font-weight: bold; color: #28a745; }
        .tag-order { background: #007bff; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Toko Online Mandiri</h2>
        <div class="nav-links">
            <span>Halo, <strong>{{ Auth::user()->nama_lengkap }}</strong></span>
            <a href="{{ route('shop.index') }}">&laquo; Belanja Lagi</a>
            <a href="{{ route('shop.cart') }}">Keranjang Belanja</a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: bold;">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h3>Riwayat Pesanan Saya</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if ($orders->count() > 0)
            @foreach ($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <span class="tag-order">#{{ $order->id_order }}</span>
                            <span style="color: #666; margin-left: 10px; font-size: 13px;">
                                Tanggal: {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y, H:i') }}
                            </span>
                        </div>
                        <div>
                            <span style="font-size: 13px; color: #666;">Total Transaksi: </span>
                            <span class="total-badge">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="order-body">
                        <p style="margin-top: 0; font-size: 13px; color: #555;">
                            <strong>Alamat Pengiriman:</strong> {{ $order->alamat_pengiriman }}
                        </p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Harga Satuan (Arsip)</th>
                                    <th style="text-align: center;">Jumlah Beli</th>
                                    <th style="text-align: right;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->details as $detail)
                                    <tr>
                                        <td>
                                            <strong>{{ $detail->product->nama_barang ?? $detail->id_barang }}</strong>
                                        </td>
                                        <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td style="text-align: center;">{{ $detail->jumlah_beli }}</td>
                                        <td style="text-align: right; font-weight: bold; color: #e65100;">
                                            Rp {{ number_format($detail->harga_satuan * $detail->jumlah_beli, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @else
            <div class="order-card" style="text-align: center; padding: 40px 20px;">
                <p style="color: #666; font-size: 16px;">Anda belum memiliki riwayat pesanan.</p>
                <a href="{{ route('shop.index') }}" style="display: inline-block; background: #007bff; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">Mulai Belanja Sekarang</a>
            </div>
        @endif
    </div>
</body>
</html>
