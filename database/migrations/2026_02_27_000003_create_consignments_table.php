<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('consignment_note_number', 30)->unique();
            $table->date('booking_date');
            $table->string('consigner_name');
            $table->text('consigner_address');
            $table->string('consigner_gst_number', 30)->nullable();
            $table->string('consignee_name');
            $table->text('consignee_address');
            $table->string('consignee_gst_number', 30)->nullable();
            $table->string('phone_number', 20);
            $table->text('item_description');
            $table->string('origin');
            $table->string('destination');
            $table->unsignedBigInteger('origin_branch_id')->nullable();
            $table->unsignedBigInteger('destination_branch_id')->nullable();
            $table->unsignedInteger('no_of_boxes')->default(1);
            $table->decimal('actual_weight', 10, 2)->default(0.00);
            $table->decimal('chargeable_weight', 10, 2)->default(0.00);
            $table->enum('service_mode', ['road', 'air', 'rail', 'express'])->default('road');
            $table->decimal('total_amount', 12, 2)->default(0.00);
            $table->decimal('grand_total', 12, 2)->default(0.00);
            $table->text('final_remark')->nullable();
            $table->enum('delivery_status', [
                'booking',
                'dispatched',
                'in_transit',
                'arrived_at_destination',
                'out_for_delivery',
                'delivered',
                'pod_updated',
            ])->default('booking');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('origin_branch_id')
                  ->references('id')->on('branches')->onDelete('set null');
            $table->foreign('destination_branch_id')
                  ->references('id')->on('branches')->onDelete('set null');
            $table->foreign('created_by')
                  ->references('id')->on('admins')->onDelete('set null');

            $table->index('phone_number');
            $table->index('delivery_status');
            $table->index('booking_date');
            $table->index('origin_branch_id');
            $table->index('destination_branch_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consignments');
    }
};
