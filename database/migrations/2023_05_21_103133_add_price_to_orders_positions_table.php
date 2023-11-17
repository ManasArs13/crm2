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
        Schema::table('orders_positions', function (Blueprint $table) {
            //$table->foreignId("category_id")->nullable()->index()->constrained("products_categories");
            $table->integer("price")->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders_positions', function (Blueprint $table) {
           // $table->dropConstrainedForeignId("category_id")->dropColumn('category_id');
            $table->dropColumn("price");
        });
    }
};
