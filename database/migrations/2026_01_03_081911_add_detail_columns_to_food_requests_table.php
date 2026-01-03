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
        Schema::table('food_requests', function (Blueprint $table) {
            $table->unsignedSmallInteger('dependents')->nullable()->after('category');
            $table->string('job', 255)->nullable()->after('dependents');
            $table->unsignedInteger('income_monthly')->nullable()->after('job');
            $table->text('address_detail')->nullable()->after('income_monthly');
            $table->text('reason')->nullable()->after('address_detail');
            $table->string('main_needs', 255)->nullable()->after('reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('food_requests', function (Blueprint $table) {
            $table->dropColumn([
                'dependents',
                'job',
                'income_monthly',
                'address_detail',
                'reason',
                'main_needs',
            ]);
        });
    }
};
