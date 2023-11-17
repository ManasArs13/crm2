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
        Schema::create('shipping_prices', function (Blueprint $table) {
            $table->id();
            $table->integer("distance")->unsigned();
            $table->decimal("tonnage", 8, 1)->unsigned();
            $table->integer("price")->unsigned();
            $table->foreignUuid("vehicle_type_id")->index()->constrained("vehicle_types");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_prices');
    }
};
