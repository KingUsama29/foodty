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
        Schema::create('recipient_verification_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipient_verification_id');
            $table->foreign('recipient_verification_id', 'rvd_rv_id_fk')->references('id')->on('recipient_verifications')->cascadeOnDelete();
            $table->string('type');
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();
            
            $table->unique(['recipient_verification_id', 'type'], 'rvd_rv_type_unique');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipient_verification_documents');
    }
};
