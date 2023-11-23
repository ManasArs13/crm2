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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id');
            $table->string("name", 190);
            $table->string("phone",12)->nullable();
            $table->foreignUuid("delivery_id")->nullable()->index()->constrained("deliveries");
            $table->foreignUuid("vehicle_type_id")->nullable()->index()->constrained("vehicle_types");

            $table->integer("fence_length")->unsigned()->default(3);
            $table->integer("number_of_columns")->unsigned()->default(2);
            $table->foreignId("fence_type_id")->nullable()->index()->constrained("fence_types");
            $table->foreignId("wall_id")->nullable()->index()->constrained("walls");
            $table->foreignId("column_id")->nullable()->index()->constrained("columns");

            $table->unsignedDecimal("weight", 8, 1)->unsigned()->nullable();
            $table->integer("sum")->unsigned()->nullable();

            $table->integer("delivery_price")->unsigned()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
