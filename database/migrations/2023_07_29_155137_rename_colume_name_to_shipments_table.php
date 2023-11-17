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
        Schema::table('shipments', function (Blueprint $table) {
            $table->renameColumn('path_to_service', 'service_link');
            $table->renameColumn('counterparty', 'counterparty_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->renameColumn('service_link', 'path_to_service');
            $table->renameColumn('counterparty_link', 'counterparty');

        });
    }
};
