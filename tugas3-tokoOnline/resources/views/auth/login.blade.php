<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Toko Online</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 90vh; background: #f8f9fa; }
        .card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 320px; }
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 5px; font-size: 14px; }
        .input-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: red; font-size: 13px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h3>Login Toko Online</h3>
        @if ($errors->has('login'))
            <div class="error">{{ $errors->first('login') }}</div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: budi" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Contoh: password123" required>
            </div>
            <button type="submit">Masuk</button>
        </form>
        <p style="font-size: 13px; margin-top: 15px;"><a href="{{ route('shop.index') }}">&laquo; Kembali ke Katalog</a></p>
    </div>
</body>
</html>