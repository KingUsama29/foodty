<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();

            // tipe donatur: individu / komunitas / instansi
            $table->enum('type', ['individu', 'komunitas', 'instansi'])->default('individu');

            $table->string('name'); // nama donatur / nama komunitas / nama instansi
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();

            // opsional, biar rapi kalau mau simpan alamat
            $table->text('address')->nullable();

            $table->timestamps();

            // optional index
            $table->index(['type', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
