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
        Schema::table('contact_amos', function (Blueprint $table) {
            $table->renameColumn('contact_ms', 'contact_ms_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_amos', function (Blueprint $table) {
            $table->renameColumn('contact_ms_id', 'contact_ms');
        });
    }
};
