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
        Schema::create('order_ms_order_amo', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('order_ms_id')->references('id')->on('order_ms')->onDelete('cascade');
            $table->foreignId('order_amo_id')->nullable()->references('id')->on('order_amos')->onDelete('cascade');
            $table->boolean('is_manual')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_ms_order_amo');
    }
};
