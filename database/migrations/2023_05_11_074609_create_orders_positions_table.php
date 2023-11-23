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
        Schema::create('orders_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid("product_id")->nullable()->index()->constrained("products");
            $table->foreignId("order_id")->index()->constrained("orders");
            $table->integer("quantity")->unsigned()->default(0);
            $table->integer("sum")->unsigned()->default(0);
            $table->unsignedDecimal("weight", 8, 1)->unsigned()->nullable();
            $table->integer("price")->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_positions');
    }
};
