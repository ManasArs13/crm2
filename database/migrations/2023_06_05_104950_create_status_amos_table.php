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
        Schema::create('status_amos', function (Blueprint $table) {
            $table->id();
            $table->string("name",190);
            $table->foreignUuid("status_ms")->nullable()->index()->constrained("status_ms");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_amos');
    }
};
