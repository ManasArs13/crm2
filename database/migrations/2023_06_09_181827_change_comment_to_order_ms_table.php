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
        Schema::table('order_ms', function (Blueprint $table) {
            $table->string("comment")->nullable()->default(NULL)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_ms', function (Blueprint $table) {
            $table->string("comment")->nullable()->change();
        });
    }
};
