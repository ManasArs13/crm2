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
        Schema::create('supplies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name",190)->nullable();
            $table->timestamps();
            $table->foreignUuid("contact_ms_id")->nullable()->index()->constrained("contact_ms");
            $table->dateTime("moment")->nullable();
            $table->string('description', 500)->nullable();
            $table->decimal("sum", 10, 2)->default(0.0);
            $table->string("incoming_number", 190)->nullable();
            $table->dateTime("incoming_date")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
