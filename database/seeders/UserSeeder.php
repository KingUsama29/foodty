<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // ADMIN
        User::create([
            'name' => 'Admin Utama',
            'nik' => '1111222233334444',
            'email' => 'admin@donasipangan.test',
            'no_telp' => '081111111111',
            'alamat' => 'Kantor Pusat',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // PETUGAS
        User::create([
            'name' => 'Petugas Lapangan',
            'nik' => '2222333344445555',
            'email' => 'petugas@donasipangan.test',
            'no_telp' => '082222222222',
            'alamat' => 'Gudang Distribusi',
            'role' => 'petugas',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // USER BIASA
        User::create([
            'name' => 'User Donatur',
            'nik' => '3333444455556666',
            'email' => 'user1@donasipangan.test',
            'no_telp' => '083333333333',
            'alamat' => 'Balikpapan',
            'role' => 'donatur',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'User Penerima',
            'nik' => '4444555566667777',
            'email' => 'user2@donasipangan.test',
            'no_telp' => '084444444444',
            'alamat' => 'Samarinda',
            'role' => 'penerima',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
    }
}
