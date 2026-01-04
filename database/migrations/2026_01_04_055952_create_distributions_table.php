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
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('food_request_id')->constrained('food_requests')->cascadeOnDelete();
            $table->foreignId('cabang_id')->constrained('cabangs')->cascadeOnDelete();

            $table->foreignId('distributed_by')->constrained('users')->restrictOnDelete();

            $table->timestamp('distributed_at')->nullable();

            $table->enum('status', ['draft', 'completed', 'canceled'])->default('draft');
            $table->text('note')->nullable();

            // snapshot penerima (biar history aman walau data user berubah)
            $table->string('recipient_name')->nullable();
            $table->string('recipient_phone', 30)->nullable();
            $table->text('recipient_address')->nullable();

            $table->timestamps();

            $table->index(['cabang_id', 'distributed_at']);
            $table->index(['food_request_id', 'status']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};
