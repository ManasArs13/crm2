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
        Schema::create('order_position_ms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid("product_id")->nullable()->index()->constrained("products");
            $table->foreignUuid("order_ms_id")->index()->constrained("order_ms");

            $table->integer("quantity")->unsigned()->default(0);
            $table->integer("shipped")->unsigned()->default(0);
            $table->integer("reserve")->unsigned()->default(0);
            $table->integer("price")->unsigned()->default(0);

            $table->integer("count_pallets")->unsigned()->default(0)->nullable();
            $table->unsignedDecimal("weight_kg", 8, 1)->unsigned()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_position_ms');
    }
};
