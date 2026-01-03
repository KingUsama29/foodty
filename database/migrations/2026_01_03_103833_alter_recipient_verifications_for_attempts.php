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
        Schema::table('recipient_verifications', function (Blueprint $table) {
            // 1) tambahkan kolom attempt meta
            if (!Schema::hasColumn('recipient_verifications', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('verification_status');
            }
            if (!Schema::hasColumn('recipient_verifications', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('submitted_at');
            }
            if (!Schema::hasColumn('recipient_verifications', 'cooldown_until')) {
                $table->timestamp('cooldown_until')->nullable()->after('reviewed_at');
            }
            // 3) index biar query kenceng
            $table->index(['user_id', 'verification_status']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipient_verifications', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'verification_status']);
            $table->dropColumn(['submitted_at', 'reviewed_at', 'cooldown_until']);
            // jangan balikin unique biar aman (opsional)
        });
    }
};
