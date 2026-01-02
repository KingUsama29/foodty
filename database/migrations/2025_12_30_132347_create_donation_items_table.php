<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donation_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('donation_id')->constrained('donations')->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('item_name'); // contoh: Beras Ramos, Mie Instan, Minyak Goreng
            $table->enum('category', [
                'pangan_kemasan',
                'pangan_segar',
                'non_pangan'
            ])->default('pangan_kemasan');

            // jumlah & satuan
            $table->decimal('qty', 12, 2)->default(1);
            $table->string('unit', 20)->default('pcs'); // pcs, kg, liter, dus, pack

            // kondisi barang
            $table->enum('condition', ['baik', 'rusak_ringan', 'tidak_layak'])->default('baik');

            /**
             * expired_at:
             * - WAJIB untuk pangan_kemasan (secara bisnis), tapi DB kita buat nullable biar fleksibel.
             * - untuk non_pangan biasanya null
             * - untuk pangan_segar bisa isi opsional atau pakai best_before_days
             */
            $table->date('expired_at')->nullable();

            // untuk pangan segar (opsional): estimasi layak konsumsi (hari)
            $table->unsignedSmallInteger('best_before_days')->nullable();

            // catatan per item
            $table->text('note')->nullable();

            $table->timestamps();

            $table->index(['category', 'expired_at']);
            $table->index(['condition']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_items');
    }
};
