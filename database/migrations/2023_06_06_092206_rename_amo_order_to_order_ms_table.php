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
        Schema::table('order_ms', function (Blueprint $table) {
            $table->renameColumn( 'amo_order', 'order_amo_id');
            $table->renameColumn( 'amo_order_link', 'order_amo_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_ms', function (Blueprint $table) {
            $table->renameColumn( 'order_amo_id', 'amo_order' );
            $table->renameColumn( 'order_amo_link','amo_order_link');
        });
    }
};
