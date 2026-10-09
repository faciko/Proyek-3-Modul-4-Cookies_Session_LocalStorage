<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $produk = [
            ['nama' => 'Buku Tulis', 'harga' => 5000, 'stok' => 20],
            ['nama' => 'Pulpen',     'harga' => 3000, 'stok' => 15],
            ['nama' => 'Penggaris',  'harga' => 4000, 'stok' => 10],
            ['nama' => 'Pensil 2B',  'harga' => 2500, 'stok' => 25],
            ['nama' => 'Penghapus',  'harga' => 1500, 'stok' => 30],
        ];

        foreach ($produk as $item) {
            Barang::create($item);
        }
    }
}