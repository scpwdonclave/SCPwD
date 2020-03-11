<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_id');
            $table->unsignedBigInteger('tp_id');
            $table->unsignedBigInteger('tc_id')->nullable();
            $table->unsignedBigInteger('scheme_id');
            $table->string('ref_no');
            $table->string('invoice_date');
            $table->boolean('re_assessment')->default(0);

           

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
        Schema::dropIfExists('invoices');
    }
}
