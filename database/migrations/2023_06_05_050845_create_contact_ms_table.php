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
        Schema::create('contact_ms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name",190);
            $table->string("phone", 56)->nullable();
            $table->string("phone_norm", 56)->nullable();
            $table->string("email", 100)->nullable();
            $table->string("contact_amo_id")->nullable();
            $table->string("contact_amo_link")->nullable();
            $table->decimal("balance",10,1)->default(0.0)->nullable();
            $table->boolean("is_exist")->default(0);
            $table->boolean("is_dublash")->default(0);
            $table->index('contact_amo_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_ms');
    }
};
