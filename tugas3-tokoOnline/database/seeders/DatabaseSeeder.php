<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed User
        User::create([
            'id_user' => 'USR001',
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 1, Jakarta',
        ]);

        User::create([
            'id_user' => 'USR002',
            'nama_lengkap' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'username' => 'budi',
            'password' => Hash::make('password123'),
            'no_hp' => '089876543210',
            'alamat' => 'Jl. Kebon Jeruk No. 15, Bandung',
        ]);

        // 2. Seed Minimal 10 Produk (sesuai spesifikasi Tugas 3)
        $items = [
            ['id_barang' => 'BRG001', 'nama_barang' => 'Buku Tulis Sinar Dunia', 'deskripsi' => 'Buku isi 38 lembar bergaris rapi.', 'harga' => 5000, 'stok' => 25, 'gambar' => 'buku.jpg'],
            ['id_barang' => 'BRG002', 'nama_barang' => 'Pulpen Gel Hitam 0.5', 'deskripsi' => 'Tinta hitam pekat cepat kering.', 'harga' => 3500, 'stok' => 40, 'gambar' => 'pulpen.jpg'],
            ['id_barang' => 'BRG003', 'nama_barang' => 'Penggaris Besi 30cm', 'deskripsi' => 'Penggaris baja anti patah dan presisi.', 'harga' => 7000, 'stok' => 15, 'gambar' => 'penggaris.jpg'],
            ['id_barang' => 'BRG004', 'nama_barang' => 'Pensil 2B Faber-Castell', 'deskripsi' => 'Pensil standar ujian komputer.', 'harga' => 4000, 'stok' => 30, 'gambar' => 'pensil.jpg'],
            ['id_barang' => 'BRG005', 'nama_barang' => 'Penghapus Karet Joyko', 'deskripsi' => 'Menghapus bersih tanpa merusak kertas.', 'harga' => 2000, 'stok' => 50, 'gambar' => 'penghapus.jpg'],
            ['id_barang' => 'BRG006', 'nama_barang' => 'Tipe-X Kertas (Correction Tape)', 'deskripsi' => 'Pita koreksi praktis panjang 12m.', 'harga' => 8500, 'stok' => 20, 'gambar' => 'tipex.jpg'],
            ['id_barang' => 'BRG007', 'nama_barang' => 'Spidol Whiteboard Marker Hitam', 'deskripsi' => 'Spidol papan tulis mudah dihapus.', 'harga' => 9000, 'stok' => 18, 'gambar' => 'spidol.jpg'],
            ['id_barang' => 'BRG008', 'nama_barang' => 'Stapler Mini + Isi No.10', 'deskripsi' => 'Stapler praktis muat di tempat pensil.', 'harga' => 12000, 'stok' => 10, 'gambar' => 'stapler.jpg'],
            ['id_barang' => 'BRG009', 'nama_barang' => 'Sticky Notes Warna-Warni', 'deskripsi' => 'Memo tempel berperekat kuat 100 lembar.', 'harga' => 6000, 'stok' => 22, 'gambar' => 'stickynotes.jpg'],
            ['id_barang' => 'BRG010', 'nama_barang' => 'Tempat Pensil Resleting', 'deskripsi' => 'Kotak pensil kain kanvas kapasitas besar.', 'harga' => 15000, 'stok' => 0, 'gambar' => 'kotakpensil.jpg'], // Stok 0 untuk pengujian limit stok
        ];

        foreach ($items as $item) {
            Product::create($item);
        }
    }
}
