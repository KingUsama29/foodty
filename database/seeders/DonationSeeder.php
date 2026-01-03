<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // cari petugas untuk received_by
        $petugas = User::where('role', 'petugas')->orderBy('id')->first();

        if (!$petugas) {
            $this->command?->warn("Tidak ada user role petugas. DonationSeeder dilewati.");
            return;
        }

        // Donasi ID 2 (1 item beras)
        DB::table('donations')->updateOrInsert(
            ['id' => 2],
            [
                'donor_id' => 2,
                'cabang_id' => 1,
                'received_by' => $petugas->id,
                'donated_at' => '2026-01-03 12:41:00',
                'status' => 'accepted',
                'note' => null,
                'evidence_path' => null,
                'created_at' => '2026-01-03 05:48:53',
                'updated_at' => '2026-01-03 05:48:53',
            ]
        );

        DB::table('donation_items')->updateOrInsert(
            ['id' => 1],
            [
                'donation_id' => 2,
                'item_name' => 'beras',
                'category' => 'pangan_kemasan',
                'qty' => 1.00,
                'unit' => 'pcs',
                'condition' => 'baik',
                'expired_at' => '2026-01-03',
                'best_before_days' => null,
                'note' => null,
                'created_at' => '2026-01-03 05:48:54',
                'updated_at' => '2026-01-03 05:48:54',
            ]
        );

        // Donasi ID 3 (2 item: beras + gula)
        DB::table('donations')->updateOrInsert(
            ['id' => 3],
            [
                'donor_id' => 2,
                'cabang_id' => 1,
                'received_by' => $petugas->id,
                'donated_at' => '2026-01-03 12:53:00',
                'status' => 'accepted',
                'note' => 'Antarkan',
                'evidence_path' => null, // kalau mau isi: 'donations/xxxx.png'
                'created_at' => '2026-01-03 05:54:31',
                'updated_at' => '2026-01-03 05:54:31',
            ]
        );

        DB::table('donation_items')->updateOrInsert(
            ['id' => 2],
            [
                'donation_id' => 3,
                'item_name' => 'beras',
                'category' => 'pangan_kemasan',
                'qty' => 1.00,
                'unit' => 'Kg',
                'condition' => 'baik',
                'expired_at' => '2026-01-03',
                'best_before_days' => null,
                'note' => null,
                'created_at' => '2026-01-03 05:54:31',
                'updated_at' => '2026-01-03 05:54:31',
            ]
        );

        DB::table('donation_items')->updateOrInsert(
            ['id' => 3],
            [
                'donation_id' => 3,
                'item_name' => 'Gula',
                'category' => 'pangan_kemasan',
                'qty' => 5.00,
                'unit' => 'Kg',
                'condition' => 'baik',
                'expired_at' => '2026-01-31',
                'best_before_days' => null,
                'note' => null,
                'created_at' => '2026-01-03 05:54:31',
                'updated_at' => '2026-01-03 05:54:31',
            ]
        );
    }
}
