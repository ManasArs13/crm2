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
        Schema::table('order_ms_order_amos', function (Blueprint $table) {
            $table->dropColumn('budget_amo');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_ms_order_amos', function (Blueprint $table) {
            $table->unsignedInteger('budget_amo')->nullable();
        });
    }
};
