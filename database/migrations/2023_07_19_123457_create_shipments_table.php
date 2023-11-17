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
            $table->string('counterparty');
            $table->string('path_to_service')->nullable();
            $table->integer('paid_sum')->default(0.00);
            $table->integer('suma');
            $table->enum('status',[
                Shipments::APPOINTED,
                Shipments::NOT_PAID,
                Shipments::PAID
            ])->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
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
