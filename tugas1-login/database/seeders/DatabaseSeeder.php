<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::create([
            'username' => 'Salman',
            'password' => Hash::make('rahasia123'),
            'nama_lengkap' => 'Salman Mahesa Darmawan',
        ]);

        User::create([
            'username' => 'Kevin',
            'password' => Hash::make('password123'),
            'nama_lengkap' => 'Kevin Alfarisi Haikalt',
        ]);
        
    }
}
