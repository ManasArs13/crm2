<?php

use App\Models\ProductsCategory;
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
        Schema::create('products_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name", 190);
            $table->boolean('is_active')->default(0);
            $table->enum('type',[
                ProductsCategory::NOT_SELECTED,
                ProductsCategory::MATERIAL,
                ProductsCategory::PRODUCTS
            ]);
            $table->enum('building_material',[
                ProductsCategory::NOT_SELECTED,
                ProductsCategory::CONCRETE,
                ProductsCategory::BLOCK
            ]);
            $table->string('sort')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_categories');
    }
};
