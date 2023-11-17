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
         //   $table->string('delivery_city', 255);
            $table->foreignUuid('transport_id')->nullable()->references('id')->on('transports');
            $table->foreignUuid('vehicle_type_id')->nullable()->references('id')->on('vehicle_types');
            $table->integer('delivery_price');
            $table->integer('delivery_price_norm');
            $table->integer('delivery_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_ms', function (Blueprint $table) {
            //
        });
    }
};
