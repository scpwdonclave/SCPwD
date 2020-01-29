<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchCenterCandidateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_center_candidate_maps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bt_id');
            $table->unsignedBigInteger('candidate_id')->comment= 'Center Candidate ID';
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
        Schema::dropIfExists('batch_center_candidate_maps');
    }
}
