<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchTrainerMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_trainer_map', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bt_id');
            $table->unsignedBigInteger('tr_id');
            $table->string('assign_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batch_trainer_map');
    }
}
