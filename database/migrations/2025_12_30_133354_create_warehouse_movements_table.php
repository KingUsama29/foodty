<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('warehouse_movements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cabang_id')->constrained('cabangs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('warehouse_item_id')->constrained('warehouse_items')->cascadeOnUpdate()->restrictOnDelete();

            $table->enum('type', ['in', 'out', 'adjustment'])->index();

            // referensi sumber (biar nyambung ke donasi / penyaluran)
            $table->string('source_type')->nullable(); // contoh: donation, distribution
            $table->unsignedBigInteger('source_id')->nullable(); // id dari tabel sumber

            // batch
            $table->date('expired_at')->nullable();

            // jumlah mutasi
            $table->decimal('qty', 12, 2);
            $table->string('unit', 20)->default('pcs');

            // siapa yang input
            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();

            $table->text('note')->nullable();
            $table->timestamp('moved_at')->useCurrent();

            $table->timestamps();

            $table->index(['source_type', 'source_id']);
            $table->index(['cabang_id', 'warehouse_item_id', 'expired_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse_movements');
    }
};
