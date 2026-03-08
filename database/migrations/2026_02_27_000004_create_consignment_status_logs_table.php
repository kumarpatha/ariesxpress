<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consignment_status_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consignment_id');
            $table->enum('status', [
                'booking',
                'dispatched',
                'in_transit',
                'arrived_at_destination',
                'out_for_delivery',
                'delivered',
                'pod_updated',
            ]);
            $table->text('comment')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('consignment_id')
                  ->references('id')->on('consignments')->onDelete('cascade');
            $table->foreign('updated_by')
                  ->references('id')->on('admins')->onDelete('cascade');

            $table->index('consignment_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consignment_status_logs');
    }
};
