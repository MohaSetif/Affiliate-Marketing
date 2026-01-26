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
        Schema::table('leads', function (Blueprint $table) {
            $table->index('phone');
            $table->index('status');
        });

        Schema::table('commissions', function (Blueprint $table) {
            $table->index('affiliate_id');
            $table->index('status');
        });

        Schema::table('affiliate_requests', function (Blueprint $table) {
            $table->index(['merchant_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropIndex(['phone']);
            $table->dropIndex(['status']);
        });

        Schema::table('commissions', function (Blueprint $table) {
            $table->dropIndex(['affiliate_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('affiliate_requests', function (Blueprint $table) {
            $table->dropIndex(['merchant_id', 'status']);
        });
    }
};
