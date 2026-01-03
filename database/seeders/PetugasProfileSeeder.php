<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PetugasProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // Ambil semua user role petugas
        $petugasUsers = User::where('role', 'petugas')->get();

        if ($petugasUsers->isEmpty()) {
            $this->command?->warn('Tidak ada user role petugas. Seeder petugas_profiles dilewati.');
            return;
        }

        foreach ($petugasUsers as $user) {
            DB::table('petugas_profiles')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    // default seperti punyamu
                    'file_path' => null, // foto nanti upload sendiri
                    'no_telp' => $user->no_telp ?? '08xxxxxxxxxx',
                    'alamat' => $user->alamat ?? 'alamat belum diisi',
                    'cabang_id' => 1, // pastikan CabangSeeder jalan dulu
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
