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
        Schema::create('tech_charts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('cost')->nullable();
            $table->foreignUuid("product_id")->constrained("products");
            $table->integer("quantity")->unsigned()->default(0);
            $table->enum('status',[
                "Техкарта Бетон", "Техкарта Пресс"
            ])->nullable();
            $table->boolean('archived')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tech_charts');
    }
};
