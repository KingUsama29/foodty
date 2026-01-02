<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('warehouse_stocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cabang_id')->constrained('cabangs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('warehouse_item_id')->constrained('warehouse_items')->cascadeOnUpdate()->restrictOnDelete();

            // batch
            $table->date('expired_at')->nullable(); // null utk non_pangan / pangan segar tertentu
            $table->string('batch_code')->nullable(); // opsional kalau mau isi (misal kode produksi)

            // jumlah stok
            $table->decimal('qty', 12, 2)->default(0);
            $table->string('unit', 20)->default('pcs');

            $table->timestamps();

            // biar satu cabang + barang + expired jadi unik (stoknya tinggal nambah/kurang)
            $table->unique(['cabang_id', 'warehouse_item_id', 'expired_at'], 'uniq_cabang_item_expired');

            $table->index(['cabang_id', 'warehouse_item_id']);
            $table->index(['expired_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse_stocks');
    }
};
