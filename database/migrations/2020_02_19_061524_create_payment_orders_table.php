<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('aa_id');
            $table->string('payment_order_id')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('po_date');
            $table->string('verification_date')->nullable();
            $table->string('payment_date')->nullable();
            $table->boolean('verified')->default(0);
            $table->boolean('payment_done')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_orders');
    }
}
