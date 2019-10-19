<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tp_id');
            $table->unsignedBigInteger('tr_id');
            $table->unsignedBigInteger('tc_id');
            $table->string('batch_id')->unique()->nullable();
            $table->string('scheme');
            $table->string('job_role');
            $table->string('batch_start_time');
            $table->string('batch_end_time');
            $table->string('assesment_date');
            $table->boolean('status')->default(0);
            $table->boolean('ind_status')->default(0);
            $table->boolean('verified')->default(0); 
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
        Schema::dropIfExists('batches'); 
    }
}
