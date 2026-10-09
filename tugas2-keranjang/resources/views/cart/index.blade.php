<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Barang - Toko Alat Tulis</title>
    <style>
        body { font-family: monospace, sans-serif; padding: 2rem; }
        .box { width: 520px; border: 2px solid #333; padding: 15px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header a { text-decoration: none; background: #e0e0e0; padding: 4px 8px; border: 1px solid #333; color: #000; }
        .list-item { display: flex; justify-content: space-between; align-items: center; margin: 12px 0; }
        button { cursor: pointer; padding: 3px 8px; }
    </style>
</head>
<body>
    <div class="box">
        <div class="header">
            <h3 style="margin: 0;">Toko Alat Tulis</h3>
            <a href="{{ route('cart.keranjang') }}">[ Keranjang ({{ $totalItems }}) ]</a>
        </div>
        <h4>Daftar barang</h4>
        @foreach ($barang as $b)
            <div class="list-item">
                <span>[img] {{ $b->nama }}</span>
                <span>Rp {{ number_format($b->harga, 0, ',', '.') }}</span>
                <form action="{{ route('cart.tambah', $b->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit">[Masukkan ke krj]</button>
                </form>
            </div>
        @endforeach
    </div>
</body>
</html>