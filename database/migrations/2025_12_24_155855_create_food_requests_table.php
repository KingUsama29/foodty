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
        Schema::create('food_requests', function (Blueprint $table) {
            $table->id();

            // user yang login / yang mengajukan
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // pengajuan untuk siapa
            $table->enum('request_for', ['self', 'other'])->default('self');

            // kalau request_for = other
            $table->string('recipient_name')->nullable();
            $table->string('recipient_phone', 30)->nullable();
            $table->string('relationship')->nullable(); // tetangga/keluarga/RT/dll

            // kategori pengajuan
            $table->string('category');

            // data utama biar petugas bisa nilai pantas atau tidak
            $table->unsignedTinyInteger('dependents')->nullable(); // jumlah tanggungan
            $table->string('job')->nullable();
            $table->unsignedInteger('income_monthly')->nullable(); // penghasilan/bulan (angka)

            $table->text('address_detail'); // alamat lengkap + patokan
            $table->text('reason'); // alasan pengajuan (kenapa butuh)
            $table->string('main_needs'); // kebutuhan utama (beras/susu bayi/lauk/paket sembako)

            // deskripsi tambahan (opsional)
            $table->text('description')->nullable();

            // bukti pendukung (1 file)
            $table->string('file_path');

            // status & review
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->foreign('reviewed_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_requests');
    }
};
