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
        Schema::create('order_ms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name",190)->nullable()->change();
            $table->foreignUuid("status_ms_id")->nullable()->index()->constrained("status_ms");
            $table->foreignUuid("contact_ms_id")->nullable()->index()->constrained("contact_ms");
            $table->dateTime("date_plan")->nullable();
            $table->dateTime("date_fact")->nullable();
            $table->dateTime("date_moment")->nullable();
            $table->decimal("sum", 10, 1)->default(0.0);
            $table->decimal("payed_sum", 10, 1)->default(0.0);
            $table->decimal("shipped_sum", 10,1)->default(0.0);
            $table->decimal("reserved_sum", 10,1)->default(0.0);
            $table->decimal("weight", 10,1)->default(0.0);
            $table->integer("count_pallets")->default(0);
            $table->integer("norm1_price")->default(0.0);
            $table->integer("norm2_price")->default(0.0);
            $table->foreignUuid("transport_id")->nullable()->index()->constrained("transports");
            $table->foreignUuid("delivery_id")->nullable()->index()->constrained("deliveries");
            $table->foreignUuid("vehicle_type_id")->nullable()->index()->constrained("vehicle_types");
            $table->integer("delivery_price")->default(0.0);
            $table->boolean("is_demand")->default(0);
            $table->boolean("is_made")->default(0);
            $table->boolean("status_shipped")->default(0);
            $table->decimal("debt", 10,1)->default(0.0);
            $table->string("order_amo_link")->nullable();
            $table->string("order_amo_id")->nullable();
            $table->string("comment")->nullable()->default(NULL)->change();
            $table->integer('delivery_price_norm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_ms');
    }
};
