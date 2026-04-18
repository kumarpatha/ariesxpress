<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->text('consigner_address')->nullable()->change();
            $table->text('consignee_address')->nullable()->change();
            $table->string('phone_number', 20)->nullable()->change();
            $table->decimal('chargeable_weight', 10, 2)->nullable()->default(0.00)->change();
            $table->decimal('total_amount', 12, 2)->nullable()->default(0.00)->change();
            $table->decimal('grand_total', 12, 2)->nullable()->default(0.00)->change();
        });

        DB::table('consignments')->update([
            'tracking_number' => DB::raw('consignment_note_number'),
        ]);
    }

    public function down(): void
    {
        DB::table('consignments')->update([
            'phone_number' => DB::raw("COALESCE(phone_number, '')"),
            'consignee_address' => DB::raw("COALESCE(consignee_address, '')"),
            'chargeable_weight' => DB::raw('COALESCE(chargeable_weight, 0.00)'),
            'total_amount' => DB::raw('COALESCE(total_amount, 0.00)'),
            'grand_total' => DB::raw('COALESCE(grand_total, 0.00)'),
            'tracking_number' => DB::raw('consignment_note_number'),
        ]);

        Schema::table('consignments', function (Blueprint $table) {
            $table->text('consignee_address')->nullable(false)->change();
            $table->string('phone_number', 20)->nullable(false)->change();
            $table->decimal('chargeable_weight', 10, 2)->nullable(false)->default(0.00)->change();
            $table->decimal('total_amount', 12, 2)->nullable(false)->default(0.00)->change();
            $table->decimal('grand_total', 12, 2)->nullable(false)->default(0.00)->change();
        });
    }
};