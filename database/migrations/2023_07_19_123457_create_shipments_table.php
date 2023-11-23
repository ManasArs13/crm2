<?php

use App\Models\Shipments;
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
        Schema::create('shipments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name',190)->nullable();
            $table->string('description')->nullable();
            $table->string('shipment_address')->nullable();
            $table->foreignUuid('order_id')->nullable()->references('id')->on('order_ms')->onDelete('cascade');
            $table->string('counterparty_link')->nullable();
            $table->string('service_link')->nullable();
            $table->integer('paid_sum')->default(0.00);
            $table->integer('suma');
            $table->enum('status',[
                Shipments::APPOINTED,
                Shipments::NOT_PAID,
                Shipments::PAID
            ])->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->foreignUuid("delivery_id")->nullable()->index()->constrained("deliveries");
            $table->integer('delivery_price')->nullable();
            $table->integer('delivery_price_norm')->nullable();
            $table->integer('delivery_fee')->nullable();
            $table->foreignUuid('transport_id')->nullable()->references('id')->on('transports');
            $table->foreignUuid('vehicle_type_id')->nullable()->references('id')->on('vehicle_types');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
