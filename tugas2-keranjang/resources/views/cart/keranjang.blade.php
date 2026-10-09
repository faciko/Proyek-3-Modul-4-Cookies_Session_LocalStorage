<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <style>
        body { font-family: monospace, sans-serif; padding: 2rem; }
        .box { width: 520px; border: 2px solid #333; padding: 15px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .item-row { margin: 15px 0; }
        .item-detail { display: flex; justify-content: space-between; align-items: center; margin-top: 5px; }
        .qty-controls { display: flex; gap: 6px; align-items: center; }
        .qty-controls form { margin: 0; }
        .total-box { border-top: 2px solid #333; padding-top: 10px; display: flex; justify-content: space-between; font-weight: bold; margin-top: 15px; }
        .footer-action { margin-top: 20px; text-align: center; }
        button { cursor: pointer; padding: 2px 6px; }
        a { text-decoration: none; color: #000; }
    </style>
</head>
<body>
    <div class="box">
        <div class="header">
            <h3 style="margin: 0;">Keranjang belanja</h3>
            <span style="color: gray;">Tanpa login</span>
        </div>

        @if (empty($items))
            <p style="text-align: center; margin: 30px 0;">Keranjang kosong.</p>
        @else
            @foreach ($items as $item)
                <div class="item-row">
                    <div><strong>{{ $item['nama'] }}</strong></div>
                    <div class="item-detail">
                        <span>Rp {{ number_format($item['harga'], 0, ',', '.') }} x {{ $item['jumlah'] }} = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        <div class="qty-controls">
                            <form action="{{ route('cart.update', [$item['id'], 'minus']) }}" method="POST">
                                @csrf
                                <button type="submit">[-]</button>
                            </form>
                            <span>{{ $item['jumlah'] }}</span>
                            <form action="{{ route('cart.update', [$item['id'], 'plus']) }}" method="POST">
                                @csrf
                                <button type="submit">[+]</button>
                            </form>
                            <form action="{{ route('cart.hapus', $item['id']) }}" method="POST">
                                @csrf
                                <button type="submit">[hps]</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="total-box">
                <span>Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <div class="footer-action">
                <form action="{{ route('cart.kosongkan') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">[ Kosongkan keranjang ]</button>
                </form>
            </div>
        @endif

        <div style="margin-top: 20px; border-top: 1px dashed #ccc; padding-top: 10px;">
            <a href="{{ route('cart.index') }}">&laquo; Kembali belanja</a>
        </div>
    </div>
</body>
</html>