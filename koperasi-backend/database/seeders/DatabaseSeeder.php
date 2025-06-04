<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@koperasi.com',
            'password' => bcrypt('password123'),
            'nim' => '000000',
            'phone' => '08123456789',
            'role' => 'admin',
        ]);

        // Sample anggota
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'nim' => '123456',
            'phone' => '08123456780',
            'role' => 'user',
        ]);

        Anggota::create([
            'user_id' => $user->id,
            'tanggal_daftar' => now(),
            'status_anggota' => 'aktif',
            'alamat' => 'Jl. Contoh No. 123'
        ]);
    }
}
