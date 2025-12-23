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
        Schema::create('recipient_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('kk_number')->unique();
            $table->text('alamat');
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('postal_code');
            $table->string('verification_status')->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->text('rejected_reason')->nullable();
            $table->timestamps();

            $table->unique('user_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipient_verifications');
    }
};
