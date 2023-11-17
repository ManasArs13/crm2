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
        Schema::create('contact_ms_contact_amos', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('contact_ms_id')->references('id')->on('contact_ms');
            $table->foreignId('contact_amo_id')->references('id')->on('contact_amos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_ms_contact_amos');
    }
};
