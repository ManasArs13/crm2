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
        Schema::table('order_amos', function (Blueprint $table) {
            $table->renameColumn( 'status_amo', 'status_amo_id');
            $table->renameColumn( 'order_ms', 'order_ms_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_amos', function (Blueprint $table) {
            $table->renameColumn('status_amo_id', 'status_amo');
            $table->renameColumn('order_ms_id', 'order_ms');
        });
    }
};
