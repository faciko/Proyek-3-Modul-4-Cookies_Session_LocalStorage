<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Toko Online</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background: #fafafa; }
        .navbar { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .nav-links { display: flex; gap: 15px; align-items: center; }
        .nav-links a { text-decoration: none; color: #007bff; font-weight: bold; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; }
        .product-card { background: white; border: 1px solid #e1e4e8; border-radius: 8px; padding: 15px; display: flex; flex-direction: column; justify-content: space-between; }
        .img-placeholder { height: 120px; background: #e9ecef; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #6c757d; border-radius: 6px; margin-bottom: 12px; }
        .price { color: #e65100; font-weight: bold; font-size: 16px; margin: 8px 0; }
        .stock { font-size: 13px; color: #555; }
        .btn-add { background: #28a745; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer; width: 100%; margin-top: 10px; }
        .btn-disabled { background: #6c757d; color: white; border: none; padding: 8px 12px; border-radius: 4px; width: 100%; margin-top: 10px; cursor: not-allowed; }
        .alert { padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .badge-out { background: #dc3545; color: white; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; display: inline-block; }
        .product-card.out-of-stock { border-color: #f5c2c7; background: #fffcfc; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Toko Online Mandiri</h2>
        <div class="nav-links">
            @auth
                <span>Halo, <strong>{{ Auth::user()->nama_lengkap }}</strong></span>
                <a href="{{ route('shop.cart') }}">Keranjang ({{ $totalItems }})</a>
                <a href="{{ route('orders.index') }}">Riwayat Pesanan</a>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: bold;">Logout</button>
                </form>
            @else
                <span style="color: gray;">Tamu (Belum Login)</span>
                <a href="{{ route('login') }}" style="background: #007bff; color: white; padding: 6px 12px; border-radius: 4px; font-weight: bold;">Login untuk Belanja</a>
            @endauth
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <h3>Daftar Barang Tersedia</h3>
    <div class="grid">
        @foreach ($products as $p)
            <div class="product-card {{ $p->stok <= 0 ? 'out-of-stock' : '' }}">
                <div>
                    <div class="img-placeholder" style="position: relative;">
                        [Gambar: {{ $p->gambar ?? 'produk.jpg' }}]
                        @if ($p->stok <= 0)
                            <div style="position: absolute; top: 8px; right: 8px;">
                                <span class="badge-out">HABIS</span>
                            </div>
                        @endif
                    </div>
                    <strong style="font-size: 15px;">{{ $p->nama_barang }}</strong>
                    <div class="price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                    
                    <div class="stock">
                        @if ($p->stok > 0)
                            Stok: <strong>{{ $p->stok }}</strong>
                        @else
                            <span style="color: #dc3545; font-weight: bold;">Stok: 0 (Habis)</span>
                            <span class="badge-out" style="margin-left: 5px;">Stok Habis</span>
                        @endif
                    </div>
                    <p style="font-size: 12px; color: #666; margin: 6px 0;">{{ $p->deskripsi }}</p>
                </div>

                @if ($p->stok <= 0)
                    {{-- Barang stok 0 tidak dapat dibeli oleh siapapun (login maupun belum login) --}}
                    <button class="btn-disabled" disabled title="Barang tidak dapat dibeli karena stok habis">Stok Habis (Tidak Dapat Dibeli)</button>
                @else
                    @auth
                        <form action="{{ route('cart.add', $p->id_barang) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-add">+ Masukkan ke Keranjang</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" style="display: block; text-align: center; text-decoration: none; background: #ffc107; color: #212529; padding: 8px 12px; border-radius: 4px; margin-top: 10px; font-size: 13px; font-weight: bold;">Login untuk Membeli</a>
                    @endauth
                @endif
            </div>
        @endforeach
    </div>
</body>
</html>