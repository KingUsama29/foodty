<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('donor_id')->constrained('donors')->cascadeOnUpdate()->restrictOnDelete();

            // pos cabang penerima
            $table->foreignId('cabang_id')->constrained('cabangs')->cascadeOnUpdate()->restrictOnDelete();

            // petugas penerima (user yang login)
            $table->foreignId('received_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();

            // tanggal donasi (boleh manual / auto)
            $table->dateTime('donated_at')->useCurrent();

            // status opsional (kalau mau ada validasi/penyortiran)
            $table->enum('status', ['draft', 'accepted', 'rejected'])->default('accepted');

            // catatan umum
            $table->text('note')->nullable();

            // bukti foto/berkas (opsional)
            $table->string('evidence_path')->nullable();

            $table->timestamps();

            $table->index(['cabang_id', 'donated_at']);
            $table->index(['received_by', 'donated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
