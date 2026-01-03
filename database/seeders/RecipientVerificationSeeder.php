<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RecipientVerificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user2@donasipangan.test')->first();

        if (!$user) {
            // biar keliatan kalau user-nya ga ketemu
            $this->command?->warn("User penerima (user2@donasipangan.test) tidak ditemukan, skip seeder verifikasi.");
            return;
        }

        DB::table('recipient_verifications')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'nik'                => $user->nik,
                'full_name'          => $user->name,
                'kk_number'          => '4444555566667777', // contoh, boleh ganti
                'alamat'             => $user->alamat ?? 'Samarinda',
                'province'           => 'Kalimantan Timur',
                'city'               => 'Samarinda',
                'district'           => 'Samarinda Ulu',
                'postal_code'        => '75100',

                'verification_status'=> 'approved',
                'verified_at'        => now(),
                'rejected_reason'    => null,

                'created_at'         => now(),
                'updated_at'         => now(),
            ]
        );

        $this->command?->info("Seeder verifikasi untuk user_id={$user->id} berhasil (approved).");
    }
}
