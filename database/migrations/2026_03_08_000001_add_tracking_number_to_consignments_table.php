<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consignments', function (Blueprint $table) {
            // Auto-generated tracking number used for public tracking search
            $table->string('tracking_number', 30)->unique()->nullable()->after('consignment_note_number');
            $table->index('tracking_number');
        });
    }

    public function down(): void
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->dropIndex(['tracking_number']);
            $table->dropUnique(['tracking_number']);
            $table->dropColumn('tracking_number');
        });
    }
};
