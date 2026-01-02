<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('warehouse_items', function (Blueprint $table) {
            $table->id();

            $table->string('name'); // Beras, Mie Instan, Minyak Goreng, dll
            $table->enum('category', ['pangan_kemasan', 'pangan_segar', 'non_pangan'])->default('pangan_kemasan');

            // satuan default (buat konsisten)
            $table->string('default_unit', 20)->default('pcs');

            $table->boolean('has_expired_date')->default(true); // pangan_kemasan: true, non_pangan: false (bisa kamu atur)
            $table->timestamps();

            $table->unique(['name', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse_items');
    }
};
