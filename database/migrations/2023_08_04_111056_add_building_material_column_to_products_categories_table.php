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
        Schema::table('products_categories', function (Blueprint $table) {
            $table->enum('building_material',[
                ProductsCategory::NOT_SELECTED,
                ProductsCategory::CONCRETE,
                ProductsCategory::BLOCK
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_categories', function (Blueprint $table) {
            $table->dropColumn('building_material');
        });
    }
};
