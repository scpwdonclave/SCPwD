<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentOrderAgencyBatchMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_order_agency_batch_maps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('po_id');
            $table->unsignedBigInteger('aa_batch_id');
            $table->unsignedBigInteger('total_candidate');
            $table->unsignedBigInteger('amount');
            $table->boolean('po_on')->comment='1: assigned, 0: appeared';

            $table->timestamps();

            $table->foreign('po_id')
            ->references('id')
            ->on('payment_orders')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_order_agency_batch_maps');
    }
}
