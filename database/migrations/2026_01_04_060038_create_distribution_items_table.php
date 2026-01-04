<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('distribution_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('distribution_id')->constrained('distributions')->cascadeOnDelete();
            $table->foreignId('warehouse_item_id')->constrained('warehouse_items')->restrictOnDelete();

            $table->date('expired_at')->nullable(); // batch
            $table->decimal('qty', 12, 2);
            $table->string('unit', 20)->default('pcs');
            $table->text('note')->nullable();

            $table->timestamps();

            $table->index(['distribution_id']);
            $table->index(['warehouse_item_id', 'expired_at']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_items');
    }
};
