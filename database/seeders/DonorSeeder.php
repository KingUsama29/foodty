<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('donors')->updateOrInsert(
            ['id' => 2],
            [
                'type' => 'individu',
                'name' => 'Usama Fadli',
                'phone' => '083867872230',
                'email' => 'usamafadli87@gmail.com',
                'address' => 'jombor jambon',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
